<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;

/**
 * 文章列表小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Content extends AbstractBase
{
    /**
     * 文章列表编辑操作
     *
     * @access public
     */
    public function edit($data)
    {
        $this->setCurrentAction('content', 'edit', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
        $html = $this->hasPermission ?
                    '<a href="'.$url.'"><i class="fa fa-pencil"></i></a>'
                        : '<i class="fa fa-pencil" style="color:#ccc"></i>';
        return $html;
    }

    /**
     * 文章列表删除操作
     *
     * @access public
     */
    public function delete($data)
    {
        $this->setCurrentAction('content', 'delete', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function, ['id' => $data['id']]);
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
        $this->setCurrentAction('content', 'add', 'blog')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="增加新的文章" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>增加新的文章</a></div>'
                        : '';
        return $html;
    }

    /**
     * 批量删除
     *
     * @access public
     */
    public function deleteSelect()
    {
        $this->setCurrentAction('content', 'delete', 'blog')->checkPermission();
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:left;margin:10px 0;margin-right:20px;"><a class="btn btn-primary pl-delete" data-loading="处理中..." ><i class="fa fa-trash-o"></i> <span class="sys-btn-submit-str">批量删除</span></a></div>'
                        : '';
        return $html;
    }

}