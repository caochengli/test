<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace Think\Template\TagLib;
use Think\Template\TagLib;
/**
 * Html标签库驱动
 */
class Jwcms extends TagLib{
    // 标签定义
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'list' => array('attr'=>'id,focus,table,limit,field,where,order,key,item,index','close'=>1),
		'cate' => array('attr'=>'id,limit,isnav,fid,field,where,order,key,item,index','close'=>1)
    );
	
	public function _list($tag,$content){
	   
	   $tb = isset($tag['table'])?$tag['table']:'goods';
	   $lim = isset($tag['limit'])?$tag['limit']:'0,10';
	   if(!strpos($lim,',')){
	      $lim = "0,".$lim;
	   }
	   $ord = isset($tag['order'])?$tag['order']:'taxis desc,id desc';
	   $where = isset($tag['where'])?$tag['where']:'';
	   $field = "id,title,pic,tags,acttime,price,ypri,rpri,cateid,catename,ordtype";
	   $fields = isset($tag['field'])?$tag['field']:'';
	   if(!empty($fields)){
	      $field .= ",".$fields;
	   }
	   $id = isset($tag['id'])?$tag['id']:'';
	   $focus = isset($tag['focus']) ? $this->autoBuildVar($tag['focus']) : '';
	   $key = isset($tag['key'])?$tag['key']:'i';
	   $item = isset($tag['item'])?$tag['item']:'rs';
	   $index = isset($tag['index'])?$tag['index']:'0';
	   $condition = "sta=1";
	   $idarr = "";
	   if(!empty($id)){
	      $A = A("Common");
		  $idarr = $A -> GetSonArr($id);
		  $condition .= " and cateid in(".$idarr.")";
	   }
	   if(!empty($where)){
	      $condition .= " and ".$where;
	   }
	   $str = '<?php
		  $cond = "'.$condition.'";
		  $foc = "'.$focus.'";
		  $ida = "'.$idarr.'";
		  if(!empty($foc)&&empty($ida)){
		     $A = A("Common");
			 $idarr = $A -> GetSonArr("$foc");
			 //die("$idarr");
			 $cond .= " and cateid in(".$idarr.")";
		  }
		  //die("$cond");
		  $table =  M("'.$tb.'");
		  $rs = $table -> field("'.$field.'") -> where("$cond") -> limit("'.$lim.'") -> order("'.$ord.'") -> select();
		  $ret = array();
		  $'.$key.' = '.$index.';
		  foreach($rs as $i => $q){
		     $ret[$i] = $q;
			 $ret[$i]["links"] = U("/Show/index",array("id"=>$q["id"]));
		  }		  
		  foreach($ret as $k=>$'.$item.'):
		  $'.$key.'++;
	   ?>';
	   $str .= $content;
	   $str .= "<?php endforeach ?>";
	   return $str;
	}
	
	public function _cate($tag,$content){
	   $id = isset($tag['id'])?$tag['id']:'0';
	   //if(empty($id)){
	      //return false;
	   //}
	   //$fid = isset($tag['fid']) ? $this->autoBuildVar($tag['fid']) : '';
	   //$active = isset($tag['act']) ? $this->autoBuildVar($tag['act']) : '';
	   $lim = isset($tag['limit'])?$tag['limit']:'0,20';
	   if(!strpos($lim,',')){
	      $lim = "0,".$lim;
	   }
	   $ord = isset($tag['order'])?$tag['order']:' taxis desc,id desc';
	   $where = isset($tag['where'])?$tag['where']:'';
	   
	   $field = "id,catename,icon";
	   $fields = isset($tag['field'])?$tag['field']:'';
	   if(!empty($fields)){
	      $field .= ",".$fields;
	   }
	   
	   
	   $key = isset($tag['key'])?$tag['key']:'i';
	   $item = isset($tag['item'])?$tag['item']:'rs';
	   $index = isset($tag['index'])?$tag['index']:'0';
	   //die($id);
	   $condition = "1=1 and pid=".$id;
	   
	   if(!empty($where)){
	      $condition .= " and ".$where;
	   }
	   //die($condition);
	   $str = '<?php
		  $cond = "'.$condition.'";
		  $table =  M("goods_cate");
		  $rs = $table -> field("'.$field.'") -> where("$cond") -> limit("'.$lim.'") -> order("'.$ord.'") -> select();
		  
		  $ret = array();
		  $'.$key.' = '.$index.';
		  foreach($rs as $i => $q){
		     $ret[$i] = $q;
			 $ret[$i]["links"] = U("/Cate/index",array("id"=>$q["id"]));
		  }		  
		  foreach($ret as $k=>$'.$item.'):
		  $'.$key.'++;
	   ?>';
	   $str .= $content;
	   $str .= "<?php endforeach ?>";
	   return $str;
	}
}