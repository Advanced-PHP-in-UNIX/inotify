<?php
/*
 A example for Tail(php-tail like tail -f in UNIX/Linux) use of php-inotify
 基于php inotify实现一个类似于tail -f的工具
 * */

require_once "./inotify.php";
$sLogFile = "./test.log";
$iLogFileSize = filesize($sLogFile);
$iLogPostion  = $iLogFileSize;
$rLogFile     = fopen($sLogFile, "r");
fseek($rLogFile, $iLogPostion);
$sLogContent  = '';
$fCallback = function ($aCbParam) {
    $rLogFile = $aCbParam['handler'];
    while(false == feof($rLogFile)) {
        $sContent = fread($rLogFile, 1024);
    }
    $iPostion = ftell($rLogFile);
    fseek($rLogFile, $iPostion);
    echo $sContent;
};
$aCbParam = array(
    'handler' => $rLogFile,
);



$oInotify = new Inotify();
$oInotify->addFile2Watch("./test.log", IN_MODIFY, $fCallback, $aCbParam);
//$oInotify->addFile2Watch("./test.log", IN_CLOSE_WRITE, $fCallback);
$oInotify->run();