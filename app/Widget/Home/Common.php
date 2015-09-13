<?php

namespace App\Widget\Home;

use Redis;
use App\Services\Home\Consts\RedisKey;

/**
 * 小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Common
{
    /**
     * footer
     */
    public function footer()
    {
        return view('home.widget.footer');
    }

    /**
     * header
     */
    public function header($headerObject = false)
    {
        return view('home.widget.header', compact('headerObject'));
    }

    /**
     * top
     */
    public function top()
    {
        $object = new \stdClass();
        $object->keyword = \Request::input('keyword');
        return view('home.widget.top', compact('object'));
    }

    /**
     * right
     */
    public function right()
    {
        $classifyModel = new \App\Models\Home\Classify();
        $tagsModel = new \App\Models\Home\Tags();
        $classifyInfo = $classifyModel->activeCategory();
        $tagsInfo = $tagsModel->activeTags();
        return view('home.widget.right', compact('classifyInfo', 'tagsInfo'));
    }

    /**
     * 最新评论
     */
    public function newComment()
    {
        $commemtModel = new \App\Models\Home\Comment();
        $list = $commemtModel->getNewComment();
        return view('home.widget.newcomment', compact('list'));
    }

    /**
     * 七天浏览排行傍
     */
    public function servenDayHot()
    {
        $list = [];
        try
        {
            //try for redis server crash
            $contentProcess = new \App\Services\Home\Content\Process();
            $list = $contentProcess->articleLastSevenHot();
        }
        catch(\Exception $e)
        {
            //do some log
        }
        return view('home.widget.servendayhot');
    }

    /**
     * 全部文章的浏览排行
     */
    public function totalHot()
    {
        $list = [];
        try
        {
            //try for redis server crash
            $contentProcess = new \App\Services\Home\Content\Process();
            $list = $contentProcess->articleTotalHot();
        }
        catch(\Exception $e)
        {
            //do some log
        }
        return view('home.widget.totalhot', compact('list'));
    }

    /**
     * 博客统计
     */
    public function tongJi()
    {
        return view('home.widget.tongji');
    }

    /**
     * comment
     */
    public function comment($objectID, $objectType = \App\Models\Home\Comment::OBJECT_TYPE_ARTICLE)
    {
        $commemtModel = new \App\Models\Home\Comment();
        $commentProcess = new \App\Services\Home\Comment\Process();
        $commentList = $commemtModel->getContentByObjectId($objectID, $objectType);
        $replyIds = $commentProcess->prepareReplyIds($commentList);
        $replyComments = $commemtModel->getContentsByObjectIds($replyIds, $objectType);
        $commentList = $commentProcess->joinReplyComments($commentList, $replyComments);
        //dd($commentList);
        return view('home.widget.comment', compact('commentList', 'objectID', 'objectType'));
    }

    /**
     * comment ajax
     */
    public function commentAjax($objectId)
    {
        return view('home.widget.commentAjax', compact('objectId'));
    }

    /**
     * htmlend
     */
    public function htmlend()
    {
        return '</body></html>';
    }


}