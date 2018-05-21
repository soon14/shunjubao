<?php
/**
 * 失败退出
 * @param mixed $data
 */
function failExit($data) {
    echo json_encode(array(
        'status'   => 'F',
        'data'     => $data,
    ));
    exit;
}

/**
 * 成功退出
 * @param mixed $data
 */
function successExit($data) {
    echo json_encode(array(
        'status'   => 'T',
        'data'     => $data,
    ));
    exit;
}