<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2
 * Time: 10:06
 */

namespace Home\Controller;


class MyController extends HomeController
{
    public function index(){
        if(!$this->login()){
            //判断用户是否登录，查询用户的信息，分配到视图
            $uid=

            $this->display('index');

        }

    }
}