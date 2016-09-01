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
 * 数据统计控制器
 * @author eyoonet <lovelhk@qq.com>
 */
class Total extends AdminBase{
    /**
     * 年统计
     * @param string $ydate
     */
    public function year($ydate=''){
        $ydate = rtrim($ydate);
        $year   = empty($ydate) ? date('Y',time()) : $ydate;
        $yStat  = $year."-01-01";
        $yEnd   = $year."-12-31";
        $this->assign('ydate',$yStat.' 至 '.$yEnd);
        //后台显示所有
        if (session('user')->user=='admin'){
            $fdatas=db('Floor')->select();
        }else {
            $fdatas=db('Floor')->where(['user'=>session('user')->user])->select();
        }
        
        //取地址修改
        $projectTotal = 0;  $j = 0;
        $count = \think\Db::query("select count(1) as count from think_project");
        for ($i = 0; $i < $count[0]["count"] + 2; $i++) {
            foreach ($fdatas as $key=>&$vo){
                //月
                if ($j==0){//取消外层循环的重复读取数据库,保存在临时数组$totalSave中
                    $total                       =  $this->total2($yStat, $yEnd, $vo['id']);
                    $totalSave[] = $total;
                }else {
                    $total =$totalSave[$key];
                }
        
                $fdatas[$key]['num']         =  $total['num'];
                // $fdatas[$key]['projectname'] = $total['projectname'];
                $projectTotal       +=  $vo['num'][$j];
            }
            //dump($totalSave);exit;
            $projectnames = $total['projectname'];
            $hjs[] = $projectTotal;
            $j++;
            $projectTotal=0;
        }
        //dump($projectnames);;
        //dump($fdatas);exit;
        $this->assign('projectnames',$projectnames);
        $this->assign('hjs',$hjs);
        $this->assign('fdatas',$fdatas);
        return $this->fetch();
    }
    
    /**
     * 月统计
     * @param string $mdata
     */
    public function month($mdate=''){
        //月的起始结束日期
        $date =empty($mdate) ? date('Y-m-d',time()) : date('Y-m-d',strtotime($mdate.'-01'));
        $mStat  = date('Y-m-01', strtotime($date));
        $mEnd   = date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month -1 day'));
        $this->assign('mdate',$mStat.' 至 '.$mEnd);
        //后台显示所有
        if (session('user')->user=='admin'){
            $fdatas=db('Floor')->select();
        }else {
            $fdatas=db('Floor')->where(['user'=>session('user')->user])->select();
        }
        
        //取地址修改
        $projectTotal = 0;  $j = 0;
        $count = \think\Db::query("select count(1) as count from think_project");
        for ($i = 0; $i < $count[0]["count"] + 2; $i++) {
            foreach ($fdatas as $key=>&$vo){
                //月
                if ($j==0){//取消外层循环的重复读取数据库,保存在临时数组$totalSave中
                    $total                       =  $this->total2($mStat, $mEnd, $vo['id']);
                    $totalSave[] = $total;
                }else {
                    $total =$totalSave[$key];
                }

                $fdatas[$key]['num']         =  $total['num'];
               // $fdatas[$key]['projectname'] = $total['projectname'];
                $projectTotal       +=  $vo['num'][$j];
            }
            //dump($totalSave);exit;
            $projectnames = $total['projectname'];
            $hjs[] = $projectTotal;
            $j++;
            $projectTotal=0;
        }
        //dump($projectnames);;
        //dump($fdatas);exit;
        $this->assign('projectnames',$projectnames);
        $this->assign('hjs',$hjs);
        $this->assign('fdatas',$fdatas);
        return $this->fetch();    

    }
    
    /**
     * 数据统计
     * @param unknown $dateStart 开始时间
     * @param unknown $dateEnd   结束时间
     * @param unknown $fid       房ID
     */
    private function total2($dateStart,$dateEnd,$fid){
        $projects = model('Project')->all(['pay'=>1]);
        $total= null;
        foreach ($projects as $project){
            //同项目相加集合
            $sum = db('Data')->where('fid',$fid)->where('project',"$project->project")
                             ->where("create_time >= ".strtotime($dateStart))
                             ->where("create_time <= ".strtotime($dateEnd))->sum('total');
            $projectname[]  =  $project->project;
            $totals[]       =  $sum;         
            //所有项目相加
            $total         +=  $sum;
        }
        $sql = null;
        foreach ($projectname as $name){
            $sql.="project !='".$name."' and ";
        }
        $where = rtrim($sql," and ");
        $other = db('Data')->where('fid',$fid)->where($where)
                             ->where("create_time >= ".strtotime($dateStart))
                             ->where("create_time <= ".strtotime($dateEnd))->sum('total');
        $totals[]      = $other;
        $totals[]      = $total + $other;//其他为计算到总计里面在这里加上
        $projectname[] = '其他';
        $projectname[] = '总计';
        $retotals['projectname']   =  $projectname;
        $retotals['num']           =  $totals;
       // $retotals['total']         =  $total + $other;//其他为计算到总计里面在这里加上
        //dump($retotals);exit;
        return $retotals;
    }    
    
    
 
    
    
    public function index($mdate='',$ydate=''){
        //月的起始结束日期
        $date =empty($mdate) ? date('Y-m-d',time()) : date('Y-m-d',strtotime($mdate.'-01'));
        trace($date);
        $mStat  = date('Y-m-01', strtotime($date));
        $mEnd   = date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month -1 day'));
        
        $this->assign('mdate',$mStat.' 至 '.$mEnd);
        //年 起始结束日期
        
        $year   = empty($ydate) ? date('Y',time()) : $ydate;
        $yStat  = $year."-01-01";
        $yEnd   = $year."-12-31";        
        $this->assign('ydate',$yStat.' 至 '.$yEnd);
        //遍历房间列表统计数据
        if (session('user')->user=='admin'){
            $fdatas=db('Floor')->select();
        }else {
            $fdatas=db('Floor')->where(['user'=>session('user')->user])->select();
        }
        
        
        foreach ($fdatas as $key=>&$vo){
            //月
            $vo['m'] =  $this->total($mStat, $mEnd, $vo['id']);
            //年
            $vo['y'] =  $this->total($yStat, $yEnd, $vo['id']);
        }
        $this->assign('data',$fdatas);
    
        return $this->fetch();
    }
    /**
     * 数据统计
     * @param unknown $dateStart 开始时间
     * @param unknown $dateEnd   结束时间
     * @param unknown $fid       房ID
     */
    private function total($dateStart,$dateEnd,$fid){
        $total['shui_total'] = db('Data')->where('fid',$fid)->where('project','水费')
              ->where("create_time >= ".strtotime($dateStart))
              ->where("create_time <= ".strtotime($dateEnd))->sum('total');
        
        $total['dian_total'] = db('Data')->where('fid',$fid)->where('project','电费')
              ->where("create_time >= ".strtotime($dateStart))
              ->where("create_time <= ".strtotime($dateEnd))->sum('total');
       
        $total['fz_total'] = db('Data')->where('fid',$fid)->where('project','房租')
              ->where("create_time >= ".strtotime($dateStart))
              ->where("create_time <= ".strtotime($dateEnd))->sum('total');
        
        $total['other_total'] = db('Data')->where('fid',$fid)->where("project != '水费' and project != '电费' and project != '房租'")
              ->where("create_time >= ".strtotime($dateStart))
              ->where("create_time <= ".strtotime($dateEnd))->sum('total');
        
        $total['total'] =$total['shui_total']+$total['dian_total']+$total['fz_total']+$total['other_total'] ;        
        
        
        return $total;
    }
}
