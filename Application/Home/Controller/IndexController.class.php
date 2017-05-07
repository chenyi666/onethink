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
        //查询当前页的数据
        $document = D("Document");

//        $list = $document->lists('40');
//        var_dump($list);
//        $page = I('p',1);
//        $start = ($page-1)*C('LIST_ROWS');
//        $list = $document->where(['category_id'=>40])->limit($start.','.C('LIST_ROWS'))->select();


//        var_dump($document->getLastSql());
//        var_dump($list);
        //分配到视图

        /**
         * TP中分页类
         */
//        $count = $document->where(['category_id'=>40])->count();
//        $page = new Page($count,C('LIST_ROWS'));
//        $pageHtml = $page->show();


        $list = $document->where(['category_id'=>40])->page(I('p',1),C('LIST_ROWS'))->select();
        //选择视图

        foreach($list as &$v){
            $v['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $v['path'] = get_cover($v['cover_id'],"path");
//            $v['url'] = U('index',"id=".$v['id']);
            $v['url'] = U('detail',['id'=>$v['id']]);
        }
//        $this->assign('page',$pageHtml);

        if(IS_AJAX){//判断是否是ajax请求
            if(empty($list)){
                $this->error('没有数据');
            }else{
                $this->success($list);
            }
        }
        $this->assign('list',$list);
        $this->display();
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
    public function active(){
        //查询当前页的数据
        $document = D("Document");
        $list = $document->where(['category_id'=>41,'deadline>'.time().''])->page(I('p',1),C('LIST_ROWS'))->select();
        //选择视图

        foreach($list as &$v){
            $v['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $v['path'] = get_cover($v['cover_id'],"path");
//            $v['url'] = U('index',"id=".$v['id']);
            $v['url'] = U('detail',['id'=>$v['id']]);
        }
//        $this->assign('page',$pageHtml);

        if(IS_AJAX){//判断是否是ajax请求
            if(empty($list)){
                $this->error('没有数据');
            }else{
                $this->success($list);
            }
        }
        $this->assign('list',$list);
        $this->display();
    }
    public function shopactive(){
        //查询当前页的数据
        $document = D("Document");

//        $list = $document->lists('40');
//        var_dump($list);
//        $page = I('p',1);
//        $start = ($page-1)*C('LIST_ROWS');
//        $list = $document->where(['category_id'=>40])->limit($start.','.C('LIST_ROWS'))->select();


//        var_dump($document->getLastSql());
//        var_dump($list);
        //分配到视图

        /**
         * TP中分页类
         */
//        $count = $document->where(['category_id'=>40])->count();
//        $page = new Page($count,C('LIST_ROWS'));
//        $pageHtml = $page->show();


        $list = $document->where(['category_id'=>42,'deadline>'.time().''])->page(I('p',1),C('LIST_ROWS'))->select();
 /*       var_dump($document->getLastSql());
        exit;*/
        //选择视图

        foreach($list as &$v){
            $v['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $v['path'] = get_cover($v['cover_id'],"path");
//            $v['url'] = U('index',"id=".$v['id']);
            $v['url'] = U('detail',['id'=>$v['id']]);
        }
//        $this->assign('page',$pageHtml);

        if(IS_AJAX){//判断是否是ajax请求
            if(empty($list)){
                $this->error('没有数据');
            }else{
                $this->success($list);
            }
        }
        $this->assign('list',$list);
        $this->display();
    }
    public function enlist(){
        $id=I('id');
       //判断用户是否登录
        if(!$this->login()){
            $user=session('user_auth');
         $enlist=D('Enlist');
         $isjion=D('Enlist')->where(['uid'=>$user['uid'],'aid='.$id])->count();
         if($isjion>0){
             $this->error('报名失败');
         }
         $enlist->aid=$id;
         $enlist->uid=$user['uid'];

            if( $enlist->add()){
                $data=[
                    'success'=>'true',
                    'msg'=>'报名成功',
                ];
                $this->success($data);
            }

        }
    }
}