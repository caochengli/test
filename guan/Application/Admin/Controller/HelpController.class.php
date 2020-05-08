<?php
namespace Admin\Controller;
use houdunwang\dir\Dir;
use Think\Controller;
class HelpController extends Controller {

    private $Dir;
    private $Cate;
    private $prefix;

    public function _initialize(){
        $this->Dir = new Dir();
        $this->Cate = M('category');
        $this->prefix = './';
    }

    public function creatDir($dirpath){
        $dirpath = $this->prefix.$dirpath;
        $state = $this->Dir->create($dirpath);
        return $state;
    }

    public function ckToo()
    {
        $dirpath = $this->prefix.'okw/abc/ddd';
        $this->Dir->create($dirpath);
    }

    public function clearCateCache(){
        $rs = $this->Cate->field('dirname')->select();
        $dirarr = array();
        foreach ($rs as $q){
            if(!is_dir($this->prefix.$q['dirname'])){
                $this->Dir->create($this->prefix.$q['dirname']);
            }
            //$dirarr[] = $q['dirname'];
        }
        //$catearr = array_diff(scandir($this->prefix),array('..','.'));
        /*$catearr = $this->scanDirView();
        foreach($catearr as $q){
            if(!in_array($q,$dirarr)){
                //$this->Dir->del($this->prefix.$q);
            }
        }*/
        //reset category html
        $this->ajaxReturn(array('state'=>1));
    }

    public function testView(){
        //header("Content-type: text/html; charset=utf-8");
        $rs = $this->scanDirView();
        dump($rs);
    }

    public function scanDirView($path='',$parent=''){
        //header("Content-type: text/html; charset=utf-8");

        static $dirarrcache;
        if(empty($path)){
            $arr = array_diff(scandir($this->prefix),array('..','.'));
        }else{
            $arr = array_diff(scandir($path),array('..','.'));
        }
        if(count($arr) > 0){
            foreach($arr as $q){
                $pathname = empty($parent) ? $q : $parent.'/'.$q;
                $dirarrcache[] = $pathname;
                $this->scanDirView($this->prefix.$pathname,$pathname);
            }
        }
        //dump($arr);
        return $dirarrcache;
    }

}