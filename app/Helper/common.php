<?php

/**
 * 加载小组件，传入的名字会以目录和类名区别。
 * 如Home.Common就代表Widget目录下的Home/Common.php这个widget。
 *
 * @param string $widgetName
 * @return object 返回这个widget的对象
 */
if( ! function_exists('widget'))
{
    function widget($widgetName)
    {
        $widgetNameEx = explode('.', $widgetName);
        if( ! isset($widgetNameEx[1])) return false;
        $widgetClass = '\\App\\Widget\\'.$widgetNameEx[0].'\\'.$widgetNameEx[1];

        //如果已经绑定，那么直接返回
        if(app()->bound($widgetName))
        {
            return app()->make($widgetName);
        }

        //注册一个对象到分享容器中
        app()->singleton($widgetName, function() use ($widgetClass)
        {
            return new $widgetClass();
        });

        return app()->make($widgetName);
    }
}

/**
 * 返回json
 *
 * @param string $msg 返回的消息
 * @param boolean $status 是否成功
 */
if( ! function_exists('responseJson'))
{
	function responseJson($msg, $status = false)
	{
	    $status = $status ? 'success' : 'error';
	    $arr = array('result' => $status, 'message' => $msg);
	    return Response::json($arr);
	}
}

/**
 * 写作的时间人性化
 *
 * @param int $time 写作的时间
 * @return string
 */
if( ! function_exists('showWriteTime'))
{
    function showWriteTime($time)
    {
        $interval = time() - $time;
        $format = array(
            '31536000'  => '年',
            '2592000'   => '个月',
            '604800'    => '星期',
            '86400'     => '天',
            '3600'      => '小时',
            '60'        => '分钟',
            '1'         => '秒'
        );
        foreach($format as $key => $value)
        {
            $match = floor($interval / (int) $key );
            if(0 != $match)
            {
                return $match . $value . '前';
            }
        }
        return date('Y-m-d', $time);
    }
}

/**
 * 二维数组的排序
 *
 * @param array $arr 所要排序的数组
 * @param string $keys 以哪个key来做排序
 * @param string $type desc|asc
 */
if ( ! function_exists('arraySort'))
{
    function arraySort($arr,$keys,$type='asc')
    {
        $keysvalue = $new_array = array();
        foreach ($arr as $k=>$v) {
            $keysvalue[$k] = $v[$keys];
        }
        if($type == 'asc') {
            asort($keysvalue);
        } else {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach($keysvalue as $k=>$v) {
            $new_array[$k] = $arr[$k];
        }
        
        $arr = array();
        foreach($new_array as $key => $val) {
            $arr[] = $val;
        }
        return $arr; 
    }
}

/**
 * 加载静态资源
 *
 * @param string $file 所要加载的资源
 */
if ( ! function_exists('loadStatic'))
{
    function loadStatic($file)
    {
        $realFile = public_path().$file;
        if( ! file_exists($realFile)) return '';
        $filemtime = filemtime($realFile);
        return Request::root().$file.'?v='.$filemtime;
    }
}

/**
 * 适用于url的base64加密
 */
if( ! function_exists('base64url_encode') )
{
    function base64url_encode($data)
    { 
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    } 
}

/**
 * 适用于url的base64解密
 */
if( ! function_exists('base64url_decode') )
{
    function base64url_decode($data)
    { 
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
    } 
}

if( ! function_exists('dir_path') )
{
    /**
    * 转化 \ 为 /
    * 
    * @param    string  $path   路径
    * @return   string  路径
    */
    function dir_path($path)
    {
        $path = str_replace('\\', '/', $path);
        if(substr($path, -1) != '/') $path = $path.'/';
        return $path;
    }

}

if( ! function_exists('dir_create') )
{
    /**
     * 创建目录
     * 
     * @param    string  $path   路径
     * @param    string  $mode   属性
     * @return   string  如果已经存在则返回true，否则为flase
     */
    function dir_create($path, $mode = 0777)
    {
        if(is_dir($path)) return TRUE;
        $ftp_enable = 0;
        $path = dir_path($path);
        $temp = explode('/', $path);
        $cur_dir = '';
        $max = count($temp) - 1;
        for($i=0; $i<$max; $i++)
        {
            $cur_dir .= $temp[$i].'/';
            if (@is_dir($cur_dir)) continue;
            @mkdir($cur_dir, 0777,true);
            @chmod($cur_dir, 0777);
        }
        return is_dir($path);
    }
}

if( ! function_exists('isImage') )
{
    /**
     * 根据后缀来简单的判断是不是图片
     * 
     * @return boolean
     */
    function isImage($ext)
    {
        $imageExt = 'jpg|gif|png|bmp|jpeg';
        if( ! in_array($ext, explode('|', $imageExt))) return false;
        return true;
    }
}