<?php
namespace Admin\Controller;
use houdunwang\dir\Dir;
use Think\Controller;
class MakeHtmlController extends CommonController {

    private $Dir;
    private $Cate;
    private $Cont;
    private $prefix;
    private $baseLink;
    private $outbase;

    public function _init(){
        $this->Dir = new Dir();
        $this->Cate = M('category');
        $this->Cont = M('content');
        $this->prefix = './';
        $this->baseLink = 'http://'.$_SERVER['HTTP_HOST'].'/index.php';
        $this->outbase = '/';
        $makefor = I('get.makefor');
        if($makefor == 1){
            $this->prefix = './m/';
            $this->baseLink = 'http://'.$_SERVER['HTTP_HOST'].'/wap.php';
            $this->outbase = '/m/';
        }
    }

    public function CreatCloum(){
        $this->display();
    }

    public function loadCateTree(){
        $res = categorytree('category');
        //dump($res);
        $rs = array_values($res);
        $this->ajaxReturn($rs);
    }

    public function checkText($id){
        $arr = array(
            'state' => $id
        );
        $this->ajaxReturn($arr);
    }

    public function doCreatCloumHtml($id){
        $rs = $this->Cate->field('model,dirname,links')->where('id='.$id)->find();
        $res = array(
            'bytes' => 0
        );
        if(!empty($rs['links'])){
            $res['type'] = 'links';
            $this->ajaxReturn($res);
        }
        switch ($rs['model']){
            case 0:
                $this->doMakePage($id,$rs['dirname']);
                break;
            case 1:
                $this->doMakeList($id,$rs['dirname']);
                break;
            default:
                $this->ajaxReturn($res);
        }
    }

    /**
       # 生成单页
    **/
    public function doMakePage($id,$dirname){
        //$url = 'http://'.$_SERVER['HTTP_HOST'];
        $HtmlData = file_get_contents($this->baseLink.'/Page/index/id/'.$id);
        $dir = $this->prefix.$dirname.'/index.html';

        //如果目录不存在或被删除
        if(!is_dir($this->prefix.$dirname)){
            $this->Dir->create($this->prefix.$dirname);
        }

        $res['bytes'] = 0;
        $res['p'] = 1;
        if($HtmlData){
            $res['bytes'] = file_put_contents($dir,$HtmlData);
            $res['links'] = $this->outbase.$dirname.'/index.html';
        }
        $this->ajaxReturn($res);
    }

    /**
    # 生成列表
    **/
    public function doMakeList($id,$dirname,$p=1){
        static $res = [];
        $runtimes = $this->runTimes($id);
        if($p <= $runtimes){
            if(!is_dir($this->prefix.$dirname)){
                $this->Dir->create($this->prefix.$dirname);
            }
            if($p==1){
                $dir = $this->prefix.$dirname.'/index.html';
                $res['links'] = $this->outbase.$dirname.'/index.html';
            }else{
                $dir = $this->prefix.$dirname.'/index-'.$p.'.html';
            }
            $HtmlData = file_get_contents($this->baseLink.'/Article/index/id/'.$id.'/p/'.$p);
            if($HtmlData){
                $bytes = file_put_contents($dir,$HtmlData);
                if($bytes > 0){
                    $res['p'] += 1;
                    $res['bytes'] += $bytes;
                }
            }
            $p += 1;
            $this->doMakeList($id,$dirname,$p);
        }
        $this->ajaxReturn($res);
    }

    public function runTimes($id){
        $condition = 'cateid='.$id;
        $rs = $this->Cate->field('isindex,pagesize')->where('id='.$id)->find();
        if($rs['isindex'] == 1){
            //select sons
            $idarr = $this->GetSonArr($id);
            $condition = 'cateid in('.$idarr.')';
        }
        $count = $this->Cont->where($condition)->count('id');
        $count = ($rs['pagesize']>$count) ? 1 : ceil($count/$rs['pagesize']);
        return $count;
    }

    public function doCreatViewHtml($id){
        $state = $this->getViewCount($id);
        if(!$state){
            $res = array(
                'bytes' => 0,
                'type' => 'emp'
            );
        }else{
            $this->buildHtmlAct($id);
        }
        $this->ajaxReturn($res);
    }

    public function buildHtmlAct($id){
        $res = array(
            'bytes' => 0,
            'p' => 0
        );
        $dirname = $this->Cate->where('id='.$id)->getField('dirname');
        //如果目录不存在或被删除
        if(!is_dir($this->prefix.$dirname)){
            $this->Dir->create($this->prefix.$dirname);
        }

        $rs = $this->Cont->field('id,savename')->where('cateid='.$id)->select();
        foreach($rs as $q){
            //$url = 'http://'.$_SERVER['HTTP_HOST'];
            $HtmlData = file_get_contents($this->baseLink.'/Show/index/id/'.$q['id']);
            if($HtmlData){
                $dir = $this->prefix.$dirname.'/'.$q['savename'].'.html';
                $bytes = file_put_contents($dir,$HtmlData);
                if($bytes > 0){
                    $res['p'] += 1;
                    $res['bytes'] += $bytes;
                }
            }
        }
        $this->ajaxReturn($res);
    }

    public function getViewCount($id){
        $rs = $this->Cont->where('cateid='.$id)->count();
        if($rs > 0){
            return true;
        }
        return false;
    }

    public function setIndex(){
        $url = 'http://'.$_SERVER['HTTP_HOST'];
        $HtmlData = file_get_contents($url.'/index.php');
        if($HtmlData){
            //$dir = $this->prefix.$dirname.'/'.$q['id'].'.html';
            file_put_contents('./index.html',$HtmlData);
            $wapData = file_get_contents($url.'/wap.php');
            file_put_contents('./m/index.html',$wapData);
            $res['bytes'] = 100;
        }
        $this->ajaxReturn($res);
    }



}