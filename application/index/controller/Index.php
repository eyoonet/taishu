<?php
namespace app\index\controller;
use app\admin\model\User;
use think\Controller;

class Index extends Controller
{
    /**
     * 用户登录
     * @author eyoonet
     * @param user     string
     * @param password string
     * @return  userRow array
     */
    public function index()
    {
        if (request()->isPost()){
            $user       = input('post.user');
            $password   = input('post.password');
            $userModel  = new User;
            $users      = $userModel->login($user, $password);
            if($users){
                session('user',$users);
                return redirect(url('/admin/total'));
            }else {
                session('user', null);
                $this->error($userModel->getError(),url('index'));
            }            
        }
        return $this->fetch();
    }
    

}
