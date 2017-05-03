<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/27
 * Time: 10:38
 */

namespace Admin\Controller;


use Think\Upload;

class InformController extends AdminController
{
    public function index(){

    }
    public function add(){
        if(IS_POST){
            $inform = D('Inform');
            $data = $inform->create();
            //图片处理
            $upload = new Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功
                $this->success('上传成功！');
            }

            if($data){
                $inform->inputtime=time();
                $id = $inform->add();
                if($id){
                    session('ADMIN_Manager_LIST',null);
                    //记录行为
                    action_log('update_manager', 'manager', $id, UID);
                    $this->success('新增成功', Cookie('__forward__'));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($inform->getError());
            }
        } else {
            /*    var_dump($this->assign('info',array('pid'=>I('pid'))));
                exit();*/
            $this->assign('info',array('pid'=>I('pid')));
            $inform = M('Inform')->field(true)->select();
            /* var_dump($manager);
             exit();*/
            $inform = D('Common/Tree')->toFormatTree($inform);
            $inform = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $inform);
            $this->assign('Inform', $inform);
            $this->meta_title = '新增小区通知';
            $this->display('edit');
        }
    }
}