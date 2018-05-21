<?php
/**
 *
 * 全文检索计数器
 * @author gxg
 *
 */
class SphinxCounter extends DBAbstract {
	protected $tableName = 'sphinx_counter';

	/**
	 *
	 * 设置最后更新时间
	 * @param string $uniq_flag 全量索引唯一标识
	 * @param ing $last_update_time 最后更新时间
	 * @return InternalResultTransfer
	 */
	public function setLastUpdateTime($uniq_flag, $last_update_time) {
		if (!is_scalar($uniq_flag)) {
			return InternalResultTransfer::fail('uniq_flag类型错误');
		}

		$uniq_flag_md5 = Algorithm::md5_16($uniq_flag);
		$tableInfo = array(
			'uniq_flag'			=> $uniq_flag,
			'last_update_time'	=> $last_update_time,
			'uniq_flag_md5'		=> $uniq_flag_md5,
		);

		$tmpReplaceResult = $this->replace($tableInfo);
		if (!$tmpReplaceResult) {
			return InternalResultTransfer::fail("更新数据库失败");
		}
		return InternalResultTransfer::success();
	}

	/**
	 *
	 * 获取最后更新时间的值
	 * @param string $uniq_flag 全量索引唯一标识
	 * @return InternalResultTransfer
	 */
	public function getLastUpdateTime($uniq_flag) {
		if (!is_scalar($uniq_flag)) {
			return InternalResultTransfer::fail('uniq_flag类型错误');
		}

		$uniq_flag_md5 = Algorithm::md5_16($uniq_flag);
		$condition = array(
			'uniq_flag_md5'	=> $uniq_flag_md5,
		);
		$tmpResult = $this->fetchOne($condition);
		if (!$tmpResult) {
			return InternalResultTransfer::fail("获取最后更新时间失败");
		}

		return InternalResultTransfer::success($tmpResult['last_update_time']);
	}
}