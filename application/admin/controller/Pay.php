<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.eyoonet.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 乔辉 <lovelhk.qq.com> <http://www.eyoonet.cn>
// +----------------------------------------------------------------------
namespace app\admin\controller;
use \app\common\controller\AdminBase;
/**
 * 入口控制器
 * @author eyoonet <lovelhk@qq.com>
 */
class Pay extends AdminBase
{
    /**
     *      支出项目添加
     * @param unknown $fid 楼id
     */
    public function add($fid) {
        $projects = model('Project')->all(['pay'=>0]);
        $fname = model('Floor')->where('id',$fid)->value('floor_name');
        $this->assign('fname',$fname);
        $this->assign('projects',$projects);
        if (request()->isPost()){
            $datas = input('post.');
            //组装项目数组
            foreach ($datas['project'] as $key=>$data){
                $list['project']    = $datas["project"][$key];
                $list['price']      = $datas["price"][$key];
                $list['number']     = $datas["number"][$key];
                $list['fid']        = $fid;
                $lists[] = $list;
            }
            if (model('Pay')->saveAll($lists)){
                return $this->success('成功',url('admin/pay/index'));
            } else {
                $this->error('致命错误@添加失败,错误代码102');
            }
    
        }
        return $this->fetch();
    }    
    public function index($fid=NULL)
    {
        $fname = model('Floor')->where('id',$fid)->value('floor_name');
        $this->assign('fname',$fname);
        $datas = $fid==null ? model('Pay')->paginate(10) 
                            : model('Pay')->where('fid',$fid)
                                          ->paginate(10);
        $this->assign('datas',$datas);
        return $this->fetch();
    }
    public function edit(){
        return $this->success('功能正在开发');
    }
    public function del($id){
        if (model('Pay')->destroy($id)) {
            return $this->success('删除成功');
        }
    }
}
