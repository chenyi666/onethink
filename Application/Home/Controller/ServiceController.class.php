<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2
 * Time: 10:17
 */

namespace Home\Controller;


class ServiceController extends HomeController
{
    public function index(){
        $this->display('index');
    }
    public function identify(){
        //判断用户是否登录
        if(!$this->login()){
            //展示业主认证页面
            $this->display('identify');
        }
    }
    public function save(){
        if (!$this->login()){
            $owern=D('Owner');
            $data=I('post.');
            $owern->create($data);
            $owern->add();

            var_dump($owern);
            exit();
        }
    }
}