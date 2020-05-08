<?php
namespace Admin\Controller;
use Think\Controller;
class FeedbackController extends CommonController {
	
    public function index(){
	   
	   //会员列表
	   $Model = M('feedback');
	   $count = $Model->count();
	   $Page = new \Think\Page($count,15);
	   $Page->setConfig('prev','上一页');
	   $Page->setConfig('next','下一页');
	   $show = $Page->show();
	   $showpage = 0;
	   if($count > 15){
	      $showpage = 1;
	   }
	   $rs = $Model->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();
	   
	   $this->assign('rslist',$rs);
	   $this->assign('showpage',$showpage);
	   $this->assign('pagination',$show);
	   
	   
	   $this->display();
	}

    public function delete(){
        $idarr = I('post.idarr');
        $table = I('post.table');
        $M = M($table);
        if(is_array($idarr)){
            foreach($idarr as $i => $q){
                if($i > 0){
                    $p .= ",";
                }
                $p .= $q;
            }
            $idarr = $p;
        }
        $isok = $M->where("id in(".$idarr.")")->delete();
        if($isok){
            $this->set_ajaxres('ok','删除成功','');
        }
        $this->ajaxReturn($this->ajaxres);
    }
	
}