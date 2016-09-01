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
class Main extends AdminBase
{
    /**
     *      支出项目添加
     * @param unknown $rid 房id
     * @param unknown $fid 楼id
     */
    public function createpay($rid,$fid) {
        $rdata = model('Room')->get($rid);
        if($rdata['status'] == 0 )
            return $this->success('此房间未入住');
        $projects = model('Project')->all(['pay'=>1]);
        $this->assign('rdata',$rdata);
        $this->assign('projects',$projects);
        if (request()->isPost()){
            $datas = input('post.');
            //保存获取PID
            $pid       = Db::query("SHOW TABLE STATUS LIKE  'think_p'");
            $pid       = $pid[0]['Auto_increment'];//获取指针下一自增ID
            //组装项目数组
            foreach ($datas['project'] as $key=>$data){
                $list['project']    = $datas["project"][$key];
                $list['price']      = $datas["price"][$key];
                $list['number']     = $datas["number"][$key];
                $list['new_number'] = $datas["number"][$key];//新读数是用户输入的数量
                $list['pid']        = $pid;
                $list['rid']        = $rid;
                $list['fid']        = $fid;
                $lists[] = $list;
                //判断一下新读数是不是大于旧读数
                if ($list['project']=='水费'){
                    if ($list['new_number']< $rdata['shui_number'])
                        $this->error('错误!水读数小于上次读数');
                }
                if ($list['project']=='电费'){
                    if ($list['new_number']< $rdata['dian_number'])
                        $this->error('错误!电读数小于上次读数');
                }
    
            }
            if (model('Data')->saveAll($lists)){
                if(!model('P')->save(['fid'=>$fid,'rid'=>$rid,'guest_name'=>$rdata->guest_name]))
                    $this->error('致命错误@错误代码101');
                return $this->success('成功',url('admin/room/findtable')."?fid=$fid&rid=$rid");
            } else {
                $this->error('致命错误@添加失败,错误代码102');
            }
    
        }
        return $this->fetch();
    }    
    public function index()
    {
        return $this->fetch();
    }
    
    public function add(){}
    public function edit(){}
    public function del(){}
}
