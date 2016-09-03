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
        //$count = \think\Db::query("select count(1) as count from think_project WHERE pay=1");
        //$count = $count[0]["count"] + 2;
        foreach ($fdatas as $key=>&$vo){
            $total       =  $this->getSumNumbers($yStat, $yEnd, $vo['id'],'Data',1);
            $paytotal    =  $this->getSumNumbers($yStat, $yEnd, $vo['id'],'Pay',0);
            $fdatas[$key]['num']         =  $total['num'];
            $fdatas[$key]['paynum']         =  $paytotal['num'];
        }
        $projectnames    = $total['projectname'];
        $payprojectnames = $paytotal['projectname'];
        $count           = sizeof($fdatas[0]['num']);
        $countpay        = sizeof($fdatas[0]['paynum']);
        $this->assign('count',           $count);
        $this->assign('countpay',        $countpay);
        $this->assign('projectnames',    $projectnames);
        $this->assign('payprojectnames', $payprojectnames);
        $this->assign('hjs',             $this->getfAllTotal($fdatas,'num'));
        $this->assign('payhjs',          $this->getfAllTotal($fdatas,'paynum'));
        $this->assign('fdatas',          $fdatas);
        return $this->fetch();
    }
    /**
     *      获取SUM总计
     * @param annay   $fdata  房数据
     * @param string  $field  获取的字段
     * @return annay    返回序列 相加组合
     */
    protected function getfAllTotal($fdata,$field){
        $sum = 0;
        for ($j=0;$j<sizeof($fdata[0][$field]) ;$j++){
            for ($i=0; $i<sizeof($fdata) ;$i++){
              $sum+= $fdata[$i][$field][$j];
            }
            $alls[]=$sum;
            $sum = 0;
        }
        return $alls;
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
            foreach ($fdatas as $key=>&$vo){
                $total       =  $this->getSumNumbers($mStat, $mEnd, $vo['id'],'Data',1);
                $paytotal    =  $this->getSumNumbers($mStat, $mEnd, $vo['id'],'Pay',0);
                $fdatas[$key]['num']         =  $total['num'];
                $fdatas[$key]['paynum']         =  $paytotal['num'];
            }
        $projectnames    = $total['projectname'];
        $payprojectnames = $paytotal['projectname'];
        $count           = sizeof($fdatas[0]['num']);
        $countpay        = sizeof($fdatas[0]['paynum']);
        $this->assign('count',           $count);
        $this->assign('countpay',        $countpay);
        $this->assign('projectnames',    $projectnames);
        $this->assign('payprojectnames', $payprojectnames);
        $this->assign('hjs',             $this->getfAllTotal($fdatas,'num'));
        $this->assign('payhjs',          $this->getfAllTotal($fdatas,'paynum'));
        $this->assign('fdatas',          $fdatas);
        return $this->fetch();  
    }
    
    /**
     * 数据统计
     * @param unknown $dateStart 开始时间
     * @param unknown $dateEnd   结束时间
     * @param unknown $fid       房ID
     */
    private function getSumNumbers($dateStart,$dateEnd,$fid,$table,$pay=1){
        $projects = model('Project')->all(['pay'=>$pay]);
        $total= null;
        foreach ($projects as $project){
            //同项目相加集合
            $sum = db($table)->where('fid',$fid)->where('project',"$project->project")
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
        $other = db($table)->where('fid',$fid)->where($where)
                             ->where("create_time >= ".strtotime($dateStart))
                             ->where("create_time <= ".strtotime($dateEnd))->sum('total');
        $totals[]      = $other;
        $totals[]      = $total + $other;//其他为计算到总计里面在这里加上
        $projectname[] = '其他';
        $projectname[] = '总计';
        $retotals['projectname']   =  $projectname;
        $retotals['num']           =  $totals;
        return $retotals;
    }    
}
