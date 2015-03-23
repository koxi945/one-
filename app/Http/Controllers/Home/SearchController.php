<?php namespace App\Http\Controllers\Home;

use App\Models\Home\Search as SearchModel;
use Request;
use App\Libraries\Spliter;

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
        $spliter = new Spliter();
        $object->keyword = Request::input('keyword');

        $keywords = explode(' ', $object->keyword);
        $object->against = '';
        foreach($keywords as $kw)
        {
            $splitedWords = $spliter->utf8Split($kw);
            $object->against .= '"' . $splitedWords['words'] . '"'; 
        }
        $object->words = str_replace('"', '', $object->against);

        //dd($object);

    	$searchModel = new SearchModel();
    	$articleList = $searchModel->activeArticleInfoBySearch($object);
    	$page = $articleList->appends(Request::all())->render();
        return view('home.index.index', compact('articleList', 'page', 'object'));
    }

}