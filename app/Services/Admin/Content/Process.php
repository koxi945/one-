<?php namespace App\Services\Admin\Content;

use Lang;
use App\Models\Admin\Content as ContentModel;
use App\Models\Admin\TagsRelation as TagsRelationModel;
use App\Models\Admin\Tags as TagsModel;
use App\Models\Admin\ClassifyRelation as ClassifyRelationModel;
use App\Models\Admin\ContentDetail as ContentDetailModel;
use App\Models\Admin\SearchDict as SearchDictModel;
use App\Models\Admin\SearchIndex as SearchIndexModel;
use App\Services\Admin\Content\Validate\Content as ContentValidate;
use App\Services\Admin\SC;
use App\Libraries\Spliter;

/**
 * 文章处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process
{
    /**
     * 文章模型
     * 
     * @var object
     */
    private $contentModel;

    /**
     * 文章副表模型
     * 
     * @var object
     */
    private $contentDetailModel;

    /**
     * 文章表单验证对象
     * 
     * @var object
     */
    private $contentValidate;

    /**
     * 错误的信息
     * 
     * @var string
     */
    private $errorMsg;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->contentModel) $this->contentModel = new ContentModel();
        if( ! $this->contentDetailModel) $this->contentDetailModel = new ContentDetailModel();
        if( ! $this->contentValidate) $this->contentValidate = new ContentValidate();
    }

    /**
     * 增加新的文章
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addContent($data)
    {
        if( ! $this->contentValidate->add($data))
        {
            $this->errorMsg = $this->contentValidate->getMsg();
            return false;
        }
        $object = new \stdClass();
        $object->time = time();
        $object->userId = SC::getLoginSession()->id;
        try
        {
            $result = \DB::transaction(function() use ($data, $object)
            {
                $object->contentAutoId = $this->saveContent($data, $object);
                $this->saveContentDetail($data, $object);
                $this->saveArticleTags($object, $data['tags']);
                $this->saveArticleClassify($object, $data['classify']);
                $this->saveSeachFullText($object, $data);
                return true;
            });
        }
        catch (\Exception $e)
        {
            $result = false;
        }
        if($result) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
    }

    /**
     * 保存文章的分类
     * 
     * @param int $articleId 文章的ID
     * @param array $classify 分类
     */
    private function saveArticleClassify($object, $classify)
    {
        $articleId = $object->contentAutoId;
        $result = $this->deleteArticleClassifyById($articleId);
        if($result === false) throw new \Exception("delete article classify error.");
        foreach($classify as $key => $classifyId)
        {
            $result = (new ClassifyRelationModel())->addClassifyArticleRelation($articleId, $classifyId);
            if( ! $result) throw new \Exception("add classify article relation error.");
        }
    }

    /**
     * 根据文章的ID删除它的分类
     * 
     * @return boolean true|false
     */
    public function deleteArticleClassifyById($articleId)
    {
        if( ! is_numeric($articleId)) throw new \Exception("article id is not num.");
        $articleId = array($articleId);
        return (new ClassifyRelationModel())->deleteClassifyRelation($articleId);
    }

    /**
     * 保存文章的标签
     *
     * @param int $articleId 文章的ID
     * @param array $tags 标签
     */
    private function saveArticleTags($object, $tags)
    {
        $articleId = $object->contentAutoId;
        $result = $this->deleteArticleTagsById($articleId);
        if($result === false) throw new \Exception("delete article tags error.");
        foreach($tags as $tagName)
        {
            $tagInfo = (new TagsModel())->addTagsIfNotExistsByName($tagName);
            if( ! $tagInfo->id) throw new \Exception("add tags if not exists by name error.");
            $result = (new TagsRelationModel())->addTagsArticleRelation($articleId, $tagInfo->id);
            if( ! $result) throw new \Exception("add tags article relation error.");
        }
    }

    /**
     * 根据文章的ID删除它的标签
     * 
     * @return boolean true|false
     */
    public function deleteArticleTagsById($articleId)
    {
        if( ! is_numeric($articleId)) throw new \Exception("article id is not num.");
        $articleId = array($articleId);
        return (new TagsRelationModel())->deleteTagsRelation($articleId);
    }

    /**
     * 保存到主表
     * 
     * @param  array $data
     * @return int 自增的ID
     */
    private function saveContent($data, $object)
    {
        $dataContet['is_delete'] = ContentModel::IS_DELETE_NO;
        $dataContet['write_time'] = $object->time;
        $dataContet['user_id'] = $object->userId;
        $dataContet['title'] = $data['title'];
        $dataContet['status'] = $data['status'];
        $dataContet['summary'] = $data['summary'];
        $insertObject = $this->contentModel->addContent($dataContet);
        if( ! $insertObject->id) throw new \Exception("save content error");
        return $insertObject->id;
    }

    /**
     * 保存到副表
     * 
     * @param  array $data
     * @return object
     */
    private function saveContentDetail($data, $object)
    {
        $detailData['content'] = $data['content'];
        $detailData['user_id'] = $object->userId;
        $detailData['time'] = $object->time;
        $detailData['article_id'] = $object->contentAutoId;
        $insertObject = $this->contentDetailModel->addContentDetail($detailData);
        if( ! $insertObject) throw new \Exception("save content detail error");
        return $insertObject;
    }

    /**
     * 删除文章
     * 
     * @param array $ids
     * @access public
     * @return boolean true|false
     */
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        $data['is_delete'] = ContentModel::IS_DELETE_YES;
        if($this->contentModel->solfDeleteContent($data, $ids) !== false) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
    }

    /**
     * 编辑文章
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editContent($data, $id)
    {
        if( ! $this->contentValidate->edit($data))
        {
            $this->errorMsg = $this->contentValidate->getMsg();
            return false;
        }
        $object = new \stdClass();
        $object->contentAutoId = $id;
        try
        {
            $result = \DB::transaction(function() use ($data, $id, $object)
            {
                $this->updateContent($data, $id);
                $this->updateContentDetail($data, $id);
                $this->saveArticleTags($object, $data['tags']);
                $this->saveArticleClassify($object, $data['classify']);
                $this->saveSeachFullText($object, $data);
                return true;
            });
        }
        catch (\Exception $e)
        {
            //dd($e->getMessage());
            $result = false;
        }
        if($result) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
    }

    /**
     * 保存到主表
     * 
     * @param  array $data
     * @return int 自增的ID
     */
    private function updateContent($data, $id)
    {
        $dataContet['title'] = $data['title'];
        $dataContet['status'] = $data['status'];
        $dataContet['summary'] = $data['summary'];
        $result = $this->contentModel->editContent($dataContet, $id);
        if($result === false) throw new \Exception("save content error");
        return $result;
    }

    /**
     * 保存到副表
     * 
     * @param  array $data
     * @return object
     */
    private function updateContentDetail($data, $id)
    {
        $detailData['content'] = $data['content'];
        $result = $this->contentDetailModel->editContentDetail($detailData, $id);
        if($result === false) throw new \Exception("save content detail error");
        return $result;
    }

    /**
     * 更新查询索引表
     * 
     * @param  object $object
     * @param  array $data
     * @param boolean $isEdit false的时候为增加，true的时候为edit
     * @return boolean
     */
    private function saveSeachFullText($object, $data, $isEdit = false)
    {
        $spliterObject = new Spliter();
        $titleSplited   = $spliterObject->utf8Split($data['title']);
        $index['title']   = $titleSplited['words'];
        $contentSplited = $spliterObject->utf8Split(strip_tags($data['content']));
        $index['content'] = $contentSplited['words'];
        $summarySplited = $spliterObject->utf8Split(strip_tags($data['summary']));
        $index['summary'] = $summarySplited['words'];
        $index['article_id'] = $checkIndex['article_id'] = $object->contentAutoId;
        
        if($isEdit === false) $index['added_date'] = $index['edited_date'] = time();
        if($isEdit === true) $index['edited_date'] = time();

        $this->saveDict($titleSplited['dict'] + $contentSplited['dict']);
        $indexModel = new SearchIndexModel();
        $result = $indexModel->saveIndex($checkIndex, $index);
        if($result === false) throw new Exception("save article dict index error.");
    }

    /**
     * 保存到词典中
     * 
     * @param  array $dict 要新加的词
     * @return void
     */
    private function saveDict($dict)
    {
        $dictModel = new SearchDictModel();
        foreach($dict as $key => $value)
        {
            if( ! is_numeric($key) or empty($value) or strlen($key) != 5) continue;
            $checkDict = $data = array('key' => $key, 'value' => $value);
            $result = $dictModel->saveDict($checkDict, $data);
            if($result === false) throw new Exception("save article dict error.");
        }
    }

    /**
     * 取得错误的信息
     *
     * @access public
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMsg;
    }

}