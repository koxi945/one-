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
if (!function_exists('arraySort'))
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