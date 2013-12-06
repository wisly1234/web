<?php

//ǰ̨֧���ӿ�ʾ��

require_once('../quickpay_service.php');

//�����������ڲ��ԣ������������Ψһ�Ķ�����
mt_srand(quickpay_service::make_seed());

$param['transType']             = quickpay_conf::CONSUME;  //�������ͣ�CONSUME or PRE_AUTH

$param['orderAmount']           = 11000;        //���׽��
$param['orderNumber']           = date('YmdHis') . strval(mt_rand(100, 999)); //�����ţ�����Ψһ
$param['orderTime']             = date('YmdHis');   //����ʱ��, YYYYmmhhddHHMMSS
$param['orderCurrency']         = quickpay_conf::CURRENCY_CNY;  //���ױ��֣�CURRENCY_CNY=>�����

$param['customerIp']            = $_SERVER['REMOTE_ADDR'];  //�û�IP
$param['frontEndUrl']           = "http://www.example.com/sdk/utf8/front_notify.php";    //ǰ̨�ص�URL
$param['backEndUrl']            = "http://www.example.com/sdk/utf8/back_notify.php";    //��̨�ص�URL

/* ������ֶ�
   $param['commodityUrl']          = "http://www.example.com/product?name=��Ʒ";  //��ƷURL
   $param['commodityName']         = '��Ʒ����';   //��Ʒ����
   $param['commodityUnitPrice']    = 11000;        //��Ʒ����
   $param['commodityQuantity']     = 1;            //��Ʒ����
//*/

//�������յĲ������Բ���д

$pay_service = new quickpay_service($param, quickpay_conf::FRONT_PAY);
$html = $pay_service->create_html();

header("Content-Type: text/html; charset=" . quickpay_conf::$pay_params['charset']);
echo $html; //�Զ�post��

?>
