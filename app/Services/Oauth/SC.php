<?php namespace App\Services\Oauth;

use Session;

class SC {

    /**
     * oauth_stat
     */
    CONST OAUTH_STAT = 'OAUTH_STAT';

    /**
     * set oauth stat
     */
    static public function setOauthStat($stat)
    {
        return Session::put(self::OAUTH_STAT, $stat);
    }

    /**
     * get oauth stat
     */
    static public function getOauthStat()
    {
        return Session::get(self::OAUTH_STAT);
    }

    /**
     * del oauth session
     */
    static public function delOauthStat()
    {
        return Session::forget(self::OAUTH_STAT);
    }

}