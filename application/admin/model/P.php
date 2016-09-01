<?php
namespace app\admin\model;
use think\Model;
class P extends Model{
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'pay_date';
    protected function getCreatetimeAttr($value){
        return  date("Y-m-d H:i",$value);
    }

    protected function getPaydateAttr($value){
        return  date("Y-m-d H:i",$value);
    }    
/*     protected function getIspayAttr($param) {
        $data=['未缴费','已缴费'];
        return $data[$param];
    } */
}