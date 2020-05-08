<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    
	private $User;
	
	public function _init(){
	   $this->User = session('UserInfo');
	}
	
	public function index(){

	   $this->display();
    }
	
	
	
	public function UserCount(){
	   
	   $M = M('order');
	   $rs = $M->field('SUM(a.price) as pri,a.uid,SUM(b.goods_num) as numes,c.nickname,c.id')->join(' as a LEFT JOIN __ORDER_GOODS__ as b on a.id=b.order_id')->join('LEFT JOIN __USER__ as c on a.uid=c.id')->where('a.state > 0  and a.ordtype<>2')->group('a.uid')->order('pri desc')->select();
	   
	   if($rs){
	      foreach($rs as $i => $q){
		     if($i < 6){
			    //$cuscount = $M->where('uid='.$q['uid'])->count();
				$areaData['areaData']['labels'][] = emnick($q['nickname']);
				$areaData['areaData']['maccount'][] = intval($q['numes']);
				$areaData['areaData']['cuscount'][] = $q['pri'];
			 }
		  }
	   }
	   $this->ajaxReturn($areaData);
	}
	
	public function AreaCount(){
	   $M = M('order_goods');
	   
	   $rs = $M->field('SUM(a.goods_num) as numes,a.goods_title')->join(' as a LEFT JOIN __ORDER__ as b on a.order_id=b.id')->where('b.state>0 and b.ordtype<>2')->group('a.goods_id')->order('numes desc')->select();
	   
	   //$this->ajaxReturn($label);
	   $coc = array('#f56954','#00a65a','#f39c12','#00c0ef','#3c8dbc','#d2d6de');
	   if($rs){
	      foreach($rs as $i => $q){
		     if($i < 6){
			    $output[] = array('value'=>$q['numes'],'color'=>$coc[$i],'highlight'=>$coc[$i],'label'=>$q['goods_title']);
			 }
		  }
	   }
	   $this->ajaxReturn($output);
	}	
	
	
}