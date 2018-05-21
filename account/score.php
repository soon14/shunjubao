<?php 
/**
 * 个人积分记录查看页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

#需要登录
Runtime::requireLogin();

$u_id = Runtime::getUid();

$condition = array();
$condition['u_id'] = $u_id;

$limit = null;
$order = 'create_time desc';

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 20;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;

if ($previousPage) {
    $previousUrl = ROOT_DOMAIN."/passport/score.php?page={$previousPage}";
}
$nextPage = false;

$objUserAccountFront = new UserAccountFront();
$account = $objUserAccountFront->get($u_id);

$objUserScoreLogFront = new UserScoreLogFront();
$scores = $objUserScoreLogFront->getsByCondition($condition, "{$offset},{$real_size}", 'create_time desc');

if (count($scores) > $size) {
    $nextPage = $page+1;
    array_pop($account_logs);// 删除多取的一个
}
if ($nextPage) {
    $nextUrl = ROOT_DOMAIN."/passport/score.php?page={$nextPage}";
}


$tpl = new Template();

$title = "";

$TEMPLATE['title'] = $title;
$tpl->assign('account_logs',$account_logs);
$tpl->assign('previousPage', $previousPage);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextPage', $nextPage);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('account',$account);
$tpl->assign ('scores', $scores );

echo_exit($tpl->r('socre'));

?>