<?php

namespace App\Listeners\Home;

use App\Events\Home\ArticleView as EventsArticleView;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Home\Consts\RedisKey;
use Request, Redis;

class ArticleView
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  EventsArticleView  $event
     * @return void
     */
    public function handle(EventsArticleView $event)
    {
        $this->setArticleViews($event->articleId);
        $this->setArticleTotalViews($event->articleId);
        $this->setEveryDayViews($event->articleId);
    }

    /**
     * 设置文章的点击量
     */
    private function setArticleViews($articleId)
    {
        Redis::incr(RedisKey::ARTICLE_DETAIL_VIEW_ID.$articleId);
    }

    /**
     * 阅读总傍
     */
    private function setArticleTotalViews($articleId)
    {
        Redis::zincrby(RedisKey::ARTICLE_TOTAL_VIEW, 1, $articleId);
    }

    /**
     * 记录每天每片文章的浏览量，暂时用于七天阅读榜的数量来源
     */
    private function setEveryDayViews($articleId)
    {
        $today = date('Ymd');
        Redis::zincrby(RedisKey::ARTICLE_EVERY_DAY_VIEW.$today, 1, $articleId);
    }

}
