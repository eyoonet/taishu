<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.eyoonet.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 乔辉 <lovelhk.qq.com> <http://www.eyoonet.cn>
// +----------------------------------------------------------------------
namespace app\admin\model;
use think\Model;
use think\model\Merge;
class Floor  extends Merge
{
    /**
     * 楼的模型和菜单是关联的 添加楼之后自动添加楼到菜单列表
     * 
     */
    // 定义关联模型列表
    protected static $relationModel = ['Menu'];
    // 定义关联外键
    protected $fk = 'fid';
    protected $mapFields = [
        // 为混淆字段定义映射
        'id'        =>  'Floor.id',
        'menu_id'   =>  'Menu.id',
        'user'      =>  'Floor.user',
        'menu_user' =>  'Menu.user',
    ];
}