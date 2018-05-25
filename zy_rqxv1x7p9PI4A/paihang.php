<?php
/**
 * 排行榜
 */
include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';

$TEMPLATE['title'] = '聚宝网聚宝中奖排行';
$TEMPLATE['keywords'] = '聚宝中奖排行榜,聚宝网,聚宝彩票,竞彩足球,北京单场,竞彩篮球,聚宝大力水手,聚宝红姐,聚宝竞彩熊超,聚宝竞彩小仙,聚宝奶茶,聚宝头号红人,聚宝半边芸,聚宝专注2串1。';
$TEMPLATE['description'] = '聚宝网聚宝中奖排行榜';

$type = Request::r('type');

if (!in_array($type, array(1,2,5,6))) {
	$type = 1;
}

$objPrizeRankFront = new PrizeRankFront();

$condition = array();
$issue = $objPrizeRankFront->getCurrentIssueByType($type);
$condition['issue'] = $issue;
$condition['type'] = $type;

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 50;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

if ($page == 1) {
	$offset += 5;
	$real_size -= 5;
}
$limit = "{$offset},{$real_size}";
$order = 'rank asc';//按排名降序

$paihangtopranks = $objPrizeRankFront->findBy($condition, null, 5, '*', $order);//排行榜排名前5的用户

$ranks = $objPrizeRankFront->findBy($condition, null, $limit, '*', $order);//
//当前排行不存在时，取前一期
if (!$paihangtopranks) {
	$condition['issue'] = $issue - 1;
	$ranks = $objPrizeRankFront->findBy($condition, null, $limit, '*', $order);
	$paihangtopranks = $objPrizeRankFront->findBy($condition, null, 5, '*', $order);
}

$topranks = $objPrizeRankFront->findBy(array('type'=>PrizeRankFront::RANK_TYPE_ALL_USERS), null, 5, '*',$order);//总中奖金额排名前5的用户

//每页的总数
$count = count($ranks) + count($paihangtopranks);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;

$args['type'] = $type;

if ($previousPage) {
	$args['page'] = $previousPage;
	$previousUrl = jointUrl(ROOT_DOMAIN."/ticket/paihang.php", $args);
}
$nextPage = false;
if ($count > $size) {
	$nextPage = $page + 1;
	array_pop($ranks);// 删除多取的一个
}
if ($nextPage) {
	$args['page'] = $nextPage;
	$nextUrl = jointUrl(ROOT_DOMAIN."/ticket/paihang.php", $args);
}

//合并数组
$uids = array();
foreach ($ranks as $key=>$value) {
	$uids[] = $value['u_id'];
}
foreach ($paihangtopranks as $key=>$value) {
	$uids[] = $value['u_id'];
}
foreach ($topranks as $key=>$value) {
	$uids[] = $value['u_id'];
}
$objUserMemberFront = new UserMemberFront();
$users = $objUserMemberFront->gets($uids);
//获取累计奖金
$condition = array();
$condition['u_id'] = $uids;
$condition['type'] = PrizeRankFront::RANK_TYPE_ALL_USERS;
$all_prize_info = $objPrizeRankFront->findBy($condition,'u_id');
//获取积分
$objUserAccountFront = new UserAccountFront();
$userAccountInfos = $objUserAccountFront->gets($uids);

$tpl = new Template();
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('userAccountInfos', $userAccountInfos);
$tpl->assign('users', $users);
$tpl->assign('ranks', $ranks);
$tpl->assign('topranks', $topranks);
$tpl->assign('type', $type);
$tpl->assign('paihangtopranks', $paihangtopranks);
$tpl->assign('all_prize_info', $all_prize_info);
$tpl->d('paihang');