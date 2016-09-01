<?php
namespace app\admin\validate;

use think\Validate;

class Floor extends Validate
{
    protected $rule = [
        'floor_name' =>  'require',
        'shui_price' =>  'require|/^\d+(\.\d+)?$/',
        'dian_price' =>  'require|/^\d+(\.\d+)?$/',
    ];
    protected $message  =   [
        'name.require'                 => '名称必须',
        'shui_price./^\d+(\.\d+)?$/'   => '必须是数字',
        'dian_price./^\d+(\.\d+)?$/'   => '必须是数字',
        
    ];
}