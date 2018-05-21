<?php
$ordno = $_REQUEST["ordno"];



$filename = $ordno . ".lock";

if (file_exists($filename)) {
    echo "1";
    unlink($filename);
} else {
    echo "2";
}

