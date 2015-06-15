<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;
use App\Services\Admin\Acl\Acl;

/**
 * 工作流小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class WorkflowStep extends AbstractBase
{
    /**
     * 面包屑中的按钮
     *
     * @access public
     */
    public function navBtn()
    {
        $this->setCurrentAction('step', 'add', 'workflow')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => \Request::input('id') ]);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="增加新的工作流步骤" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>增加新的工作流步骤</a></div>'
                        : '';
        return $html;
    }

    /**
     * 工作流管理列表编辑操作
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('step', 'edit', 'workflow')->setData($data)->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['stepid' => $data['id'], 'workflow_id' => \Request::input('id') ] );
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-pencil"></i></a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 工作流管理列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('step', 'delete', 'workflow')->setData($data)->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="javascript:ajaxDelete(\''.$url.'\', \'sys-list\', \'确定吗？\');"><i class="fa fa-trash-o"></i></a>'
                        : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

}