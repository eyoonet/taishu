<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'user' =>  'require',
        'name' =>  'require',
        'password' =>  'require',
    ];
    protected $message  =   [

        
    ];
}