<?php

namespace App\Widget\Admin;

use App\Services\Admin\SC;
use App\Services\Admin\Tree;

/**
 * 菜单小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Menu
{
    /**
     * 菜单信息
     * 
     * @var array
     */
    protected $list;

    /**
     * 菜单信息
     * 
     * @var array
     */
    protected $menuTree;

    /**
     * 标志菜单不显示
     */
    CONST DISABLE_NONE = 0;

    /**
     * 处理左边的菜单
     */
    public function leftMenu()
    {
        $this->generalData();
        return view('admin.widget.leftmenu', ['menu' => $this->menuTree]);
    }

    /**
     * 内容区域的菜单
     */
    public function contentMenu()
    {
        $contentMenu = $this->getContentMenu();
        return view('admin.widget.contentmenu', compact('contentMenu'));
    }

    /**
     * 取回登录所保存的权限信息并生成树形结构
     */
    protected function generalData()
    {
        $this->list = SC::getUserPermissionSession();
        foreach($this->list as $key => $value) {
            if($value['display'] == self::DISABLE_NONE) unset($this->list[$key]);
        }
        $this->menuTree = (array) Tree::genTree($this->list);
        return $this;
    }

    /**
     * 返回内容区域的菜单
     */
    protected function getContentMenu()
    {
        $this->list = SC::getUserPermissionSession();
        foreach($this->list as $key => $value) {
            if($value['display'] == self::DISABLE_NONE) unset($this->list[$key]);
        }
        $this->menuTree = (array) Tree::genTree($this->list);
        $son = \App\Services\Admin\Tree::getSonKey();
        $mcaName = \App\Services\Admin\MCAManager::MAC_BIND_NAME;
        $MCA = app()->make($mcaName);
        foreach($this->menuTree as $key => $value) {
            if(isset($value[$son]) and is_array($value[$son])) {
                foreach($value[$son] as $skey => $svalue) {
                    if( ! $MCA->matchSecondMenu($svalue['module'], $svalue['class'], $svalue['action'])) continue;
                    if(isset($svalue[$son]) and is_array($svalue[$son])) return $svalue[$son];
                }
            }
        }
        return [];
    }

}