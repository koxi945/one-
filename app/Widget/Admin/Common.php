<?php

namespace App\Widget\Admin;

use App\Services\Admin\SC;

/**
 * 菜单小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Common
{
    /**
     * footer
     */
    public function footer()
    {
        return view('admin.widget.footer');
    }

    /**
     * header
     */
    public function header()
    {
        return view('admin.widget.header');
    }

    /**
     * top
     */
    public function top()
    {
        $username = SC::getLoginSession()->name;
        return view('admin.widget.top', compact('username'));
    }

    /**
     * crumbs
     */
    public function crumbs($btnGroup = false)
    {
        $navPid = SC::getNavPid();
        $navSid = SC::getNavSid();
        $menuArr = SC::getUserPermissionSession();
        $navParentName = $navSonName = '';
        foreach($menuArr as $key => $value)
        {
            if($value['id'] == $navPid) $navParentName = $value;
            if($value['id'] == $navSid) $navSonName = $value;
        }
        return view('admin.widget.crumbs',
            compact('navParentName', 'navSonName', 'btnGroup')
        );
    }

}