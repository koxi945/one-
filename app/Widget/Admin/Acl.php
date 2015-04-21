<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;
use App\Services\Admin\Acl\Acl as AclManager;

/**
 * 用户列表小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Acl extends AbstractBase
{
    /**
     * 用户列表编辑操作
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('acl', 'edit', 'foundation')->setData($data)->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-pencil"></i></a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 用户列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('acl', 'delete', 'foundation')->setData($data)->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => url_param_encode($data['id'])]);
        $html = $this->hasPermission ?
                    '<a href="javascript:ajaxDelete(\''.$url.'\', \'sys-list\', \'确定吗？\');"><i class="fa fa-trash-o"></i></a>'
                        : '<i class="fa fa-trash-o" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 面包屑中的按钮
     *
     * @access public
     */
    public function navBtn()
    {
        $this->setCurrentAction('acl', 'add', 'foundation')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="增加新的功能" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>增加新的功能</a></div>'
                        : '';
        return $html;
    }

    /**
     * 面包屑中的按钮
     *
     * @access public
     */
    public function sort()
    {
        $this->setCurrentAction('acl', 'sort', 'foundation')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:left;margin:10px 0;margin-right:20px;"><a class="btn btn-primary sys-btn-submit" data-loading="处理中..." ><i class="fa fa-sort"></i> <span class="sys-btn-submit-str">排序</span></a></div>'
                        : '';
        return $html;
    }

}