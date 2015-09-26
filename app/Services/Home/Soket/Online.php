<?php

namespace App\Services\Home\Soket;

use Exception;
use App\Services\Home\Consts\RedisKey;

/**
 * 处理博客在线人数的问题
 *
 * @author jiang <mylampblog@163.com>
 */
class Online {

    /**
     * redis 操作对象
     * @var object
     */
    private $redisClient;

    /**
     * 相关的配置
     * @var [type]
     */
    private $config;

    /**
     * 初始化配置和redis服务连接对象
     */
    public function __construct($config) {
        $this->config = $config;
        $this->initRedisServer();
    }

    /**
     * 开始统计
     */
    public function count($fd, $params, $onType) {
        if(method_exists($this, $onType)) {
            return $this->$onType($fd, $params);
        }
    }

    /**
     * 当来消息的时候，这里一般为新用户访问的时候
     */
    private function onMessage($fd, $params) {
        if( ! isset($params['uuid'])) return 'uuid not set';
        // 以uuuid为key保存当前的fd
        try {
            $this->redisClient->sadd(RedisKey::BLOG_ONLINE_UUID.$params['uuid'], [$fd]);
            $this->redisClient->sadd(RedisKey::BLOG_ONLINE_MEMBER, [$params['uuid']]);
            $count = $this->recount();
            $nums = $count['nums'];
            $fdList = $count['fdList'];
        } catch (Exception $e) {
            $nums = 0;
            $fdList = [];
        }
        return compact('nums', 'fdList');
    }

    /**
     * 当用户离开的时候
     */
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
            $count = $this->recount();
            $nums = $count['nums'];
            $fdList = $count['fdList'];
        } 
        catch (Exception $e) {
            $nums = 0;
            $fdList = [];
        }
        return compact('nums', 'fdList');
    }

    /**
     * 无论什么情况，都重新统计一次在线人数，并返回给客户端
     */
    private function recount() {
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
        return compact('nums', 'fdList');
    }

    /**
     * redis 连接对象
     */
    private function initRedisServer() {
        $server = array(
            'host'     => $this->config['redis']['default']['host'],
            'port'     => $this->config['redis']['default']['port'],
            'database' => $this->config['redis']['default']['database'],
        );
        $this->redisClient = new \Predis\Client($server);
    }

}