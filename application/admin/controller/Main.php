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
    public function index()
    {
        return $this->fetch();
    }
}
