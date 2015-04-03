<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 权限用户(组)关系表模型
 *
 * @author jiang
 */
class Access extends Base
{
    /**
     * 权限用户(组)关系表名
     * 
     * @var string
     */
    protected $table = 'access';
    
    /**
     * 权限角色对应表中为用户的数据标识，这里2代表的是用户
     *
     * @var const intval
     */
    CONST AP_USER = 2;
    
    /**
     * 权限角色对应表中为用户组的数据标识，这里1代表的是用户组
     *
     * @var const intval
     */
    CONST AP_GROUP = 1;
    
    /**
     * 取得用户的权限信息
     * 
     * @param intval $userId
     * @return array
     */
    public function getUserAccessPermission($userId)
    {
        $info = $this->leftJoin('permission', 'access.permission_id', '=', 'permission.id')
                     ->where('role_id', '=', intval($userId))->where('type', '=', self::AP_USER)->get();
        return $info->toArray();
    }
    
    /**
     * 取得用户组的权限信息
     * 
     * @param intval $groupId
     * @return array
     */
    public function getGroupAccessPermission($groupId)
    {
        $info = $this->leftJoin('permission', 'access.permission_id', '=', 'permission.id')
                     ->where('role_id', '=', intval($groupId))->where('type', '=', self::AP_GROUP)->get();
        return $info->toArray();
    }

    /**
     * 设置用户或用户组的权限
     * 
     * @param array $data 所需要插入的信息
     * @param intval $id 用户（组）的ID
     * @param intval $allArr 需要删除的权限ID集
     * @param intval $type 1为用户组，2为用户
     * @return boolean true|false
     */
    public function setPermission(array $data, $id, $allArr, $type)
    {
        if( ! in_array($type, array(self::AP_USER, self::AP_GROUP))) return false;
        //删除旧的权限
        $del = $this->where('role_id', '=', intval($id))->where('type', '=', intval($type))->whereIn('permission_id', $allArr)->delete();
        if($del !== false)
        {
            if(empty($data)) return true;
            $inserData = array();
            foreach($data as $key => $value)
            {
                $inserData[] = array(
                                'role_id' => intval($id),
                                'permission_id' => intval($value),
                                'type' => intval($type)
                            );
            }
            return $this->insert($inserData);
        }
        return false;
    }

}
