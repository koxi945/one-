<?php

namespace App\Http\Controllers\Admin;

use Request;
use Lang;

/**
 * 弹出窗口上传
 *
 * @author jiang <mylampblog@163.com>
 */
class UploadController extends Controller
{
    /**
     * 上传弹出窗口
     */
    public function index()
    {
    	return view('admin.upload.index');
    }

}