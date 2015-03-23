<?php namespace App\Http\Controllers\Home;

use App\Models\Home\Search as SearchModel;
use Request;

/**
 * 博客首页-搜索
 *
 * @author jiang <mylampblog@163.com>
 */
class SearchController extends Controller
{
    /**
     * 博客首页
     */
    public function index()
    {
        $object = new \stdClass();
        $object->keyword = Request::input('keyword');
        exit('kai fa ..');
        return view('home.index.index', compact('articleList', 'page', 'object'));
    }

}