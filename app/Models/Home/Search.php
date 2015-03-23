<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;
use App\Models\Home\SearchDict as SearchDictModel;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 文章表模型
 *
 * @author jiang
 */
class Search extends Model
{
    /**
     * 文章未删除的标识
     */
    CONST IS_DELETE_NO = 1;

    /**
     * 文章发布的标识
     */
    CONST STATUS_YES = 1;

    /**
     * 文章数据表名
     *
     * @var string
     */
    protected $table = 'search_index';

    /**
     * 表前缀
     * 
     * @var string
     */
    private $prefix;

    /**
     * dict model object
     * 
     * @var object
     */
    private $dictModelObject;

    /**
     * 临时保存，避免多次查询
     * 
     * @var [type]
     */
    private $dictDataCache;

    /**
     * 搜索查询取得文章列表信息
     * 
     * @return array
     */
    public function activeArticleInfoBySearch($object)
    {
        //\DB::connection()->enableQueryLog();

        $this->prefix = \DB:: getTablePrefix();
        $searchIndexColumn = "{$this->prefix}search_index.title as title,{$this->prefix}search_index.summary as summary,{$this->prefix}search_index.content as content, ";
        $scoreColumn = $searchIndexColumn."((1 * (MATCH({$this->prefix}search_index.title) AGAINST('{$object->against}' IN BOOLEAN MODE))) + (0.6 * (MATCH({$this->prefix}search_index.title) AGAINST('{$object->against}' IN BOOLEAN MODE))) ) as score";
        $mainColumn = $this->prefix.'article_main.*';
        $classifyColumn = 'group_concat(DISTINCT '.$this->prefix.'article_classify.name) as classnames';
        $tagsColumn = 'group_concat(DISTINCT '.$this->prefix.'article_tags.name) as tagsnames';
        $currentQuery = $this->select(\DB::raw($mainColumn.','.$classifyColumn.','.$tagsColumn.','.$scoreColumn))
                        ->leftJoin('article_main', 'search_index.article_id', '=', 'article_main.id')
                        ->leftJoin('article_classify_relation', 'article_classify_relation.article_id', '=', 'article_main.id')
                        ->leftJoin('article_classify', 'article_classify_relation.classify_id', '=', 'article_classify.id')
                        ->leftJoin('article_tag_relation', 'article_tag_relation.article_id', '=', 'article_main.id')
                        ->leftJoin('article_tags', 'article_tag_relation.tag_id', '=', 'article_tags.id')
                        ->where('article_main.is_delete', self::IS_DELETE_NO)->where('article_main.status', self::STATUS_YES)
                        ->whereRaw("MATCH({$this->prefix}search_index.title,{$this->prefix}search_index.summary,{$this->prefix}search_index.content) AGAINST('+{$object->against}' IN BOOLEAN MODE) >= 1")
                        ->groupBy('article_main.id')
                        ->orderBy('article_main.id', 'desc');
        $total = $currentQuery->get()->count();
        $currentQuery->forPage(
            $page = Paginator::resolveCurrentPage(),
            $perPage = 1
        );

        $data = $currentQuery->get()->all();
        foreach($data as $record)
        {
            $markWord = $this->markKeywords($record->title, $object->words);
            $record->title   = str_replace('</span> ', '</span>', $this->decode($markWord));
            $record->summary = $this->getSummary($record->summary, $object->words);
        }
        //$queries = \DB::getQueryLog();
        //dd($total, $queries);

        return new LengthAwarePaginator($data, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }

    /**
     * 把unicode解码为正常的字
     *
     * notic: this function is from chanzhi. modified by me at 2015.3.23
     * 
     * @param  string    $string 
     * @access public
     * @return void
     */
    public function decode($string)
    {
        if(strpos($string, ' ') === false and !is_numeric($string)) return $string;
        if( ! $this->dictModelObject)
        {
            $this->dictModelObject = new SearchDictModel();
            $this->dictDataCache = $this->dictModelObject->getDict();
        }
        $dict   = $this->dictDataCache;
        $dict['|'] = '';
        return str_replace(array_keys($dict), array_values($dict), $string . ' ');
    }

    /**
     * 把简介或内容查询到的内容标成红色.
     * 
     * notic: this function is from chanzhi
     * 
     * @param  string    $content 
     * @param  string    $words 
     * @access public
     * @return string
     */
    public function getSummary($content, $words)
    {
        $length = 130000;
        if(strlen($content) <= $length) return $this->decode($this->markKeywords($content, $words));

        $content = $this->markKeywords($content, $words);
        preg_match_all("/\<span class='text-danger'\>.*?\<\/span\>/", $content, $matches);

        if(empty($matches[0])) return $this->decode($this->markKeywords(substr($content, 0, $length), $words));

        $matches = $matches[0];
        $score   = 0;
        $needle  = '';
        foreach($matches as $matched) 
        {
            if(strlen($matched) > $score) 
            {
                $content = str_replace($needle, strip_tags($needle), $content);
                $needle  = $matched;
                $score   = strlen($matched);
            }
        }

        $content = str_replace('<span class', ' <spanclass', $content);
        $content = explode(' ', $content);

        $pos     = array_search(str_replace('<span class', '<spanclass', $needle), $content);

        $start   = max(0, $pos - ($length / 2));
        $summary = join(' ', array_slice($content, $start, $length));
        $summary = str_replace('<spanclass', '<span class', $summary);
 
        $summary = $this->decode($summary);
        $summary = str_replace('</span> ', '</span>', $summary);
        return $summary;
    }

    /**
     * 把查到的字标成红色
     *
     * notic: this function is from chanzhi
     * 
     * @param  string    $content 
     * @param  string    $keywords 
     * @access public
     * @return void
     */
    public function markKeywords($content, $keywords)
    {
        $words = explode(' ', trim($keywords, ' '));
        $markedWords = array();
        foreach($words as $key => $word)
        {
            if(is_numeric($words)) $words[$key] = $word . ' ';
            if(!is_numeric($words)) $words[$key] = $word;
            $markedWords[] = "<span class='text-danger'>" . $this->decode($word) . "</span > ";
        }
        $content = str_replace($words, $markedWords, $content . ' ');
        $content = str_replace("</span > <span class='text-danger'>", '', $content);
        $content = str_replace("</span >", '</span>', $content);
        return $content;
    }


}
