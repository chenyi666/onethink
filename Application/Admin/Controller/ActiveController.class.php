<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/28
 * Time: 14:45
 */

namespace Admin\Controller;


class ActiveController extends AdminController
{
    //获取所有活动报名信息
    public function index(){
        $actives=D('Enlist')->select();
        foreach ($actives as &$active){
            //获取活动内容
            $document=D('Document')->where(['id'=>$active['aid']])->select();

            $active['title']=$document[0]['title'];
            //获取报名用户
            $person=D('Member')->where(['uid'=>$active['uid']])->select();
            $active['name']=$person[0]['nickname'];
        }
    /*    var_dump($actives);
        exit();*/
        //分配数据 显示页面
        $this->assign('actives',$actives);
        $this->display();
    }
    //在线审核
    public function auditing(){

    }
}