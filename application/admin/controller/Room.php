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
use think\Db;
//use app\admin\controller\Floor as FloorModel;
/**
 * 房控制器
 * @author eyoonet <lovelhk@qq.com>
 */
class Room extends AdminBase
{
    //定义楼模型
    protected $roomModel;
    
    /**
     * (non-PHPdoc) 重构父类实现子类初始化
     * @see \app\common\controller\AdminBase::_subClassInitialize()
     */
    protected function _subClassInitialize(){
        //展开菜单
        $this->assign('amin','am-in');
        //实例化模型
        $this->roomModel = model('Room');
    }
    /**
     * 添加房
     * @author eyoonet <lovelhk@qq.com>
     * @param  array
     */
    public function add($id)
    {
        if (request()->isPost()){
            $data        = input('post.');
            $data['fid'] = $id;
            $result = $this->validate($data,'Room.add');
            if(true !== $result)
                $this->error($result); 
            if ($this->roomModel->save($data))
                return $this->success('添加成功'); 
        }
        return $this->fetch();
    }
    /**
     * 删除房
     * @author eyoonet <lovelhk@qq.com>
     * @param  $ID int
     */
    public function del($id)
    {
        //if (model('Room')->get(['fid'=>$id]))
       // {
       //     return $this->success('先删除房间');
      //  }else {
            if ($this->roomModel->destroy($id))
                return $this->success('完成'); 
            return $this->success('失败');
      //  }  
    }
    /**
     * 修改房
     * @author eyoonet <lovelhk@qq.com>
     * @param  $ID int
     */
    public function edit($id)
    {
       if ($data = $this->roomModel->get($id)){
           if (request()->isPost()){
               $dataInput   = input('post.');
               $result = $this->validate($dataInput,'Room.add');
               if(true !== $result)
                   $this->error($result);
               if ($this->roomModel->save($dataInput,['id' => $id]))
                   return $this->success('修改成功',url('/admin/floor'));
           }          
           $this->assign('data',$data);
           return $this->fetch();
       }
       return $this->error('出错');
    }    
    /**
     * 查询房,后台管理用
     * @author eyoonet <lovelhk@qq.com>
     * @param  $fid int  fid
     */
    public function index($fid=null)
    {
        $list = $this->roomModel->all(['fid'=>$fid]);
        //dump($list);
        $this->assign('list',$list);
        return $this->fetch();
    }
    /**
     * 显示房间列表.带图标
     * @param string $fid
     * @return mixed
     */
    public function show($fid=null){
        $list  = $this->roomModel->where(['fid'=>$fid])->order('reg_date', 'asc')->select();
        $fname = model('Floor')->where('id',$fid)->value('floor_name');
        $this->assign('fname',$fname);
        $this->assign('fid',$fid);
        $this->assign('list',$list);
        return $this->fetch();        
    }
    /**
     *      制作订单
     * @param unknown $rid 房id
     * @param unknown $fid 楼id
     */
    public function createtab($rid,$fid) {
        $rdata = model('Room')->get($rid);
        $fdata = model('Floor')->get($fid);
        if($rdata['status'] == 0 )
            return $this->success('此房间未入住');
        $projects = model('Project')->all(['pay'=>1]);
        $this->assign('rdata',$rdata);//dump($rdata);exit;
        $this->assign('fdata',$fdata);//dump($rdata);exit;
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
    
    /**
     * 表格生成
     * @param unknown $pid
     * @param unknown $fid
     * @param unknown $rid
     */
    public function showtable($pid,$fid,$rid){
        $fname = model('Floor')->where('id',$fid)->value('floor_name');
        $rname = model('Room')->where('id',$rid)->value('room_name');
        $uname = model('P')->where('id',$pid)->value('guest_name');
        $data = model('Data')->all(['pid'=>$pid,'fid'=>$fid,'rid'=>$rid]);
        if (!$data)
            $this->error('错误@无数据');
        $this->assign('pid',$pid);
        $this->assign('lists',$data);
        $this->assign('fname',$fname);
        $this->assign('rname',$rname);
        $this->assign('uname',$uname);
        return $this->fetch();
    }
    
    /**
     *   P指针列表
     * @param unknown $fid
     * @param unknown $rid
     */
    public function findtable($fid,$rid){
        $comfig =[ 'query'    => ['fid'=>$fid,'rid'=>$rid]];
        $data = model('P')->where('fid',$fid)
                          ->where('rid',$rid)
                          ->order('create_time desc')
                          ->paginate(10,false,$comfig);
        $this->assign('data',$data);
        $this->assign('fid',$fid);
        $this->assign('rid',$rid);
        return $this->fetch(); 
    }
    /**
     * 缴费
     * @param unknown $pid
     * @return multitype:
     */
    public function pay($pid){
        if(model('P')->where('id',$pid)->value('ispay') == 1 )
            return $this->success('此房间已缴了费用,不得重复缴费');
        if (model('P')->save(['ispay'=>1],['id'=>$pid])) 
            return $this->success('缴费完成');
    }
    /**
     * 删除P数据 and DATA数据
     * @param unknown $pid
     * @param unknown $fid
     * @param unknown $rid
     * @return multitype:
     */
    public function pDel($pid,$fid,$rid){
        if (model('P')->destroy($pid)){
           if (model('Data')->destroy(['pid' => $pid,'rid'=>$rid,'fid'=>$fid])) 
             return $this->success('删除成功') ;
           $this->error('致命错误 删除失败,联系管理员');
        }
    }
    /**
     * 房客入住
     * @param unknown $rid
     * @param unknown $fid
     */
    public function gusetreg($rid,$fid){
        if(model('Room')->where('id',$rid)->value('status') == 1 )
            return $this->success('此房间已入住,若要入住请先退房');        
        if (request()->isPost()){
            $data=input('post.');
            $data['status'] = 1;
            $result = $this->validate($data,'Room.guest');
            if(true !== $result)
                $this->error($result);
            if (model('Room')->save($data,['id'=>$rid]))
               return  $this->success('入住成功',url('admin/room/show').'?fid='.$fid);
        }
        return $this->fetch();
    }
    /**
     * 房客退房
     * @param unknown $rid
     */
    public function gusetdel($rid) {
        if(model('Room')->where('id',$rid)->value('status') == 0 )
            return $this->success('此房间未入住');        
        $data['status']     =  0;
        $data['guest_name'] = '';
        $data['guest_tel']  = '';
        if (model('Room')->save($data,['id'=>$rid]))
            return $this->success('退房成功,');
    }

}
