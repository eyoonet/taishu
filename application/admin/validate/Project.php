<?php
namespace app\admin\validate;

use think\Validate;

class Project extends Validate
{
    protected $rule = [
        'project' =>  'require',
        'price' =>  'require|/^\d+(\.\d+)?$/',
        'number' =>  'require|/^\d+(\.\d+)?$/',
        'pay'   =>  'require',
    ];
    protected $message  =   [
        'project.require'                 => '名称必填写',
        'price./^\d+(\.\d+)?$/'   => '单价必须是数字',
        'number./^\d+(\.\d+)?$/'   => '数量必须是数字',
        'pay.require'       =>'所属类型必选',
    ];
    protected $scene = [
    ];
}