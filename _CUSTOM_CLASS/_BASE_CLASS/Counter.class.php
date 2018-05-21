<?php
/**
 *
 * 通用的计数器方案
 * @author gaoxiaogang@gmail.com
 *
 */
class Counter extends DBAbstract {
	protected $tableName = 'counter';

	/**
	 *
	 * 给 $uniq_flag 指定的计数器递增 $amount
	 * @param string $uniq_flag 计数器的唯一标识。
	 * 该值由调用方维护。建议这个标识的构造方式为：
	 * 调用方姓名 + "_" + "项目标识"。
	 * 比如 'gaoxiaogang_wms_sku'
	 *
	 * @param int $amount 递增的数量
	 * @return InternalResultTransfer 失败时：data里含失败原因；成功时：data里含最后生成的id
	 */
	public function generate($uniq_flag, $amount = 1) {
		if (!is_scalar($uniq_flag)) {
			return InternalResultTransfer::fail('uniq_flag类型错误');
		}

		# 至少要生成1张
		if (!Verify::unsignedInt($amount)) {
			return InternalResultTransfer::fail('参数amount错误');
		}

		$strTransactionId = $this->db->startTransaction();

		$tableInfo = array(
			'uniq_flag'	=> $uniq_flag,
			'uniq_flag_md5'	=> Algorithm::md5_16($uniq_flag),
			'counter'		=> $amount,
		);
		$onDuplicate = array(
			'counter'	=> SqlHelper::wrapperNoQuote("last_insert_id(`counter` + {$amount})"),
		);
		$tmpResult = $this->insertDuplicate($tableInfo, $onDuplicate);
		if (!$tmpResult) {
			$this->db->rollback($strTransactionId);
			return InternalResultTransfer::fail('执行insertDuplicate时失败');
		}

		$affectedRows = $this->db->affectedRows();
		if (!Verify::unsignedInt($affectedRows)) {
			$this->db->rollback($strTransactionId);
			return InternalResultTransfer::fail('获取的affectedRows不是整数');
		}
		if ($affectedRows == 1) {// insert
			if (!$this->db->commit($strTransactionId)) {
				return InternalResultTransfer::fail("提交事务失败");
			}
			return InternalResultTransfer::success($amount);
		} else {// on duplicate
			$last_insert_id = $this->db->getLastInsertId();
			if (!Verify::unsignedInt($last_insert_id)) {
				$this->db->rollback($strTransactionId);
				return InternalResultTransfer::fail('获取的last_insert_id不是整数');
			}

			if (!$this->db->commit($strTransactionId)) {
				return InternalResultTransfer::fail("提交事务失败");
			}
			# 返回生成后的最大的值
			return InternalResultTransfer::success($last_insert_id);
		}
	}

	/**
	 *
	 * 获取计数器的值
	 * @param string $uniq_flag 计数器唯一标识
	 * @return InternalResultTransfer
	 */
	public function getCounter($uniq_flag) {
		if (!is_scalar($uniq_flag)) {
			return InternalResultTransfer::fail('uniq_flag类型错误');
		}

		$uniq_flag_md5 = Algorithm::md5_16($uniq_flag);
		$condition = array(
			'uniq_flag_md5'	=> $uniq_flag_md5,
		);
		$tmpResult = $this->fetchOne($condition);
		if (!$tmpResult) {
			return InternalResultTransfer::fail("获取计数器失败");
		}

		return InternalResultTransfer::success($tmpResult['counter']);
	}

}