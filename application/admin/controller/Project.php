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
/**
 * 系统配置
 * @author eyoonet <lovelhk@qq.com>
 */
class Project extends AdminBase{
    public function index() {
        $datas=model('Project')->all();
        $this->assign('data',$datas);
        return $this->fetch();
    }
    public function add(){
        if ($this->request->isPost()){
            $result = $this->validate(input('post.'),'Project');
            if(true !== $result)
                $this->error($result);
            if (model('Project')->save(input('post.')))
              return $this->success('添加成功');
        }
        return $this->fetch();
    }
    
    public function edit($id){
        $data=model('Project')->get($id);
        $this->assign('pay',$data->getData('pay'));
        $this->assign('data',$data);
        if ($this->request->isPost()){
             $data->project = input('post.project');
             $data->price   = input('post.price');
             $data->number  = input('post.number');
            if ($data->save()) 
                return $this->success('修改成功');
        }
        return $this->fetch();
    }
    
    public function del($id){
        if (model('Project')->destroy($id)) {
            return $this->success('删除成功');
        }else {
            return $this->error("错误,删除失败");
        }
    }
}
