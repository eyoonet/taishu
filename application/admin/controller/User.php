<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.eyoonet.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 乔辉 <lovelhk.qq.com> <http://www.eyoonet.cn>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use app\common\controller\AdminBase;
//use app\admin\controller\Floor as FloorModel;
/**
 * 用户管理
 * @author eyoonet <lovelhk@qq.com>
 */
class User extends AdminBase{
    /**
     * 用户列表
     * @return mixed
     */
    public function index(){
        $data = model('User')->all(function($query){
                    $query->where('user', '<>','admin');
                });
        unset($data['password']);        
        $this->assign('data',$data);
        return $this->fetch();
    }
    /**
     * 添加用户
     */
    public function add(){
        if ($this->request->isPost()){
            $data = input('post.');
            
            $result = $this->validate($data,'User');
            if(true !== $result)
                $this->error($result);
            
            if ($data['enter_passowrd'] != $data['password'])
                return $this->success('确认密码错误');
            
            if (model('User')->allowField(true)->save($data)) 
                return $this->success('添加成功');
        }
        return $this->fetch();
    }
    /**
     * 编辑用户
     * @param unknown $id
     */
    public function edit($id){
        $data = model('User')->get($id);
        $this->assign('data',$data);
        if ($this->request->isPost()){
            $data       = input('post.');
            
            $result = $this->validate($data,'User');
            if(true !== $result)
                $this->error($result);
            
            $data['id'] = $id;
            if (model('User')->allowField(true)->isUpdate(true)->save($data))
                return $this->success('修改成功',url('/admin/user/index'));
        }  
        return $this->fetch();
    }
    /**
     * 删除用户
     * @param unknown $id
     */
    public function del($id){
        if (model('User')->destroy($id))
            return $this->success('删除成功');
    }
}