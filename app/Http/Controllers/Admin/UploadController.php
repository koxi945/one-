<?php

namespace App\Http\Controllers\Admin;

use Request;
use Lang;
use App\Services\Admin\Upload\Process as UploadManager;

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
    	$parpams = Request::only('args', 'authkey', 'upload_path');
    	return view('admin.upload.index', compact('parpams'));
    }

    /**
     * 处理上传
     */
    public function process()
    {
    	$parpams = Request::only('authkey', 'upload_path', 'args');
    	$config = explode(',', base64url_decode($parpams['args']));
    	$uploadObject = new UploadManager();
    	if( ! $uploadObject->setParam($config)->checkUploadToken($parpams['authkey'])) return abort(500);
    	$fileName = 'file';
    	if ( ! Request::hasFile($fileName)) return abort(500);
    	if ( ! Request::file($fileName)->isValid()) return abort(500);
    	if (Request::file($fileName)->getError() != UPLOAD_ERR_OK) return abort(500);
    	$file = Request::file($fileName);
    	$savePath = base64url_decode($parpams['upload_path']);
    	$saveFileName = md5(uniqid('pre', TRUE).mt_rand(1000000,9999999)).'.'.$file->getClientOriginalExtension();
    	//dd($savePath);
    	if( ! is_dir($savePath))
    	{
    		dir_create($savePath);
    	}
    	$move = $file->move($savePath, $saveFileName);
    	if( ! file_exists($savePath.$saveFileName)) return abort(500);
    	return ;
    }

}