<?php
namespace app\admin\validate;

use think\Validate;

class Room extends Validate
{
    protected $rule = [
        'room_name' =>  'require',
        'shui_number' =>  'require|/^\d+(\.\d+)?$/',
        'dian_number' =>  'require|/^\d+(\.\d+)?$/',
        'price' =>  'require|/^\d+(\.\d+)?$/',
        'guest_name'=>'require',
        'guest_tel' =>'require',
    ];
    protected $message  =   [
        'name.require'                 => '名称必须',
        'shui_price./^\d+(\.\d+)?$/'   => '必须是数字',
        'dian_price./^\d+(\.\d+)?$/'   => '必须是数字',
             'price./^\d+(\.\d+)?$/'   => '必须是数字', 
    ];
    protected $scene = [
        'add'  =>  ['room_name','shui_number','dian_number','price'],
        'guest'=>  ['guest_name','guest_tel'],
    ];
}