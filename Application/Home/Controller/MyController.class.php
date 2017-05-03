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

        $this->display('index');
    }
}