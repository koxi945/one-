<?php

namespace App\Services\Home\Soket;

use Exception;
use App\Services\Home\Consts\RedisKey;

class Online {

    private $redisClient;

    public function __construct() {
        $this->initRedisServer();
    }

    public function count($fd, $params, $onType) {
        if(method_exists($this, $onType)) {
            return $this->$onType($fd, $params);
        }
    }

    private function onMessage($fd, $params) {
        if( ! isset($params['uuid'])) return 'uuid not set';
        // 以uuuid为key保存当前的fd
        try {
            $this->redisClient->sadd(RedisKey::BLOG_ONLINE_UUID.$params['uuid'], [$fd]);
            $this->redisClient->sadd(RedisKey::BLOG_ONLINE_MEMBER, [$params['uuid']]);
            $nums = $this->redisClient->scard(RedisKey::BLOG_ONLINE_MEMBER);
        } catch (Exception $e) {
            $nums = 0;
        }
        return $nums;
    }

    private function onClose($fd, $params) {
        $uuidKey = RedisKey::BLOG_ONLINE_UUID.$params['uuid'];
        try {
            //删除当前断开连接的fd
            $this->redisClient->srem($uuidKey, $fd);
            //检测当前uuid集合了的个数，如果为0的话那么，当前在线人数减1
            $fdNums = $this->redisClient->scard($uuidKey);
            if($fdNums == 0) {
                //当前在线人数减1
                $this->redisClient->srem(RedisKey::BLOG_ONLINE_MEMBER, $params['uuid']);
            }
            //取得当前的所有uuid
            $uuidList = $this->redisClient->smembers(RedisKey::BLOG_ONLINE_MEMBER);
            if( ! empty($uuidList) && is_array($uuidList)) {
                $uuidListWithPre = array_map(function($uuid) {
                    return RedisKey::BLOG_ONLINE_UUID.$uuid;
                }, $uuidList);
                // 把对应的uuid的fd集合合并起来
                $this->redisClient->sunionstore(RedisKey::BLOG_ONLINE_FD_UNION, $uuidListWithPre);
            }
            //重新计算人数
            $nums = count($uuidList);
            //取得当前存在的所有fd
            $fdList = $this->redisClient->smembers(RedisKey::BLOG_ONLINE_FD_UNION);
        } 
        catch (Exception $e) {
            $nums = 0;
            $fdList = [];
        }
        return compact('nums', 'fdList');
    }

    private function initRedisServer() {
        $config = require(SWOOLE_SOCKET_BASE_PATH.'/config/swoole.php');
        $server = array(
            'host'     => $config['redis']['default']['host'],
            'port'     => $config['redis']['default']['port'],
            'database' => $config['redis']['default']['database'],
        );
        $this->redisClient = new \Predis\Client($server);
    }

}