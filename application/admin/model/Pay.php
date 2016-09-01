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
class Pay  extends Model 
{
    protected $auto = ['total'];
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = FALSE;

    /**
     * 总价统计
     * @param unknown $value
     * @param unknown $data
     */
    protected function setTotalAttr($value,$data){
        return $value = $data['number'] * $data['price'];
    }
     
    protected function getCreatetimeAttr($value){
        return  date("Y-m-d H:i",$value);
    }   
    
}