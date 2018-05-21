<?php
/**
 * 更新排行榜
 */
include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';

$objPrizeRankFront = new PrizeRankFront();
$objPrizeRankFront->updateALLRank();

echo 'success';
exit;