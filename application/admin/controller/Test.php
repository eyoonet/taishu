<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/17
 * Time: 17:54
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;
class Test extends Controller
{
    public function test(){
        $data=Db::table('think_test')


            /*   ->where([
                'name'  =>  ['like','thinkphp%'],
                'title' =>  ['like','%thinkphp'],
                'id'    =>  ['>',0],
                'status'=>  1
            ])*/
            ->fetchSql(true)
            ->select();
        return $data;
    }
}