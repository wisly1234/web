<?php

/**
 * ECSHOP ��������֧�����ļ�
 ****Ψһһ����ע��ʹ�����������Ͷ��ɹ����������飡****
	������ƣ���������֧��(UPOP)��� FOR ECSHOP
	����汾��1.0
	������ߣ��й�����Ŀ�飨�ɶ�֮��Ƽ����޹�˾��
	������룺GBK
	���ð汾��ECSHOP 2.60������
	���µ�ַ��http://www.cnvar.net/9025511.html
	֧��վ�㣺www.cnvar.net
	������ַ��http://www.cnvar.net/9025511.html
	��������/QQ�˺ţ�cnvar@qq.com
	
	Ŀǰ��֧�����İ汾��Ӣ�ġ�����汾�����е���
	�������뼰ʱ����лл���ɽ�Ⱥ��������Ⱥ�ѽ��а�������
	Ψһ�ٷ�QQ����Ⱥ��87010870
	
 */

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

// ���������ļ�
$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/upop.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

/* ģ��Ļ�����Ϣ */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* ���� */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* ������Ӧ�������� */
    $modules[$i]['desc']    = 'upop_desc';

    /* �Ƿ�֧�ֻ������� */
    $modules[$i]['is_cod']  = '0';

    /* �Ƿ�֧������֧�� */
    $modules[$i]['is_online']  = '1';

    /* ���� */
    $modules[$i]['author']  = '�й�����Ŀ��';

    /* ��ַ */
    $modules[$i]['website'] = 'http://www.cnvar.net';

    /* �汾�� */
    $modules[$i]['version'] = '1.0.0';

    /* ������Ϣ */
    $modules[$i]['config'] = array(
		array('name' => 'upop_merAbbr', 'type' => 'text', 'value' => '�̻�����'),
		array('name' => 'upop_evn', 'type' => 'select', 'value' => '0'),
		array('name' => 'upop_account_test', 'type' => 'text', 'value' => '105550149170027'),
		array('name' => 'upop_security_key_test', 'type' => 'text', 'value' => '88888888'),
        array('name' => 'upop_account_pm', 'type' => 'text', 'value' => ''),
		array('name' => 'upop_security_key_pm', 'type' => 'text', 'value' => ''),
        array('name' => 'upop_account', 'type' => 'text', 'value' => ''),
		array('name' => 'upop_security_key', 'type' => 'text', 'value' => ''),
    );

    return;
}

/**
 * ��
 */
class UPOP
{
    /**
     * ����֧������
     * @param   array   $order  ������Ϣ
     * @param   array   $payment    ֧����ʽ��Ϣ
     */

    static $api_url = array(
        0  => array(
            'front_pay_url' => 'http://58.246.226.99/UpopWeb/api/Pay.action',
            'back_pay_url'  => 'http://58.246.226.99/UpopWeb/api/BSPay.action',
            'query_url'     => 'http://58.246.226.99/UpopWeb/api/Query.action',
        ),
        1  => array(
            'front_pay_url' => 'http://www.epay.lxdns.com/UpopWeb/api/Pay.action',
            'back_pay_url'  => 'http://www.epay.lxdns.com/UpopWeb/api/BSPay.action',
            'query_url'     => 'http://www.epay.lxdns.com/UpopWeb/api/Query.action',
        ),
        2  => array(
            'front_pay_url' => 'https://unionpaysecure.com/api/Pay.action',
            'back_pay_url'  => 'https://besvr.unionpaysecure.com/api/BSPay.action',
            'query_url'     => 'https://query.unionpaysecure.com/api/Query.action',
        ),
    );

    function get_code($order, $payment)
    {
		// ��ʼ������
		$upop_evn		= $payment['upop_evn'];		// ����
		$lib_path		= ROOT_PATH . 'includes/modules/payment/upop/';
		
		// ������ӿ��ļ�
		include_once($lib_path . 'quickpay_service.php');

		if (!class_exists('quickpay_conf') || !class_exists('quickpay_service'))
			return 'ȱ��֧����ʽ�ļ���';

		
		// �̻�����
		quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

		if ($upop_evn == '2') // ��������
		{
			quickpay_conf::$security_key			= $payment['upop_security_key'];
			quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
		}
		else if ($upop_evn == '1') // PM����
		{
			quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
			quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
		}
		else if ($upop_evn == '0') // ������������
		{
			quickpay_conf::$security_key			= $payment['upop_security_key_test'];
			quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
		}

		mt_srand(quickpay_service::make_seed());

		$param = array();

		$param['transType']             = quickpay_conf::CONSUME;  // �������ͣ�CONSUME or PRE_AUTH
		$param['orderAmount']           = $order['order_amount'] * 100;  // ���׽�� ת��Ϊ��
		$param['orderNumber']           = $order['order_sn'] . '-' . $this->_formatSN($order['log_id']);		   // �����ţ�����Ψһ
		$param['orderTime']             = date('YmdHis');		   // ����ʱ��, YYYYmmhhddHHMMSS
		$param['orderCurrency']         = quickpay_conf::CURRENCY_CNY;  //���ױ��֣�CURRENCY_CNY=>�����

		$param['customerIp']            = $_SERVER['REMOTE_ADDR'];  // �û�IP
		$param['frontEndUrl']           = return_url(basename(__FILE__, '.php'));   // ǰ̨�ص�URL
		$param['backEndUrl']            = return_url(basename(__FILE__, '.php'));    // ��̨�ص�URL

		/* ������ֶ�
		   $param['commodityUrl']          = "http://www.example.com/product?name=��Ʒ";  //��ƷURL
		   $param['commodityName']         = '��Ʒ����';   //��Ʒ����
		   $param['commodityUnitPrice']    = 11000;        //��Ʒ����
		   $param['commodityQuantity']     = 1;            //��Ʒ����
		*/
		

		$button = "<input type='submit' value='" . $GLOBALS['_LANG']['upop_button'] . "' />";
		$pay_service = new quickpay_service($param, quickpay_conf::FRONT_PAY);
		$html = $pay_service->create_html($button);

        return $html;
    }

    /**
     * ��Ӧ����
     */
    function respond()
    {
        $payment        = get_payment('upop');

		// ��ʼ������
		$upop_evn		= $payment['upop_evn'];		// ����
		$lib_path		= ROOT_PATH . 'includes/modules/payment/upop/';

		// ������ӿ��ļ�
		include_once($lib_path . 'quickpay_service.php');

		if (!class_exists('quickpay_conf') || !class_exists('quickpay_service'))
			return false;

		// �̻�����
		quickpay_conf::$pay_params['merAbbr']		= $payment['upop_merAbbr'];

        foreach (UPOP::$api_url[$upop_evn] as $key => $value)
        {
            quickpay_conf::$$key = $value;
        }

		if ($upop_evn == '2') // ��������
		{
			quickpay_conf::$security_key			= $payment['upop_security_key'];
			quickpay_conf::$pay_params['merId']		= $payment['upop_account'];
		}
		else if ($upop_evn == '1') // PM����
		{
			quickpay_conf::$security_key			= $payment['upop_security_key_pm'];
			quickpay_conf::$pay_params['merId']		= $payment['upop_account_pm'];
		}
		else if ($upop_evn == '0') // ������������
		{
			quickpay_conf::$security_key			= $payment['upop_security_key_test'];
			quickpay_conf::$pay_params['merId']		= $payment['upop_account_test'];
		}

		try {
			$response = new quickpay_service($_POST, quickpay_conf::RESPONSE);
			if ($response->get('respCode') != quickpay_service::RESP_SUCCESS) 
			{
				$err = sprintf("Error: %d => %s", $response->get('respCode'), $response->get('respMsg'));
				throw new Exception($err);
			}

			$arr_ret = $response->get_args();
			
			if(!strpos($arr_ret['orderNumber'], '-')) return false;
			$order_sn_arr = explode('-', $arr_ret['orderNumber']);
			
			$order_sn		= $order_sn_arr[0];
			$pay_id = (int)$order_sn_arr[1];
			$payment_amount = (int)$arr_ret['settleAmount'];

			// ����̻��˺��Ƿ�һ�¡�
			if (quickpay_conf::$pay_params['merId'] != $arr_ret['merId'])
			{
				return false;
			}

			// ���۸��Ƿ�һ�¡�
			$sql = "SELECT p.order_amount FROM " . $GLOBALS['ecs']->table('pay_log') . " AS p LEFT JOIN " . $GLOBALS['ecs']->table('order_info') . " AS o ON p.order_id = o.order_id WHERE o.order_sn = '"
			. $order_sn . "'";
			$order_amount = $GLOBALS['db']->getOne($sql) * 100;

			if ($order_amount != $payment_amount)
			{
				return false;
			}

			// ���δ֧���ɹ���
			if ($arr_ret['respCode'] != '00')
			{
				return false;
			}

			$action_note = $arr_ret['respCode'] . ':' 
					. $arr_ret['respMsg'] 
					. $GLOBALS['_LANG']['upop_txn_id'] . ':' 
					. $arr_ret['qid'];

			// ��ɶ�����
			order_paid($pay_id, PS_PAYED, $action_note);

			//�����û��������
			return true;
        
		}
		catch(Exception $exp) 
		{
			return false;
		}
    }


	/**
	* ��ʽ������
	*/
	function _formatSN($sn)
	{
		return str_repeat('0', 9 - strlen($sn)) . $sn;
	}
}
?>