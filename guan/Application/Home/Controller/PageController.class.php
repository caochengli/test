<?php

namespace Home\Controller;

use Think\Controller;

class PageController extends CommonController
{
    private  $FocusId;
    private $pageArr;
    //private $GrandId;

    private $User;

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
        $this->User = M('user');
    }

    public function index()
    {
        $this->assign('pageArr',$this->pageArr);
        $this->display($this->pageArr['listtemp']);
    }
}