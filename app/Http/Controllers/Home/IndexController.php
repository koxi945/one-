<?php namespace App\Http\Controllers\Home;

use App\Models\Home\Content as ContentModel;
use Request;

/**
 * 博客首页
 *
 * @author jiang <mylampblog@163.com>
 */
class IndexController extends Controller
{
    /**
     * 博客首页
     */
    public function index()
    {
        $object = new \stdClass();
        $object->category = (int) Request::route('categoryid');
        $object->tag = (int) Request::route('tagid');
    	$contentModel = new ContentModel();
    	$articleList = $contentModel->activeArticleInfo($object);
    	$page = $articleList->setPath('')->appends(Request::all())->render();
        return header_cache(view('home.index.index', compact('articleList', 'page', 'object')));
    }

    /**
     * 文章内页
     */
    public function detail()
    {
        $articleId = (int) Request::route('id');
        $contentModel = new ContentModel();
        $info = $contentModel->getContentDetailByArticleId($articleId);
        event(new \App\Events\Home\ArticleView($articleId));
        return header_cache(view('home.index.detail', compact('info')));
    }

}