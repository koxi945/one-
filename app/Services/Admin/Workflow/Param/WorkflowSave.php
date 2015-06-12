<?php namespace App\Services\Admin\Workflow\Param;

use App\Services\Admin\AbstractParam;

/**
 * Workflow操作有关的参数容器，固定参数，方便分离处理。
 *
 * @author jiang <mylampblog@163.com>
 */
class WorkflowSave extends AbstractParam
{
    protected $group_name;

    protected $level;

    protected $mark;

    protected $id;

    public function setAttributes($attributes)
    {
        $reflection = new \ReflectionClass($this);
        $attributes = (array) $attributes;
        foreach($attributes as $key => $value)
        {
            if($reflection->hasProperty($key) and ! isset($this->attributes[$key]))
            {
                $this->$key = $this->attributes[$key] = $value;
            }
        }
        return $this;
    }

    public function setGroupName($groupName)
    {
        $this->group_name = $this->attributes['group_name'] = $groupName;
        return $this;
    }

    public function setLevel($level)
    {
        $this->level = $this->attributes['level'] = $level;
        return $this;
    }

    public function setMark($mark)
    {
        $this->mark = $this->attributes['mark'] = $mark;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $this->attributes['id'] = $id;
        return $this;
    }

}
