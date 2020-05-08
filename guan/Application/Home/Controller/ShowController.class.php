<?php

namespace Home\Controller;

use Think\Controller;

class ShowController extends CommonController
{

    private $Art;
    private $artID;
    private  $FocusId;
    private $pageArr;
    //private $GrandId;

    public function autoLoad()
    {
        $this->Art = M('content');
        $this->artID = I('get.id');
        if(!empty($this->artID)){
            $this->FocusId = $this->Art->where('id='.$this->artID)->getField('cateid');
            $this->assign('focusid',$this->FocusId);
            $this->pageArr = $this->Help->getPageLoad($this->FocusId);
        }
        /*if(!session('?FrontUser')){
            if($this->FocusId == 24){
                $this->redirect('/Article/index',array('id'=>$this->FocusId));
            }
        }*/
        //dump($this->pageArr);
    }

    public function index()
    {

        $rs = $this->Art->where('id='.$this->artID)->find();

        if(!empty($rs['seo_title'])){
            $this->pageArr['seo_title'] = $rs['seo_title'];
        }else{
            if(empty($this->pageArr['seo_title'])){
                $this->pageArr['seo_title'] = $rs['title'].'_'.C('SITE_TITLE');
            }else{
                $this->pageArr['seo_title'] = $rs['title'].'_'.$this->pageArr['seo_title'];
            }
        }

        if(!empty($rs['seo_keyword'])){
            $this->pageArr['seo_keyword'] = $rs['seo_keyword'];
        }

        if(!empty($rs['seo_desc'])){
            $this->pageArr['seo_desc'] = $rs['seo_desc'];
        }

        $this->assign('pageArr',$this->pageArr);

        $Parm = M('product_prm');
        $rs['parm'] = $Parm->where('aid='.$this->artID)->select();

        //组图
        $Picm = M('pic_arr');
        $rs['picarr'] = $Picm->field('pic')->where('sid='.$this->artID)->select();
        $rs['picarr'][] = array(
            'pic' => $rs['defaultpic']
        );

        $rs['navtool'] = $this->getArticleNavTool($rs['id']);

        $this->assign('rsshow',$rs);
        $this->display($this->pageArr['contenttemp']);
    }

    public function getArticleNavTool($id){
        $rsprev = $this->Art->field('id,title,savename')->where('cateid='.$this->FocusId.' and id<'.$id)->order('id desc')->limit(1)->find();
        $rsnext = $this->Art->field('id,title,savename')->where('cateid='.$this->FocusId.' and id>'.$id)->order('id asc')->limit(1)->find();
        $result = array(
            'prev' => array(
                //'links' => U('/Show/index',array('id'=>$rsprev['id'])),
                'links' => empty($rsprev['savename']) ? 'javascript:void(0);' : $rsprev['savename'].'.html',
                'title' => $rsprev['title']
            ),
            'next' => array(
                //'links' => U('/Show/index',array('id'=>$rsnext['id'])),
                'links' => empty($rsnext['savename']) ? 'javascript:void(0);' : $rsnext['savename'].'.html',
                'title' => $rsnext['title']
            )
        );
        return $result;
    }

    public function getProductRand($rslen=4){
        $Model = new \Think\Model();
        $rs = $Model->query("SELECT t1.id,t1.title,t1.defaultpic,t1.links FROM __CONTENT__ AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM __CONTENT__)-(SELECT MIN(id) FROM __CONTENT__))+(SELECT MIN(id) FROM __CONTENT__)) AS id) AS t2 WHERE t1.id >= t2.id and t1.cateid in('2,3,4,5') ORDER BY t1.id LIMIT ".$rslen);
        $res = array(
            'rs' => $rs
        );
        $this->ajaxReturn($res);
    }

    public function setHits($id){
        $this->Art->where('id='.$id)->setInc('hits',1);
    }

}