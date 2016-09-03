<?php
// +----------------------------------------------------------------------
// | taishu [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.eyoonet.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 乔辉 <lovelhk.qq.com> <http://www.eyoonet.cn>
// +----------------------------------------------------------------------
namespace app\common\controller;
use think\Controller;
use think\Session;
use app\admin\model\AuthRule;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\Menu;
/**
 * 控制器基类
 * @author eyoonet <lovelhk@qq.com>
 */
class AdminBase extends Controller{
    public $sideBar;
    /**
     * 控制器初始化
     */
    public function _initialize(){
        //检测登录
        $this->isLogin();
        //获取菜单
        $this->getSidMenu();
        //注入菜单
        $this->assign('sidebar',$this->sideBar);
        //还没想到好的办法展开菜单所以先用笨办法
        $module = $this->request->module();
        $controller = $this->request->controller();
        $action = $this->request->action();
        $activeRouter = '/'.$module.'/'.$controller.'/'.$action;
        if ($parent=model('Menu')->get(['url'=>$activeRouter])){
            session('menuPid1',$parent->pid);
        }else {
            //session('menuPid1',0);
        }
        if ($parent2=model('Menu')->get(['title'=>'用户楼管理']))
            session('menuPid2',$parent2->id);
        //运行子类初始化
        $this->_subClassInitialize();
    }
    protected  function _subClassInitialize(){
        
    }
    
    /**
     * 获取菜单
     * 
     */
    public function getSidMenu(){
/*         $ruoup_access = AuthGroupAccess::get(['uid'=>session('user')->id]);
        if (!$ruoup_access)$this->error('非法用户');
        $group         = AuthGroup::get(['id' => $ruoup_access->group_id]);
        $sidebars      = AuthRule::all($group->rules);
        $this->sideBar = formatSidebar($sidebars); */
        $sidebars  = Menu::all(
            //['user'=>session('user')->user]
            function($query){
                $query->where('user', session('user')->user)->
                      whereOr('user','public');
            }
            );
        $this->sideBar = formatSidebar($sidebars);
        
    }
    /**
     * 监测登录
     */
    public function isLogin(){
        if (session('user')==null){
            $this->redirect(url('/index'));
        }
    } 
    /**
     * 退出登录
     */
    public function logout(){
        session('user',null);
        $this->redirect(url('/index'));
    }   
}