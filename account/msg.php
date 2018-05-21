<?php
/*
 * 账户余额
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$uid = Runtime::getUid();
$tpl = new Template();
$title = "我的消息 -";
$TEMPLATE['title'] = $title;
$tpl->assign('cur_tab', 'msg');

$objAccountFront = new AccountFront();
$accountInfo = $objAccountFront->get($uid);
if($accountInfo)
{
    $tpl->assign('balance', ConvertData::toMoney($accountInfo["balance"]/100));

    //判断是否上一页时用到了$firstPage
    $firstPage = 1;
    $page = Request::varGetInt('page', $firstPage);
    //判断是否下一页时用到了$size
    $size = 10;
    $offset = ($page-1) * $size;
    $real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录
    $limit = "{$offset}, {$real_size}";

    $objAccountLogsFront = new AccountLogsFront();
    $logs = $objAccountLogsFront->getsByUid($uid, $limit);
    if($logs)
    {
        $logsDesc = $objAccountLogsFront->getLogsDesc();
        //分页
        $previousPage = $page <= $firstPage ? FALSE : $page-1 ;
        if ($previousPage) {
            $previousUrl = ROOT_DOMAIN."/account/account.php?page={$previousPage}";
        }
        $nextPage = false;
        if (count($logs) > $size) {
            $nextPage = $page+1;
            array_pop($logs);// 删除多取的一个
        }
        if ($nextPage) {
            $nextUrl = ROOT_DOMAIN."/account/account.php?page={$nextPage}";
        }

        $tpl->assign('logsDesc',$logsDesc);
        $tpl->assign('previousPage', $previousPage);
        $tpl->assign('previousUrl', $previousUrl);
        $tpl->assign('nextPage', $nextPage);
        $tpl->assign('nextUrl', $nextUrl);
        $tpl->assign('logs', $logs);
    }
}
else
{
    $tpl->assign('balance', 0);
}

$YOKA['output'] = $tpl->r('msg');
echo_exit($YOKA['output']);
