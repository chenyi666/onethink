<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26
 * Time: 12:27
 */

namespace Admin\Controller;


use Think\Page;

class ManagerController extends AdminController
{
    public function index(){
        $count=M('Manager')->count();
        $page=new Page($count,1);
        $manager = M('Manager')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('page',$page->show());
        $this->assign('manager', $manager);
        $this->meta_title = '导航管理';
        $this->display();
    }

    public function add(){
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
            $this->display('edit');
        }
    }
    public function edit($id=0){
        if(IS_POST){
            $Manager = D('Manager');
            $data = $Manager->create();
            if($data){
                if($Manager->save()!== false){
                    session('ADMIN_Manager_LIST',null);
                    //记录行为
                    action_log('update_Manager', 'Manager', $data['id'], UID);
                    $this->success('更新成功', Cookie('__forward__'));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($Manager->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Manager')->field(true)->find($id);
            $Manager = M('Manager')->field(true)->select();
            $Manager = D('Common/Tree')->toFormatTree($Manager);

            $Manager = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $Manager);
            $this->assign('Managers', $Manager);
            if(false === $info){
                $this->error('获取后台菜单信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑后台菜单';
            $this->display();
        }
    }
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map = array('id' => array('in', $id) );
        if(M('Manager')->where($map)->delete()){
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
}