<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){

        $category = D('Category')->getTree();
        $lists    = D('Document')->lists(null);

        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表
        $this->assign('page',D('Document')->page);//分页

                 
        $this->display();
    }
    //小区通知显示
    public function notice(){
        $notices=D('Document')->select();
        foreach ($notices as $key=>$notice){
            //获取图片数据
            $img=D('Picture')->where(['id'=>$notice['cover_id']])->select();
/*            $content=D('Document_article')->where(['id'=>$notice['id']])->select();
            $notices[$key]['content']=$content[0]['content'];*/
            $notices[$key]['img']=$img[0]['path'];
        }

        //分配数据
        $this->assign('notices',$notices);
/*        $this->assign('imgs',$imgs);*/
        $this->display('notice');
    }
    public function detail($id){
        //根据id查询详情
        $content=D('Document_article')->find($id);
        $notice=D('Document')->find($id);
       //分配数据
        $this->assign('notice',$notice);
        $this->assign('content',$content);
        //展示视图
        $this->display('notice-detail');

    }

}