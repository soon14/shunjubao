<?php
/**
 * 大乐透 投注数据
 * by zoulongmin 642151532@qq.com
 *
 */
class Daletou {
	/**
	 * 大乐透
	 * @return InternalResultTransfer
	 */
	public function daletousave(array $info) {
		$daletouFront = new DaletouFront();
		
        $tmpResult = $daletouFront->add($info);
        return $tmpResult;
	}
	
	
	public function get_daletou_list($id) {
		$daletouFront = new DaletouFront();
		$tmpResult = $daletouFront->get_daletou_list($id);
		return $tmpResult;
	}

}