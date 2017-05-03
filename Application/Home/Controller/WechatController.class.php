<?php
namespace Home\Controller;
use EasyWeChat\Core\Exceptions\HttpException;
use EasyWeChat\Foundation\Application;
require './vendor/autoload.php';
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2
 * Time: 11:45
 */
class WechatController extends \Home\Controller\HomeController
{
    public function index()
    {
        //接口认证
        $app = new Application(C('wechat'));
        $server = $app->server;
        $response = $server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;

        //return $_GET['echostr'];服务器验证最简单的方法
    }
    //设置菜单
    public function setmenus()
    {
        $app = new Application(C('wechat'));
        $menu = $app->menu;
        $buttons = [
            [
                "name"       => "个人中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "物业管理",
                        "url"  => U('Home/index/index','','',true),
                    ],
                    [
                        "type" => "view",
                        "name" => "我的信息",
                        "url"  => U('Home/Wechat/index','','',true),
                    ],
                    [
                        "type" => "view",
                        "name" => "绑定账号",
                        "url" =>U('Home/Wechat/bang','','',true),
                    ],

                ],
            ],
        ];
        $r = $menu->add($buttons);
        var_dump($r);
    }
    public function callback(){
        $app = new Application(C('wechat'));
//        echo 'callback';
        $user = $app->oauth->user();
        //用户的openid
        //$user->id;
        //将用户的openid保存到session
       session('openid',$user->id);

     /*   //跳回请求地址
        if(\Yii::$app->session->has('back')){
            return $this->redirect([\Yii::$app->session->get('back')]);
        }else{
//            return $this->redirect(['wechat/bang']);
            var_dump(\Yii::$app->session->get('back',null,true));
        }*/

    }
    public function user(){
        if($this->login()){
        //\Yii::$app->session->set('return','wechat/user');
            $this->redirect('Home/User/login');
    }
        /*//检查session中是否有openid
        //如果没有
        if(!\Yii::$app->session->get('openid')){
            //获取用户的openid
            //echo 'user';
            $app = new Application(\Yii::$app->params['wechat']);
            $response = $app->oauth->redirect();
            //将当前路由保存到session，便于授权回调地址跳回当前页面
            \Yii::$app->session->setFlash('back','wechat/user');
            $response->send();
        }
        //从session中获取openid
        $openid = \Yii::$app->session->get('openid');
        //查询该openid是否绑定账号
        $member = Member::findOne(['openid'=>$openid]);
        if($member == null){
            //没有绑定，跳转到绑定页面
            return $this->redirect(['wechat/bang']);
        }*/
        //显示当前用户的账号信息
        var_dump(\Yii::$app->user->identity);
    }
    //绑定账号
    public function bang(){
        if(!session('openid')){
            //获取用户的openid
            //echo 'user';
            $app = new Application(C('wechat'));
            session('back','wechat/bang');
            $response = $app->oauth->redirect();
            //将当前路由保存到session，便于授权回调地址跳回当前页面

            $response->send();
        }
        //从session中获取openid
        $openid= session('openid');
        if($openid==null){
            throw new HttpException(404,'未获取到用户信息');
        }

     /*   if($member){//如果已绑定账号，则显示解绑按钮
            \Yii::$app->user->login($member);//使用openid自动登录
            if(\Yii::$app->session->has('return')){
                return $this->redirect([\Yii::$app->session->get('return')]);
            }
            return $this->render('unlink');
        }*/
        //如果未绑定账号，则跳转到登录页面，登录时保存openid
        $this->redirect('Home/User/login');
    }
}