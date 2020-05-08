<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';
require_once 'log.php';
//初始化日志

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		//Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		//Log::DEBUG("call back:" . json_encode($data));
		//Log::DEBUG("call back:" . json_encode($data));
		
		$notfiyOutput = array();
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		
		
		if($data['result_code'] == "SUCCESS"){
			//更新订单状态
			$Ord = M('order');
			$Gds = M('goods');
			$OG = M('order_goods');
			$User = M('user');
			$Score = M('score');
			$order_num = $data['out_trade_no'];
			$price = sprintf("%01.2f", $data['total_fee']/100);
			$openid = $data['openid'];
			
			$uid = $User -> where("openid='".$openid."'") -> getField('id');
			
			$isord = $Ord -> lock(true) -> field('id,state') -> where("order_num='".$order_num."'") -> find();
			if($isord && $isord['state']==0){
			   //更新库存、销量
			   $rs = $OG -> field('goods_id') -> where('order_id='.$isord['id']) -> find();
			   $Gds -> lock(true) -> where('id='.$rs['goods_id']) -> setDec('stock');
			   $Gds -> lock(true) -> where('id='.$rs['goods_id']) -> setInc('sellnum');
			   //积分
			   $sn = $Gds -> where('id='.$rs['goods_id']) -> getField('score');
			   if($sn > 0){
			      $upsdata = array(
				     'uid' => $uid,
					 'type' => 1,
					 'numb' => $sn,
					 'addtime' => date('Y-m-d H:i:s'),
					 'oid' => $isord['id']
				  );
				  $Score -> add($upsdata);
				  $User -> where('id='.$uid) -> setInc('score',$sn);
				  $ss = session('wxuser.score');
				  session('wxuser.score',($ss+$sn));
			   }
			   $upord = array(
			      'trade_no' => $data['transaction_id'],
				  'state' => 1,
				  'lasttime' => date('Y-m-d H:i:s')
			   );
			   $isok = $Ord -> lock(true) -> where("order_num='".$order_num."'") -> save($upord);
			   //微信通知
			   $Weixin = A('Index');
			   $Weixin -> tmpmsg($order_num,$price,$openid);
			}else{
			   return true;
			}
		}
		//更新支付信息到订单支付表
		$paydata = array(
		   'order_num' => $data['out_trade_no'],
		   'result_code' => $data['result_code'],
		   'err_code' => $data['err_code'],
		   'err_code_des' => $data['err_code_des'],
		   'bank_type' => $data['bank_type'],
		   'total_fee' => $data['total_fee'],
		   'transaction_id' => $data['transaction_id'],
		   'time_end' => $data['time_end']
		);
		$Ordpay = M('order_pay');
		$Ordpay -> add($paydata);
		
		return true;
	}
}

