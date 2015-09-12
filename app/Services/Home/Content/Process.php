<?php namespace App\Services\Home\Content;

use Lang, Redis;
use App\Models\Home\Content as ContentModel;
use App\Libraries\Js;
use App\Services\Home\BaseProcess;
use App\Services\Home\Consts\RedisKey;

/**
 * 文章相关处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 阅读榜文章信息
     */
    public function articleTotalHot()
    {
        $list = Redis::zrevrange(RedisKey::ARTICLE_TOTAL_VIEW, 0, 9, 'withscores');
        if( ! is_array($list)) return [];
        $articleIds = [];
        foreach ($list as $key => $value) {
            $tmp = explode(':', $key);
            $articleIds[] = end($tmp);
        }
        $articleList = with(new ContentModel())->getContentInIds($articleIds);
        return $articleList;
    }

}