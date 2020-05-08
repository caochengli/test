<?php

namespace Home\Controller;

use Think\Controller;

class ArticleController extends CommonController
{

    private $Art;
    private  $FocusId;
    private $pageArr;
    //private $GrandId;

    public function autoLoad()
    {
        $id = I('get.id');
        $M = M('category');
        $isindex = $M->where('id='.$id)->getField('isindex');
        if($isindex == 1){
            $this->FocusId = $id;
        }else{
            $this->FocusId = $this->Help->getFirstChild($id);
        }
        $this->assign('focusid',$this->FocusId);
        $this->pageArr = $this->Help->getPageLoad($this->FocusId);
        //dump($this->pageArr);
        //$this->GrandId = $this->Help->GetTopId($this->FocusId);
        $this->Art = M('content');
    }

    public function index()
    {
        $this->assign('pageArr',$this->pageArr);
        $this->getArticleList();
        $this->display($this->pageArr['listtemp']);
    }

    public function getArticleList($field=''){
        $queryfields = 'a.id,a.cateid,a.catename,a.title,a.tags,a.savename,a.defaultpic,a.shortcontent,a.addtime,a.links,b.dirname';
        if(!empty($field)){
            $queryfields .= ','.$field;
        }
        global $str;
        $str = '';
        $idarr = $this->Help->GetSonArr($this->FocusId);

        $condition = ' a.cateid in('.$idarr.')';

        $count = $this->Art->alias('a')->where($condition)->count('id');
        $Page = new \Think\Page($count,$this->pageArr['pagesize']);
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $pagination = $Page->show();
        $this->assign('pagination',$pagination);
        //$firstRows = ($page-1)*$pagesize;
        $rs = $this->Art->field($queryfields)->join(' as a LEFT JOIN __CATEGORY__ as b ON a.cateid=b.id')->where($condition)->limit($Page->firstRow,$Page->listRows)->order('a.isgood desc,a.isfocus desc,a.taxis desc,a.id desc')->select();
        $res = [];
        foreach($rs as $i=>$q){
            $res[$i] = $q;
            /*if(empty($q['links'])){
                //$res[$i]['links'] = U('/Show/index',array('id'=>$q['id']));
            }*/
            $res[$i]['links'] = C('SITE_URL').'/'.$q['dirname'].'/'.$q['savename'].'.html';
        }
        //$rs = array_chunk($res,1);
        //dump($rs);
        $this->assign('list',$res);
        return;
    }



    public function getArticleRand($rslen=5,$cateid=6){

        global $str;
        $str = '';
        $idarr = $this->Help->GetSonArr($cateid);
        $rs = $this->Art->field('id,title,date_format(addtime,\'%m-%d\') as posttime')->where('cateid in('.$idarr.')')->limit($rslen)->order('isgood desc,isfocus desc,taxis desc,id desc')->select();
        $res = array(
            'rs' => $rs
        );
        $this->ajaxReturn($res);

    }

}