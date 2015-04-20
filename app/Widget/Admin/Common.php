<?php

namespace App\Widget\Admin;

use App\Services\Admin\SC;
use Request, Config;

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
    public function header(array $widgetHeaderConfig = array())
    {
        $domain['domain'] = Request::root();
        $domain['img_domain'] = Config::get('sys.sys_images_domain');
        return view('admin.widget.header', compact('widgetHeaderConfig', 'domain'));
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
        return view('admin.widget.crumbs',
            compact('btnGroup')
        );
    }

    /**
     * htmlend
     */
    public function htmlend()
    {
        return '</body></html>';
    }

}