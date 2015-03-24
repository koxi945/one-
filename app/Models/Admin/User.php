<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * 用户表模型
 */
class User extends Model
{
    /**
     * 关闭自动维护updated_at、created_at字段
     * 
     * @var boolean
     */
    public $timestamps = false;

    /**
     * 数据表名
     * 
     * @var string
     */
    protected $table = 'users';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'name', 'password', 'group_id', 'realname', 'token',
                                'add_time', 'modify_time', 'mobile', 'status', 'mark',
                                'last_login_ip', 'last_login_time'
                            );

    /**
     * 取得用户的信息，根据用户名
     * 数据结构为：return ['username' => 'test', 'password' => '96e79218965eb72c92a549dd5a330112', 'apitoken' => '111111'];
     * 
     * @param string $username 用户名
     */
    public function InfoByName($username)
    {
        return $this->where('name', $username)->first();
    }

    /**
     * 取得所有的用户
     *
     * @return array
     */
    public function getAllUser($groupId = null)
    {
        $query = $this->leftJoin('group', 'users.group_id', '=', 'group.id');
        if($groupId) $query->where('users.group_id', '=', intval($groupId));
        $currentQuery = $query->select(array('*','users.id as id'))->orderBy('users.id', 'desc')->paginate(15);
        return $currentQuery;
    }

    /**
     * 增加用户
     * 
     * @param array $data 所需要插入的信息
     */
    public function addUser(array $data)
    {
        return $this->create($data);
    }
    
    /**
     * 修改用户
     * 
     * @param array $data 所需要插入的信息
     */
    public function editUser(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }
    
    /**
     * 删除用户
     * 
     * @param array $id 权限功能的ID
     */
    public function deleteUser(array $ids)
    {
        return $this->destroy($ids);
    }
    
    /**
     * 取得指定ID用户信息
     * 
     * @param intval $id 用户的ID
     * @return array
     */
    public function getOneUserById($id)
    {
        return $this->where('id', '=', intval($id))->first();
    }
    
    /**
     * 取得指定用户名的信息
     * 
     * @param string $name 用户名
     * @return array
     */
    public function getOneUserByName($name)
    {
        return $this->where('name', '=', $name)->first();
    }

}