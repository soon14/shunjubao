<?php
/**
 * 后台脚本之：自动增量索引
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

if (!Runtime::isCLI()) {
    echo 'It is not run in command line';
    exit;
}

if ($argc == 2) {
	$who = $argv[1];
} else {
	$who = '';
}

$processId = realpath(__FILE__) . "--{$who}";
$timeout = 30 * 60;//30分钟
$alive_time = 2 * 60 * 60;//脚本存活时间为2小时

$objSingleProcess = new SingleProcess($processId, $timeout, true);

if ($objSingleProcess->isRun()) {
    echo "已经有进程在跑了\r\n";
    exit();
}
$objSingleProcess->run();

do {
    if (!isAlive($alive_time)) {
    	break;
    }

    do_something();

    $objSingleProcess->active();

    usleep(1000000);
    echo "休息...\r\n";
} while (true);

$objSingleProcess->complete();

echo "done\r\n";
exit;

function do_something() {
	global $who;
	$objAutoIncrIndexConfig = new AutoIncrIndexConfig();
	$configs = $objAutoIncrIndexConfig->getsByWho($who);

	foreach ($configs as $config) {
		echo "处理配置:{$config['id']}，开始转移表 {$config['src_table']} 数据到 {$config['dst_table']}";
		enter_newline();

		if (isset($config['incr_op_type']) && $config['incr_op_type'] == 'update') {// 增量操作类型：仅更新，如不存在，不插入新记录
			echo "本脚本不处理 incr_op_type 为 update 类型的配置";
			enter_newline(2);
			continue;
		}

		$condition = array();
		if (isset($config['condition']) && is_array($config['condition']) && !empty($config['condition'])) {
			$condition = $config['condition'];
		}
		$condition['update_time'] = SqlHelper::addCompareOperator('>=', $config['prev_update_time']);

		$objSrcClass = new $config['src_class'];
		$objSrcClass->setTableName("`{$config['src_table']}`");
		$objDstClass = new $config['dst_class'];
		$objDstClass->setTableName("`{$config['dst_table']}`");

		$pos = isset($config['pos']) ? $config['pos'] : 0;
		$step = isset($config['step']) ? $config['step'] : 10;

		$step = 200;

		$real_step = $step + 1;// 多取一条，用于判断是否有下一页

		$ids = $objSrcClass->findIdsBy($condition, "{$pos}, {$real_step}", 'update_time asc');

		$records = $objSrcClass->gets($ids);
		$record_count = count($records);
		if (!$records) {
			echo "没有找到符合条件的记录";
			enter_newline();
			continue;
		}

		$tmpLast_time_data = $config['last_time_data'] ? $config['last_time_data'] : array();
		foreach ($ids as $tmpId) {
			if (array_key_exists($tmpId, $tmpLast_time_data)) {
				# 验证数据指纹是否一致
				if (tmp_get_record_fingerprint($records[$tmpId], $config['field_relation']) == $tmpLast_time_data[$tmpId]) {
					echo "{$tmpId}曾转移过，跳过";
					enter_newline();
					if (isset($records[$tmpId])) {
						unset($records[$tmpId]);
					}
				}
			}
		}

		if (!$records) {
			continue;
		}

		$last_update_time = 0;
		$first_update_time = 0;
		foreach ($records as $record) {
			if(!$first_update_time) $first_update_time = $record['update_time'];
			$last_update_time = $record['update_time'];
			$tmpTableInfo = array();
			foreach ($config['field_relation'] as $src_field	=> $dst_field) {
				if (strpos($src_field, '.')) {
					$tmpField = explode('.', $src_field);
					$cpRecord = $record;
					foreach ($tmpField as $field) {
						if (!isset($cpRecord[$field])) {
							echo '错误：源字段中不存在目标字段的值！';
							enter_newline();
							continue;
						}
						$cpRecord = $cpRecord[$field];
					}
					if (!is_scalar($cpRecord)) {
						echo '错误：源字段的值不是有效的标量类型！';
						enter_newline();
						continue;
					}
					$tmpTableInfo[$dst_field] = $cpRecord;
				} else {
					$tmpTableInfo[$dst_field] = isset($record[$src_field])?$record[$src_field]:'';
				}
			}
			if (isset($config['incr_op_type']) && $config['incr_op_type'] == 'update') {// 增量操作类型：仅更新，如不存在，不插入新记录
				$tmpSrcClassPrimaryKey = $objSrcClass->getPrimaryKey();
				echo "仅更新记录:{$record[$tmpSrcClassPrimaryKey]}，更新内容：" . join(",", $tmpTableInfo);
				enter_newline();

				if (isset($config['field_relation'][$tmpSrcClassPrimaryKey])) {
					$tmpDstPrimaryKey = $config['field_relation'][$tmpSrcClassPrimaryKey];
				} else {
					enter_newline(3);
					echo "！！！！！！！！！！！！！！！！！！！！！！！！！！";
					enter_newline();
					echo "错误：字段对应field_relation配置里没有找到源表字段 {$tmpSrcClassPrimaryKey}，无法对目标表更新";
					echo "！！！！！！！！！！！！！！！！！！！！！！！！！！";
					enter_newline();
					enter_newline(3);
					continue;
				}

				$objDstClass->update($tmpTableInfo, array($tmpDstPrimaryKey	=> $record[$tmpSrcClassPrimaryKey]));
			} else {// 增量操作类型：插入记录，如果重复时自动转更新
				echo "转移记录：" . join(",", $tmpTableInfo);
				enter_newline();

				$objDstClass->insertDuplicate($tmpTableInfo);
			}
		}

		$last_time_data = array();
		foreach ($ids as $tmpId) {
			if (!isset($records[$tmpId])) {
				continue;
			}
			if ($records[$tmpId]['update_time'] != $last_update_time) {
				continue;
			}

			$last_time_data[$tmpId] = tmp_get_record_fingerprint($records[$tmpId], $config['field_relation']);
		}

		# 这个机制主要用于同一秒的数据太多，取不尽的问题
		if($first_update_time == $last_update_time && $record_count == $real_step){//同一秒数据过多并且超过10条的情况
			$pos += $step;
		} else {// 取到了下一秒
			$pos = 0;
		}

		$tmpUpdateResult = $objAutoIncrIndexConfig->modify(array(
			'id'	=> $config['id'],
			'prev_update_time'	=> $last_update_time,
			'last_time_data'	=> $last_time_data,
			'pos'				=> $pos,
			'step'				=> $step,
		));
		echo "更新配置";
		enter_newline(2);
	}

	echo "本次循环处理完毕";
	enter_newline(2);
}

/**
 *
 * 获取记录的指纹
 * @param array $record
 * @param array $field_relation
 * @return false | string
 */
function tmp_get_record_fingerprint(array $record, array $field_relation) {
	$tmpTableInfo = array();
	foreach ($field_relation as $src_field	=> $dst_field) {
		if (strpos($src_field, '.')) {
			$tmpField = explode('.', $src_field);
			$cpRecord = $record;
			foreach ($tmpField as $field) {
				if (!isset($cpRecord[$field])) {
//					echo '错误：源字段中不存在目标字段的值！';
					return false;
				}
				$cpRecord = $cpRecord[$field];
			}
			if (!is_scalar($cpRecord)) {
//				echo '错误：源字段的值不是有效的标量类型！';
				return false;
			}
			$tmpTableInfo[$dst_field] = $cpRecord;
		} else {
			$tmpTableInfo[$dst_field] = isset($record[$src_field])?$record[$src_field]:'';
		}
	}
	ksort($tmpTableInfo);

	return Algorithm::md5_16(print_r($tmpTableInfo, true));
}


