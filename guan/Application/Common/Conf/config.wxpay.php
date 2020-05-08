<?php
return array(
    /*'WEIXINPAY_CONFIG' => array(
        'APPID' => 'wx4e757762e07e2e1d', // 微信支付APPID
        'MCHID' => '1427064502', // 微信支付MCHID 商户收款账号
        'KEY' => 'b3ece71fd88759d7c1445d7950b00f42', // 微信支付KEY
        'APPSECRET' => '09a95f7e998c5469796427b41ecc487e',  //公众帐号secert
        'NOTIFY_URL' => 'http://www.mykangjian.com/index.php/Order/wxNotify.html'
    )*/
    'WEIXINPAY_CONFIG' => array(
        'app_id'            => 'wx4e757762e07e2e1d',
        'mch_id'            => '1427064502',
        'md5_key'           => 'b3ece71fd88759d7c1445d7950b00f42',
        'app_cert_pem'      => './Public/pem/apiclient_cert.pem',
        'app_key_pem'       => './Public/pem/apiclient_key.pem',
        'sign_type'         => 'MD5',// MD5  HMAC-SHA256
        'limit_pay'         => [
            //'no_credit',
        ],
        'fee_type'          => 'CNY',// 货币类型  当前仅支持该字段
        'notify_url'        => 'https://helei112g.github.io/',
        'redirect_url'      => 'https://helei112g.github.io/',
        'return_raw'        => false,
    )
);