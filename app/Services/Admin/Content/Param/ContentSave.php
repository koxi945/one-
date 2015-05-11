<?php namespace App\Services\Admin\Content\Param;

use App\Services\Admin\AbstractParam;

/**
 * 文章操作有关的参数容器，固定参数，方便分离处理。
 *
 * @author jiang <mylampblog@163.com>
 */
class ContentSave extends AbstractParam
{
    protected $title;

    protected $summary;

    protected $tags;

    protected $classify;

    protected $content;

    protected $status;

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


}
