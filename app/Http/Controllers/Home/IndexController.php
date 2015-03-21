<?php namespace App\Http\Controllers\Home;

use App\Models\Home\Content as ContentModel;

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
    	$contentModel = new ContentModel();
    	$articleList = $contentModel->activeArticleInfo();
    	$page = $articleList->render();
        return view('home.index.index', compact('articleList', 'page'));
    }

}