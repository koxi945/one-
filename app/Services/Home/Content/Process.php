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
        $articleIds = [];
        try { $articleIds = Redis::zrevrange(RedisKey::ARTICLE_TOTAL_VIEW, 0, 9); } catch (Exception $e) {}

        if(empty($articleIds)) return [];
        $articleList = with(new ContentModel())->getContentInIds($articleIds);
        $result = [];
        foreach ($articleIds as $articleId) {
            foreach ($articleList as $akey => $articleInfo) {
                if ($articleInfo['id'] == $articleId) {
                    $result[] = $articleInfo;
                }
            }
        }
        return $result;
    }

    /**
     * 最近七天的阅读榜
     */
    public function articleLastSevenHot()
    {
        $days = $this->getSevenDays();
        $keys = array_map(function($date){
            return RedisKey::ARTICLE_EVERY_DAY_VIEW . $date;
        }, $days);
        $weight = [1, 1, 1, 1, 1, 1, 1];

        $articleIds = [];
        try {
            $sevenScore = Redis::zunionstore(RedisKey::ARTICLE_SEVEN_DAY_HOT, $keys, [ 'WEIGHTS' => $weight ]);
            $articleIds = Redis::zrevrange(RedisKey::ARTICLE_SEVEN_DAY_HOT, 0, 9);
        } catch (Exception $e) {}

        if(empty($articleIds)) return [];
        $articleList = with(new ContentModel())->getContentInIds($articleIds);
        $result = [];
        foreach ($articleIds as $articleId) {
            foreach ($articleList as $akey => $articleInfo) {
                if ($articleInfo['id'] == $articleId) {
                    $result[] = $articleInfo;
                }
            }
        }
        return $result;
    }

    /**
     * 取得最近七天的日期
     */
    private function getSevenDays()
    {
        $today = date('Ymd');
        $days = [];
        for($i = 0; $i < 7; $i++ )
        {
            $days[] = $today - $i;
        }
        return $days;
    }

}