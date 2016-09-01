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
/**
 * 用户管理模型
 * @author eyoonet <lovelhk@qq.com>
 */
class User extends Model
{
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = false;
    protected function getCreatetimeAttr($value){
        return  date("Y-m-d H:i",$value);
    }
    
	/**
	 * 用户登录认证
	 * @param  string  $user     用户名
	 * @param  string  $password 用户密码
	 * @return false|userROW    登录成功-用户数据，登录失败-false
	 */
    public function login($user,$password){
        $userRow = $this->get(['user' => $user]);
        if ($userRow){
            if ($userRow['password']===think_ucenter_md5($password)){
                unset($userRow['password']);
                return $userRow;
            }else{
                $this->error='密码错误!!!';
                return false;
            }            
        }else {
            $this->error='不存在的用户名';
            return false;
        }
    }
    /**
     * 修改器密码加密
     * @param unknown $value
     */
    public function setPasswordAttr($value){
        return think_ucenter_md5($value);
    }
}