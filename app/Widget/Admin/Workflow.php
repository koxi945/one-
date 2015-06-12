<?php

namespace App\Widget\Admin;

use App\Widget\Admin\AbstractBase;
use App\Services\Admin\Acl\Acl;

/**
 * 工作流小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Workflow extends AbstractBase
{
    /**
     * 面包屑中的按钮
     *
     * @access public
     */
    public function navBtn()
    {
        $this->setCurrentAction('index', 'add', 'workflow')->checkPermission();
        $url = R('common', $this->module.'.'.$this->class.'.'.$this->function);
        $html = $this->hasPermission ?
                    '<div class="btn-group" style="float:right;"><a href="'.$url.'" title="增加新的工作流" class="btn btn-primary btn-xs"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span>增加新的工作流</a></div>'
                        : '';
        return $html;
    }

}