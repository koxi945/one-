<?php namespace App\Services\Admin;

/**
 * 树形结构处理类
 *
 * @author jiang
 */
class Tree
{
    /**
     * 用来标题子菜单的
     * 
     * @var string
     */
    static public $son = 'son';
    
    /**
     * 返回子树的key
     *
     * @access public
     */
    static public function getSonKey()
    {
        return self::$son;
    }

    /**
     * 格式化数据源，令到可以符合树形结构算法
     *
     * @access public
     */
    static public function prepareData(array $items)
    {
        $data = array();
        foreach($items as $value)
        {
            $id = $value['id'];
            $data[$id] = $value;
        }
        return $data;
    }

    /**
     * 生成树形结构
     *
     * @access public
     */
    static public function genTree(array $items)
    {
        $items = self::prepareData($items);
        foreach ($items as $item)
            $items[$item['pid']][self::$son][$item['id']] = &$items[$item['id']];
        return isset($items[0][self::$son]) ? $items[0][self::$son] : array();
    }

    /**
     * 递归select中的option下拉表单，用于权限增加和编辑
     * 
     * @param  array $datas 数据源
     * @param  array $id 已经选择的option值
     * @param  array $prefix 下拉表单的线
     * @return html 返回组装好的option代码
     */
    static public function dropDownSelect(array $datas, $id = 0, $prefix = '')
    {
        $select = ''; $id = intval($id);
        
        foreach($datas as $key => $value)
        {
            //如果超过了第三层的话，跳过
            if(substr_count($prefix.$value['name'], '／') > 2) continue;

            $line = $prefix.$value['name'].'／';
            $isCurrent = $value['id'] == $id ? 'selected' : '';
            $select .= '<option value="'.$value['id'].'" '.$isCurrent.'>'.$prefix.$value['name'].'</option>';
            if(isset($value[self::$son]) && is_array($value[self::$son]))
            {
                $select .= self::dropDownSelect($value[self::$son], $id, $line);
            }
        }
        return $select;
    }
    
    /**
     * 生成权限设置列表所用到的树结构
     * 
     * @param  array $datas 数据源
     * @return array
     */
    static function genPermissionTree($data)
    {
        $tree = self::genTree($data);
        //父节点
        foreach($tree as $key => $value)
        {
            if( ! isset($value[self::$son]) or ! is_array($value[self::$son])) continue;
            //二级父结点
            foreach($value[self::$son] as $key2 => $value2)
            {
                if( ! isset($value2[self::$son]) or ! is_array($value2[self::$son])) continue;
                foreach($value2[self::$son] as $key3 => $value3)
                {
                    $res = self::genThirdPermissionTree($value2[self::$son], $data);
                    $tree[$key][self::$son][$key2][self::$son] = $res;
                }
            }
        }
        return $tree;
    }

    /**
     * 返回三级树以及其子树的数据，会以一个一维数组返回，如果有子树，会合并到父级中。
     * 
     * @param  array $datas 数据源
     * @return array
     */
    static function genThirdPermissionTree($currentArr, $data)
    {
        $result = array();
        foreach($currentArr as $key => $value)
        {
            if(isset($value[self::$son]))
            {
                $result = array_merge($result, self::getAllSubTree($value['id'], $data));
                $result[$key] = $value;
            }
            else
            {
                $result[$key] = $value;
            }
        }
        return self::prepareData($result);
    }

    /**
     * 只支持到第四层
     * 
     * @return array
     */
    static function getAllSubTree($pid, $data)
    {
        $result = array();
        $data = self::prepareData($data);
        foreach($data as $key => $value)
        {
            if($value['pid'] == $pid)
            {
                $result[$key] = $value;
            }
        }
        return $result;
    }
    
}
