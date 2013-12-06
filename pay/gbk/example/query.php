<?php

//��ѯ�ӿ�ʾ��

require_once('../quickpay_service.php');

//* ��������
$transType   = quickpay_conf::CONSUME;
$orderNumber = "20111108150703852";
$orderTime   = "20111108150703";
// */

//��Ҫ����Ĳ���
$param['transType']     = $transType;   //��������
$param['orderNumber']   = $orderNumber; //������
$param['orderTime']     = $orderTime;   //����ʱ��

//�ύ��ѯ
$query  = new quickpay_service($param, quickpay_conf::QUERY);
$ret    = $query->post();

//���ز�ѯ���
$response = new quickpay_service($ret, quickpay_conf::RESPONSE);

//��������
$arr_ret = $response->get_args();
echo "��ѯ���󷵻أ�<pre>\n" .  var_export($arr_ret, true) . "</pre>";

$respCode = $response->get('respCode');
$queryResult = $response->get('queryResult');

if ($queryResult == quickpay_service::QUERY_FAIL) 
{
    echo "����ʧ��[respCode:{$respCode}]!\n";
    //�������ݿ�, ����Ϊ����ʧ��
}
else if ($queryResult == quickpay_service::QUERY_INVALID) {
    //����
    echo "�����ڴ˽���!\n";
}
else if ($respCode == quickpay_service::RESP_SUCCESS
        && $queryResult == quickpay_service::QUERY_SUCCESS)
{
    echo "���׳ɹ�!\n";
    //�������ݿ�, ����Ϊ���׳ɹ�
}
else if ($respCode == quickpay_service::RESP_SUCCESS
        && $queryResult == quickpay_service::QUERY_WAIT)
{
    echo "���״����У��´��ٲ�!\n";
}
else 
{
    //�����쳣����
    $err = sprintf("Error[respCode:%d]", $response->get('respCode'));
    throw new Exception($err);
}


?>
