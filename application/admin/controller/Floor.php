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
use app\admin\controller\Floor as FloorModel;
/**
 * 房控制器  与菜单表相互关联
 * @author eyoonet <lovelhk@qq.com>
 */
class Floor extends AdminBase
{
    //定义楼模型
    protected $floorModel;
    
    /**
     * (non-PHPdoc) 重构父类实现子类初始化
     * @see \app\common\controller\AdminBase::_subClassInitialize()
     */
    protected function _subClassInitialize(){
        //展开菜单
        $this->assign('amin','am-in');
        //实例化模型
        $this->floorModel = model('Floor');
    }
    /**
     * 添加房
     * @author eyoonet <lovelhk@qq.com>
     * @param  array
     */
    public function add()
    {
        if (request()->isPost()){
            $data   = input('post.');
            $result = $this->validate($data,'Floor');
            if(true !== $result)
                $this->error($result);
            //添加菜单到用户   关联了Menu表.  Menu表赋值
            $data['title']     = $data['floor_name'];
            $data['menu_user'] = $data['user'];
            $data['pid']       = 3;//用户楼管理
            $data['url']       = '/admin/room/show';   
            if ($this->floorModel->save($data)){
                    return $this->success('添加成功'); 
            }
        }
        $users = model('User')->all();
        $this->assign('users',$users);
        return $this->fetch();
    }
    /**
     * 删除房
     * @author eyoonet <lovelhk@qq.com>
     * @param  $ID int
     */
    public function del($id)
    {
        if (model('Room')->get(['fid'=>$id]))
        {
            return $this->success('先删除房间');
        }else {
            if ($this->floorModel->destroy($id))
                return $this->success('完成'); 
            return $this->success('失败');
        }  
    }
    /**
     * 修改房
     * @author eyoonet <lovelhk@qq.com>
     * @param  $ID int
     */
    public function edit($id)
    {
       if ($data = $this->floorModel->get($id)){
           if (request()->isPost()){
               $dataInput   = input('post.');
               $result = $this->validate($dataInput,'Floor');
               if(true !== $result)
                   $this->error($result);
               //添加菜单到用户   关联了Menu表.  Menu表赋值
               $dataInput['title']     = $dataInput['floor_name'];
               $dataInput['menu_user'] = $dataInput['user'];
               $dataInput['pid']       = 3;
               $dataInput['url']       = '/admin/room/show';
               $dataInput['id']        = $id;
               if ($this->floorModel->isUpdate(true)->save($dataInput))
                   return $this->success('修改成功',url('/admin/floor'));
           }          
           $this->assign('data',$data);
           $users = model('User')->all();
           $this->assign('users',$users);
           return $this->fetch();     
       } 
       return $this->error('出错');
    }    
    /**
     * 查询房
     * @author eyoonet <lovelhk@qq.com>
     * @param  $udi int
     */
    public function index($uid=null)
    {
        $list = $this->floorModel->all();
        $this->assign('list',$list);
        return $this->fetch();
    }    
    public function test(){
       dump( $this->floorModel->all())
       ;
    }
}
