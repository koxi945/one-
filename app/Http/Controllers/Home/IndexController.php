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
        $object->category = (int) Request::input('category');
        $object->tag = (int) Request::input('tag');
    	$contentModel = new ContentModel();
    	$articleList = $contentModel->activeArticleInfo($object);
    	$page = $articleList->render();
        return view('home.index.index', compact('articleList', 'page', 'object'));
    }

}