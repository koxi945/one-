<?php

if( ! function_exists('widget'))
{
    function widget($widgetName)
    {
        $widgetNameSpace = '\\App\\Widget\\';
        $widgetName = explode('.', $widgetName);
        if( ! isset($widgetName[1])) return false;
        $widgetClass = $widgetNameSpace.$widgetName[0].'\\'.$widgetName[1];
        $widgetObject = new $widgetClass();
        return $widgetObject;
    }
}

if( ! function_exists('responseJson'))
{
	function responseJson($msg, $status = false)
	{
	    $status = $status ? 'success' : 'error';
	    $arr = array('result' => $status, 'message' => $msg);
	    return Response::json($arr);
	}
}

if( ! function_exists('showWriteTime'))
{
    function showWriteTime($time)
    {
        $interval = time() - $time;
        switch ($interval) {
            case $interval < 30 * 60:
                $result = '刚刚';
                break;
            
            case $interval < 60 * 60:
                $result = '一小时前';
                break;

            case $interval < 2 * 60 * 60:
                $result = '二小时前';
                break;

            default:
                $result = date('Y-m-d', $time);
                break;
        }
        return $result;
    }
}