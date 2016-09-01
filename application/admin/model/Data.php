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
class Data extends Model
{
   protected $auto = ['old_number','total'];
   protected $autoWriteTimestamp = true;
   // 定义时间戳字段名
   protected $createTime = 'create_time';
   protected $updateTime = FALSE;
   //实例化房模型
   protected $roomModel;
   //保存用户输入数量信息
   protected $numbersave;
   //自定义初始化
   protected function initialize()
   {
       //需要调用`Model`的`initialize`方法
       parent::initialize();
       //TODO:自定义的初始化
       $this->roomModel = model('Room');
       
   }   
   /**   由于 $data['number']被本修改器修改 所以要先保存用户输入的数量 $this->numbersave
    * 如果项目是水电将计算出水电的数量
    * @param unknown $value
    * @param unknown $data
    */
   protected function setNumberAttr($value, $data){
       //echo 'numer';exit;
       $roomdata  = $this->roomModel->get($data['rid']);//获取房数据
       //保存用户输入的数量
       $this->numbersave = $data['number'];
       
       if ($data['project']=='水费'){
           //新读数减去旧读数
           
           $value = $data['number'] - $roomdata->shui_number;
       }else if ($data['project']=='电费'){
           //新读数减去旧读数
           $value = $data['number'] - $roomdata->dian_number;

       }
       return $value;
   }
   
   
   /**
    * 如果项目名不是水电,水电读数将赋值为0
    * @param unknown $value
    * @param unknown $data
    */
   protected function setNewnumberAttr($value,$data){
       //echo 'new';exit;
       if ($data['project'] == '水费'){
       }else if ($data['project'] == '电费'){
       }else {
           $value = 0;
       }       
       return $value;
   }
  
   /**
    * 自动完成old读数;经过测试 修改器是根据字段自右向左执行
    * @param unknown $value   所以要修改ROOM的水电读数必须放在此处
    * @param unknown $data    由于 $data['number']被上面修改器修改 所以要先保存用户输入的数量
    */
   protected function setOldnumberAttr($value,$data){
       //echo 'old'; exit;
       $roomdata  = $this->roomModel->get($data['rid']);//获取房数据
       if ($data['project'] == '水费'){
           $value = $roomdata->shui_number;
           //更新楼表的水电读数
           $roomdata->shui_number  =  $this->numbersave;
           $roomdata->save();
       }else if ($data['project'] == '电费'){
           $value = $roomdata->dian_number;
           //更新楼表的水电读数
           $roomdata->dian_number  =  $this->numbersave;
           $roomdata->save();
       }else{
           $value = 0;
       }
       
       return $value;
   }  
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