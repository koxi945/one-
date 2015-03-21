<?php namespace App\Services\Admin\Position;

use Lang;
use App\Models\Admin\Position as PositionModel;
use App\Services\Admin\Position\Validate\Position as PositionValidate;

/**
 * 推荐位处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process
{
    /**
     * 推荐位模型
     * 
     * @var object
     */
    private $positionModel;

    /**
     * 推荐位表单验证对象
     * 
     * @var object
     */
    private $positionValidate;

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
        if( ! $this->positionModel) $this->positionModel = new PositionModel();
        if( ! $this->positionValidate) $this->positionValidate = new PositionValidate();
    }

    /**
     * 增加新的推荐位
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addPosition($data)
    {
        if( ! $this->positionValidate->add($data))
        {
            $this->errorMsg = $this->positionValidate->getMsg();
            return false;
        }
        $data['is_delete'] = PositionModel::IS_DELETE_NO;
        if($this->positionModel->addPosition($data) !== false) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
    }

    /**
     * 删除推荐位
     * 
     * @param array $ids
     * @access public
     * @return boolean true|false
     */
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        $data['is_delete'] = PositionModel::IS_DELETE_YES;
        if($this->positionModel->deletePositions($data, $ids) !== false) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
    }

    /**
     * 编辑推荐位
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editPosition($data)
    {
        if( ! isset($data['id']))
        {
            $this->errorMsg = Lang::get('common.action_error');
            return false;
        }

        $id = intval($data['id']); unset($data['id']);

        if( ! $this->positionValidate->edit($data))
        {
            $this->errorMsg = $this->positionValidate->getMsg();
            return false;
        }
        if($this->positionModel->editPosition($data, $id) !== false) return true;
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