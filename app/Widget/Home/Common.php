<?php

namespace App\Widget\Home;

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
     * comment
     */
    public function comment($objectID, $objectType = \App\Models\Home\Comment::OBJECT_TYPE)
    {
        $commemtModel = new \App\Models\Home\Comment();
        $commentList = $commemtModel->getContentByObjectId($objectID, $objectType);
        return view('home.widget.comment', compact('commentList'));
    }


}