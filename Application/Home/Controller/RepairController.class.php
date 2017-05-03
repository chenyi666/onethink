<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/27
 * Time: 11:50
 */

namespace Home\Controller;


class RepairController extends HomeController
{
    public function add()
    {
        if(!$this->login()){
        if(IS_POST){
            $manager = D('Manager');
            $data = $manager->create();

            if($data){
                $manager->sn=rand(1000,99999).time();
                $manager->inputtime=time();
                $id = $manager->add();
                if($id){
                    session('ADMIN_Manager_LIST',null);
                    //记录行为
                    action_log('update_manager', 'manager', $id, UID);
                    $this->success('新增成功', Cookie('__forward__'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($manager->getError());
            }
        } else {
            /*    var_dump($this->assign('info',array('pid'=>I('pid'))));
                exit();*/
            $this->assign('info',array('pid'=>I('pid')));
            $manager = M('Manager')->field(true)->select();
            /* var_dump($manager);
             exit();*/
            $manager = D('Common/Tree')->toFormatTree($manager);
            $manager = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $manager);
            $this->assign('Manager', $manager);
            $this->meta_title = '新增菜单';
            $this->display('add');
        }
    }
    }
}