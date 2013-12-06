<?php

//��̨�ӿ�ʾ��

require_once('../quickpay_service.php');

//�����������ڲ��ԣ������������Ψһ�Ķ�����
mt_srand(quickpay_service::make_seed());

//�������� �˻�=REFUND �� ���ѳ���=CONSUME_VOID, ���ԭʼ������PRE_AUTH����ô��̨�ӿ�Ҳ֧�ֶ�Ӧ��
//  PRE_AUTH_VOID(Ԥ��Ȩ����), PRE_AUTH_COMPLETE(Ԥ��Ȩ���), PRE_AUTH_VOID_COMPLETE(Ԥ��Ȩ��ɳ���)
$param['transType']             = quickpay_conf::REFUND;  

$param['origQid']               = '201110281442120195882'; //ԭ���׷��ص�qid, �����ݿ��л�ȡ

$param['orderAmount']           = 11000;        //���׽��
$param['orderNumber']           = date('YmdHis') . strval(mt_rand(100, 999)); //�����ţ�����Ψһ(������ԭ������ͬ)
$param['orderTime']             = date('YmdHis');   //����ʱ��, YYYYmmhhddHHMMSS
$param['orderCurrency']         = quickpay_conf::CURRENCY_CNY;  //���ױ��֣�

$param['customerIp']            = $_SERVER['REMOTE_ADDR'];  //�û�IP
$param['frontEndUrl']           = "";    //ǰ̨�ص�URL, ��̨���׿�Ϊ��
$param['backEndUrl']            = "http://www.example.com/sdk/utf8/back_notify.php";    //��̨�ص�URL

//�������յĲ������Բ���д

//�ύ
$pay_service = new quickpay_service($param, quickpay_conf::BACK_PAY);
$ret = $pay_service->post();

//ͬ�����أ���ʾ���������յ���̨�ӿ�����, ����ɹ�����Ժ�̨֪ͨΪ׼����ʹ��������ѯ
$response = new quickpay_service($ret, quickpay_conf::RESPONSE);
if ($response->get('respCode') != quickpay_service::RESP_SUCCESS) { //������
    $err = sprintf("Error: %d => %s", $response->get('respCode'), $response->get('respMsg'));
    throw new Exception($err);
}

//��������
$arr_ret = $response->get_args();

echo "��̨���׷��أ�\n" . var_export($arr_ret, true); //���н����ڲ������

?>
