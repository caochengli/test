<?php
namespace Admin\Controller;
use Think\Controller;
class RegionController extends CommonController {
    
	
	/*
	  ## get_regions
	  ## 获取城市列表
	*/
	public function get_regions($type = 0, $parent = 0,$inarr='',$is_open=0){
	   
	   $str = '';
	   $Model = M('region');
	   $condition = 'region_type='.$type.' and parent_id='.$parent;	
	   if(!empty($inarr) && $inarr != 0){
	      $condition .= " and region_id in(".$inarr.")";
	   }  
	   if($is_open != 0 && $type < 3){
	      $condition .= " and is_open=1";
	   }  
	   
	   $order = "region_id asc"; 
	   if($type == 2){
	      $order = "region_id desc";
	   }
	   $rs = $Model->field('region_id,region_name')->where($condition)->order($order)->select();
	   if($rs){
	      foreach($rs as $q){
		     
			 $str .= "<option value='".$q['region_id']."'>".$q['region_name']."</option>";
			 
		  }
	   }else{
	      //记录集为空,判断是第几层
		  if(!empty($inarr) && $inarr != 0){
		     if($type != 1){
			    $rs = $Model->field('region_id,region_name')->where('region_type='.$type.' and parent_id='.$parent)->select();
				if($rs){
				   foreach($rs as $q){
					  $str .= "<option value='".$q['region_id']."'>".$q['region_name']."</option>";
				   }
				}
			 } 
		  }
	   }
	   echo $str;	   
	}
	
	public function get_regions_opencity($id=0){
	   $Region = M('region');
	   $rs = $Region->field('region_id,region_name')->where('region_type=2 and is_open=1')->select();
	   foreach($rs as $q){
	      if($q['region_id'] == $id){
		     $str .= "<option value='".$q['region_id']."' selected='selected'>".$q['region_name']."</option>";
		  }else{
		     $str .= "<option value='".$q['region_id']."'>".$q['region_name']."</option>";
		  }
	   }
	   $this->ajaxReturn($str);
	}
	
	/*
	  ## get_regions
	  ## 获取城市列表
	*/
	public function get_regions_post(){
	   $type = I('post.type');
	   $parent = I('post.parent');
	   //$inarr = I('post.inarr');
	   $str = '';
	   $Model = M('region');
	   $condition = 'region_type='.$type.' and parent_id='.$parent;	
	    
	   $order = "region_id asc"; 
	   if($type == 2){
	      $order = "region_id desc";
	   }
	   $rs = $Model->field('region_id,region_name')->where($condition)->order($order)->select();
	   if($rs){
	      foreach($rs as $q){
		     
			 $str .= "<option value='".$q['region_id']."'>".$q['region_name']."</option>";
			 
		  }
	   }else{
	      //记录集为空,判断是第几层
		  if(!empty($inarr) && $inarr != 0){
		     if($type != 1){
			    $rs = $Model->field('region_id,region_name')->where('region_type='.$type.' and parent_id='.$parent)->select();
				if($rs){
				   foreach($rs as $q){
					  $str .= "<option value='".$q['region_id']."'>".$q['region_name']."</option>";
				   }
				}
			 } 
		  }
	   }
	   echo $str;	   
	}
	
	public function seeReg(){
	   $str = $this->regparents(589);
	   dump($str);
	}
	
	public function regparents($id,$type=3){
	   static $ecson;
	   $M = M('region');
	   $pid = $M->where('region_id='.$id)->getField('parent_id');
	   switch($type){
	      case 3:
		  //$ecson['Districts']['id'] = $id;
		  $ecson['Districts'] = $this->regsiblings($id);
		  break;
		  case 2:
		  //$ecson['Cities']['id'] = $id;
		  $ecson['Cities'] = $this->regsiblings($id);
		  break;
		  case 1:
		  //$ecson['Provinces']['id'] = $id;
		  $ecson['Provinces'] = $this->regsiblings($id);
		  break;
	   }
	   $type--;
	   if($type == 0){
	      return;
	   }else{
	      $this->regparents($pid,$type);
	   }
	   $this->ajaxReturn($ecson);
	}
	
	public function regparents_area($id,$type=4){
	   if($id == 0){
	      return;
	   }
	   static $ecson;
	   $M = M('region');
	   $pid = $M->where('region_id='.$id)->getField('parent_id');
	   switch($type){
	      case 4:
		  $ecson['Area']['id'] = $id;
		  $ecson['Area']['optlis'] = $this->regsiblings($id);
		  break;
		  case 3:
		  $ecson['Districts']['id'] = $id;
		  $ecson['Districts']['optlis'] = $this->regsiblings($id);
		  break;
		  case 2:
		  $ecson['Cities']['id'] = $id;
		  $ecson['Cities']['optlis'] = $this->regsiblings($id);
		  break;
		  case 1:
		  $ecson['Provinces']['id'] = $id;
		  $ecson['Provinces']['optlis'] = $this->regsiblings($id);
		  break;
	   }
	   $type--;
	   if($type == 0){
		  return;		  
	   }else{
	      $this->regparents_area($pid,$type);
	   }
	   $this->ajaxReturn($ecson);
	   //return ;
	}
	
	/*
	  ## 根据商圈ID查找所有有效option
	*/
	public function sqregall($sid){
	   global $regson;
	   $M = M('region');
	   $rs = $M->field('region_type,parent_id,region_id')->where('region_id='.$sid)->find();
	   $regson = $regson.",".$rs['region_id'];
	   if($rs['region_type']>1){
	      $this->sqregall($rs['parent_id']);
	   }
	   return $regson;
	}
	
	public function regsiblings($id){
	   $M = M('region');
	   $inarr = session('reginarr');
	   $cond = "1=1";
	   if(!empty($inarr)){
	      $cond .= " and region_id in(".$inarr.")";
	   }
	   $pid = $M->where('region_id='.$id)->getField('parent_id');
	   $str = '';
	   if($pid){
	      $rs = $M->field('region_name,region_id')->where($cond.' and parent_id='.$pid)->select();
		  if($rs){
		     foreach($rs as $q){
			     if($q['region_id'] == $id){
			        $str .= "<option value='".$q['region_id']."' selected='selected'>".$q['region_name']."</option>";
				 }else{
					$str .= "<option value='".$q['region_id']."'>".$q['region_name']."</option>";
				 }
			 }
		  }
	   }
	   return $str;
	}
	
}