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
            $user=session('user_auth');
            $uid=$user['uid'];
            $member=D('Member')->find(['uid'=>$uid]);
    /*      var_dump($member);
            exit;*/
          $this->assign($member);
            $this->display('index');

        }

    }
    public function repair(){
        //根据用户uid查询报修信息
        $user=session('user_auth');
        $uid=$user['uid'];
        $repairs=D('Manager')->where(['uid'=>$uid])->select();
        $this->assign('repairs',$repairs);
        $this->display();
    }
    public function actives(){
        //根据用户uid查询报名活动信息
        $user=session('user_auth');
        $uid=$user['uid'];
        //查询活动和用户关系表
        $actives=D('Enlist')->where(['uid'=>$uid])->select();

        foreach ($actives as &$active){
        //根据活动ID查询活动内容
            $content=D('Document')->where(['id'=>$active['aid']])->find();
            //根据aid查询活动详情
            $detail=D('Document_article')->where(['id'=>$active['aid']])->find();

           /* $picture=D('Picture')->where(['id'=>$active['aid']])->find();*/
            $active['path'] = get_cover($active['cover_id'],"path");
            $active['content']=$detail['content'];
            $active['title']=$content['title'];
            $active['description']=$content['description'];
           /* $active['path']=$picture['path'];*/
        }
        //分配数据，展示页面
         $this->assign('actives',$actives);
        $this->display('active');
    }
    //签到
    public function sign(){
        //获取用户UID
        $user=session('user_auth');
        $uid=$user['uid'];
        $sign=D('Sign')->where(['uid'=>$uid,'date'=>date('Ymd',time())])->find();
        if($sign){
            //当天已经签到了
            $this->error('今天已经签到了');
        }else{
            //保存签到信息
            $sign=D('Sign');
            $sign->uid=$uid;
            $sign->date=date('Ymd',time());
            if($sign->add()){
                //签到保存成功，更新积分
                D('Member')->where(['id'=>$uid])->setInc('score',10);
                //查询出现在的积分
                $member=D('Member')->where(['id'=>$uid])->find();
                $this->success($member['score']);
            };
        }
    }
    //我的资料
    public function data(){
        $user=session('user_auth');
        $uid=$user['uid'];
        $data=D();
    }

}