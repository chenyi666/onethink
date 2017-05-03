<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2
 * Time: 9:27
 */

namespace Admin\Controller;


use EasyWeChat\Foundation\Application;

class WechatController extends AdminController
{
    public function actionIndex()
    {
        //接口认证
        $app = new Application(C('wechat'));
        $server = $app->server;
        $response = $server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;

        //return $_GET['echostr'];服务器验证最简单的方法
    }
}