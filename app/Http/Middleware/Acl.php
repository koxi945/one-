<?php namespace App\Http\Middleware;

use Closure;
use App\Services\Admin\Acl\Acl as AclManager;

/**
 * 用户权限验证
 *
 * @author jiang <mylampblog@163.com>
 */
class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $param = $this->buildAclParam($request);
        $aclObject = new AclManager();
        $ret = $aclObject->checkUriPermission($param->module, $param->class, $param->action);
        if( ! $ret) return abort(401);
        $response = $next($request);
        return $response;
    }

    /**
     * buildAclParam
     */
    private function buildAclParam($request)
    {
        $object = new \stdClass();
        $object->class = $request->route('class');
        $object->action = $request->route('action');
        $object->module = $request->route('module');
        if( ! $object->class and ! $object->action and ! $object->module)
        {
            //如果没有指定class和action的参数，那么使用别名来做处理
            $currentRouteName = $request->route()->getName();
            $currentRouteNameArr = explode('.', $currentRouteName);
            if(isset($currentRouteNameArr[2]))
            {
                $object->class = $currentRouteNameArr[0];
                $object->action = $currentRouteNameArr[1];
                $object->module = $currentRouteNameArr[2];
            }
        }
        return $object;
    }

}
