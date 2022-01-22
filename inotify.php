<?php
/*
 * @desc : inotify php under UNIX
 * */

class Inotify
{

    private $oInotifyFd = null;

    /*
     * @desc : 初始化inotify资源（init a inotify object）
     * */
    public function __construct()
    {
        if (null == $this->oInotifyFd) {
            $oNotifyFd = inotify_init();
            if (false === $oNotifyFd) {
                throw new Exception("初始化inotify失败.");
            }
            $this->oInotifyFd = $oNotifyFd;
        }
    }

    /*
     * @desc : 将试图监听的文件或者文件夹添加到监听
     * @param : $sFile，要监听的文件夹或者文件
     * @param : $iEventType，要监听的事件类型，默认为IN_ALL_EVENTS
     * */
    public function addFile2Watch($sFile, $iEventType = IN_ALL_EVENTS)
    {
        $iNotifyFd = $this->oInotifyFd;
        $iWatchFd = inotify_add_watch($iNotifyFd, $sFile, $iEventType);
        if (!$iWatchFd) {
            throw new Exception("将{$sFile}添加到{$iNotifyFd}失败.");
        }
    }

    public function monitor()
    {
        $aEvents = inotify_read($this->oInotifyFd);
        return $aEvents;
    }
}