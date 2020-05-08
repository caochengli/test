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
        'list' => array('attr'=>'id,focus,table,limit,field,where,order,key,item,index,join,artlink','close'=>1),
        'listrand' => array('attr'=>'id,limit,field,where,order,key,item,index','close'=>1),
		'cate' => array('attr'=>'id,limit,isnav,fid,field,where,order,key,item,index','close'=>1),
        'catefind' => array('attr'=>'isnav,field,where,order,key,item,index','close'=>1),
		'cateinfo' => array('attr'=>'id,field','close'=>1),
        'catelist' => array('attr' => 'id,focus,limit,isnav,fid,field,where,order,key,item,index', 'close' => 1),
    );
	
	public function _list($tag,$content){
	   
	   $tb = isset($tag['table'])?$tag['table']:'content';
	   $lim = isset($tag['limit'])?$tag['limit']:'0,10';
	   $artlink = isset($tag['artlink'])?$tag['artlink']:'/Show/index';
	   if(!strpos($lim,',')){
	      $lim = "0,".$lim;
	   }
	   $where = isset($tag['where'])?$tag['where']:'';
	   $join = isset($tag['join'])?$tag['join']:'';
	   $field = "id,title,defaultpic,tags,savename,cateid,catename,links,addtime,hits";
	   $ord = isset($tag['order'])?$tag['order']:'taxis desc,id desc';
	   
	   if(!empty($join)){
	   	  $field_arr = explode(',',$field);
		  $field = '';
		  foreach($field_arr as $q){
		     if(!empty($field)){
			    $field .= ',';
			 }
			 $field .= "a.".$q;
		  }
		  $ord = isset($tag['order'])?$tag['order']:'a.taxis desc,a.id desc'; 
	   }
	   
	   $fields = isset($tag['field'])?$tag['field']:'';
	   if(!empty($fields)){
		  $field .= ",".$fields;
	   }
	   $id = isset($tag['id'])?$tag['id']:'';
	   $focus = isset($tag['focus']) ? $this->autoBuildVar($tag['focus']) : '';
	   $key = isset($tag['key'])?$tag['key']:'i';
	   $item = isset($tag['item'])?$tag['item']:'rs';
	   $index = isset($tag['index'])?$tag['index']:'0';
	   $condition = "1=1";
	   global $str;
	   $str = '';
	   $idarr = "";
	   if(!empty($id)){
	      $Help = A("Help");
		  $idarr = $Help -> GetSonArr($id);
		  if(!empty($join)){
		     $condition .= " and a.cateid in(".$idarr.")";
		  }else{
		     $condition .= " and cateid in(".$idarr.")";
		  }
	   }
	    if(!empty($where)){
	        $condition .= " and ".$where;
	    }
	   $str = '<?php
		  $cond = "'.$condition.'";		  
		  $foc = "'.$focus.'";
		  $ida = "'.$idarr.'";
		  $join = "'.$join.'";
		  if(!empty($foc)&&empty($ida)){
		     $Help = A("Help");
			 $idarr = $Help -> GetSonArr(5);			 
			 if(!empty($join)){
			    $cond .= " and a.cateid in(".$idarr.")";
			 }else{
		        $cond .= " and cateid in(".$idarr.")";
			 }
		  }
		  $table =  M("'.$tb.'");
		  if(!empty($join)){
		     $rs = $table -> field("'.$field.'") -> join(" as a LEFT JOIN __CATEGORY__ as b ON a.cateid=b.id") -> where("$cond") -> limit("'.$lim.'") -> order("'.$ord.'") -> select();
		  }else{
		     $rs = $table -> field("'.$field.'") -> where("$cond") -> limit("'.$lim.'") -> order("'.$ord.'") -> select();
		  }
		  
		  $ret = array();
		  $'.$key.' = '.$index.';
		  foreach($rs as $i => $q){
		     $ret[$i] = $q;
			 if(empty($q["links"])){
			    $ret[$i]["links"] = C("SITE_URL")."/".$q["dirname"]."/".$q["savename"].".html";
			 }
		  }		  
		  foreach($ret as $k=>$'.$item.'):
		  $'.$key.'++;
	   ?>';
	   $str .= $content;
	   $str .= "<?php endforeach ?>";
	   return $str;
	}

    public function _listrand($tag,$content){
        $lim = isset($tag['limit'])?$tag['limit']:'0,10';
        if(!strpos($lim,',')){
            $lim = "0,".$lim;
        }
        $where = isset($tag['where'])?$tag['where']:'';
        $field = "a.id,a.title,a.defaultpic,a.tags,a.links,a.addtime,a.savename,b.dirname";
        $ord = isset($tag['order'])?$tag['order']:'rand()';

        $fields = isset($tag['field'])?$tag['field']:'';
        if(!empty($fields)){
            $field .= ",".$fields;
        }
        $id = isset($tag['id']) ? $this->autoBuildVar($tag['id']) : '';
        $key = isset($tag['key'])?$tag['key']:'i';
        $item = isset($tag['item'])?$tag['item']:'rs';
        $index = isset($tag['index'])?$tag['index']:'0';

        $condition = "a.cateid=".$id;
        if(!empty($where)){
            $condition .= " and ".$where;
        }

        $str = '<?php
		  $cond = "'.$condition.'";
		  $table =  M("content");
		  
		  $rs = $table -> field("'.$field.'") -> join(" as a LEFT JOIN __CATEGORY__ as b ON a.cateid=b.id") -> where("$cond") -> limit("'.$lim.'") -> order("'.$ord.'") -> select();
		  
		  $ret = array();
		  $'.$key.' = '.$index.';
		  foreach($rs as $i => $q){
		     $ret[$i] = $q;
			 if(empty($q["links"])){
			    $ret[$i]["links"] = C("SITE_URL")."/".$q["dirname"]."/".$q["savename"].".html";
			 }else{
			    $ret[$i]["links"] = $q["links"];
			 }
		  }		  
		  foreach($ret as $k=>$'.$item.'):
		  $'.$key.'++;
	   ?>';
        $str .= $content;
        $str .= "<?php endforeach ?>";
        return $str;
    }
	
	public function _cate($tag,$content){
	   $id = isset($tag['id'])?$tag['id']:'';
	   //if(empty($id)){
	      //return false;
	   //}
	   $fid = isset($tag['fid']) ? $this->autoBuildVar($tag['fid']) : '';
	   //$active = isset($tag['act']) ? $this->autoBuildVar($tag['act']) : '';
	   $lim = isset($tag['limit'])?$tag['limit']:'0,10';
	   if(!strpos($lim,',')){
	      $lim = "0,".$lim;
	   }
	   $ord = isset($tag['order'])?$tag['order']:' taxis desc,id desc';
	   $where = isset($tag['where'])?$tag['where']:'';
	   $isnav = isset($tag['isnav'])?$tag['isnav']:'0';
	   $field = "id,catename,defaultpic,links,model";
	   $fields = isset($tag['field'])?$tag['field']:'';
	   if(!empty($fields)){
	      $field .= ",".$fields;
	   }
	   
	   
	   $key = isset($tag['key'])?$tag['key']:'i';
	   $item = isset($tag['item'])?$tag['item']:'rs';
	   $index = isset($tag['index'])?$tag['index']:'0';
	   
	   if($fid){
	      $condition = "1=1 and pid=".$fid;
	   }else{
	      if(empty($id)){
		     return false;
		  }else{
		     $condition = "1=1 and pid=".$id;
		  }
	   }
	   if($isnav==1){
	      $condition .= " and isnav=1";
	   }
	   if(!empty($where)){
	      $condition .= " and ".$where;
	   }
	   $str = '<?php
		  $cond = "'.$condition.'";		  
		  $table =  M("category");
		  $rs = $table -> field("'.$field.'") -> where("$cond") -> limit("'.$lim.'") -> order("'.$ord.'") -> select();		  
		  $'.$key.' = '.$index.';		  
		  foreach($rs as $k=>$'.$item.'):
		  $'.$key.'++;
	   ?>';
	   $str .= $content;
	   $str .= "<?php endforeach ?>";
	   return $str;
	}
	
	public function _cateinfo($tag,$content){
	   $id = isset($tag['id'])?$tag['id']:'';	   
	   $field = "id,catename,defaultpic,dirname,links,model";
	   $fields = isset($tag['field'])?$tag['field']:'';
	   if(!empty($fields)){
	      $field .= ','.$fields;
	   }
	   $key = isset($tag['key'])?$tag['key']:'i';
	   $item = isset($tag['item'])?$tag['item']:'rs';
	   $index = isset($tag['index'])?$tag['index']:'0';
	   $condition = "id=".$id;
	   $str = '<?php
		  $cond = "'.$condition.'";		  
		  $table =  M("category");
		  $rs = $table -> field("'.$field.'") -> where("$cond") -> find();
		  if($rs){
		     if($rs["links"] == ""){
				 $rs["links"] = C("SITE_URL")."/".$rs["dirname"]."/index.html";
			 }
	   ?>';
	   $str .= $content;
	   $str .= "<?php } ?>";
	   return $str;
	}

    public function _catelist($tag, $content)
    {
        $id = isset($tag['id']) ? $tag['id'] : '';
        $fid = isset($tag['fid']) ? $this->autoBuildVar($tag['fid']) : '';
        $focus = isset($tag['focus']) ? $this->autoBuildVar($tag['focus']) : '';
        $lim = isset($tag['limit']) ? $tag['limit'] : '0,10';
        if (!strpos($lim, ',')) {
            $lim = "0," . $lim;
        }
        $ord = isset($tag['order']) ? $tag['order'] : ' taxis desc,id desc';
        $where = isset($tag['where']) ? $tag['where'] : '';
        $isnav = isset($tag['isnav']) ? $tag['isnav'] : '0';
        $field = "id,catename,defaultpic,links,model,dirname";
        $fields = isset($tag['field']) ? $tag['field'] : '';
        if (!empty($fields)) {
            $field .= "," . $fields;
        }
        $key = isset($tag['key']) ? $tag['key'] : 'i';
        $item = isset($tag['item']) ? $tag['item'] : 'rs';
        $index = isset($tag['index']) ? $tag['index'] : '0';


        $condition = '1=1';

        if ($fid) {
            $condition .= " and pid=" . $fid;
        } else {
            if (!empty($id)) {
                $condition .= " and pid=" . $id;
            }
        }
        if ($isnav == 1) {
            $condition .= " and isnav=1";
        }
        if (!empty($where)) {
            $condition .= " and " . $where;
        }
        $str = '<?php
          $foc = "'.$focus.'";
          if(!empty($foc)){
             $cond = "1=1 and pid=".$foc;
          }else{
             $cond = "' . $condition . '";
          }		  		  
		  $table =  M("category");
		  $rs = $table -> field("' . $field . '") -> where("$cond") -> limit("' . $lim . '") -> order("' . $ord . '") -> select();		  
		  $' . $key . ' = ' . $index . ';		  
		  foreach($rs as $k=>$' . $item . '):
		  $' . $key . '++;
	   ?>';
        $str .= $content;
        $str .= "<?php endforeach ?>";
        return $str;
    }

    public function _catefind($tag,$content){
        $ord = isset($tag['order'])?$tag['order']:' taxis desc,id desc';
        $where = isset($tag['where'])?$tag['where']:'';
        $isnav = isset($tag['isnav'])?$tag['isnav']:'0';
        $field = "id,catename,defaultpic,links,model,dirname";
        $fields = isset($tag['field'])?$tag['field']:'';
        if(!empty($fields)){
            $field .= ",".$fields;
        }
        $key = isset($tag['key'])?$tag['key']:'i';
        $item = isset($tag['item'])?$tag['item']:'rs';
        $index = isset($tag['index'])?$tag['index']:'0';

        $condition = '1=1';

        if($isnav==1){
            $condition .= " and isnav=1";
        }
        if(!empty($where)){
            $condition .= " and ".$where;
        }
        $str = '<?php
		  $cond = "'.$condition.'";	  
		  $table =  M("category");
		  $rs = $table -> field("'.$field.'") -> where("$cond") -> limit("'.$lim.'") -> order("'.$ord.'") -> select();		  
		  $'.$key.' = '.$index.';		  
		  foreach($rs as $k=>$'.$item.'):
		  $'.$key.'++;
	   ?>';
        $str .= $content;
        $str .= "<?php endforeach ?>";
        return $str;
    }


}