<?php namespace App\Services\Admin\Category;

use Lang;
use App\Models\Admin\Category as CategoryModel;
use App\Services\Admin\Category\Validate\Category as CategoryValidate;

/**
 * 文章分类处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process
{
    /**
     * 分类模型
     * 
     * @var object
     */
    private $categoryModel;

    /**
     * 分类表单验证对象
     * 
     * @var object
     */
    private $categoryValidate;

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
        if( ! $this->categoryModel) $this->categoryModel = new CategoryModel();
        if( ! $this->categoryValidate) $this->categoryValidate = new CategoryValidate();
    }

    /**
     * 增加新的用户组
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addCategory($data)
    {
        if( ! $this->categoryValidate->add($data))
        {
            $this->errorMsg = $this->categoryValidate->getMsg();
            return false;
        }
        $data['is_delete'] = CategoryModel::IS_DELETE_NO;
        if($this->categoryModel->addCategory($data) !== false) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
    }

    /**
     * 删除用户组
     * 
     * @param array $ids
     * @access public
     * @return boolean true|false
     */
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        $data['is_delete'] = CategoryModel::IS_DELETE_YES;
        if($this->categoryModel->deleteCategorys($data, $ids) !== false) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
    }

    /**
     * 编辑用户组
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editCategory($data)
    {
        if( ! isset($data['id']))
        {
            $this->errorMsg = Lang::get('common.action_error');
            return false;
        }

        $id = intval($data['id']); unset($data['id']);

        if( ! $this->categoryValidate->edit($data))
        {
            $this->errorMsg = $this->categoryValidate->getMsg();
            return false;
        }
        if($this->categoryModel->editCategory($data, $id) !== false) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
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