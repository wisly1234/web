��������֧����UPOP�� ECSHOP֧�����

    2012.08.17

0. �˲����ecshop 2.7.3
0411�汾����ͨ����Ӧ��������2.6.0���ϰ汾�����Ͱ汾��ȷ���������в���������

1. ����ecshop�ı���汾��UTF-8/GBK��ѡ������ӦĿ¼��

2. �����´��밴��Ŀ¼�ṹ������ecshop���·����
    languages/zh_cn/payment/upop.php 
    includes/modules/payment/upop.php 
    includes/modules/payment/upop/quickpay_conf.php 
    includes/modules/payment/upop/quickpay_service.php 

3. �����������->֧����ʽ

4. �ҵ�����������֧������������һ�еġ���װ����Ĭ�����ÿ�ֱ�����ڿ������ԡ�

5. ������������ʹ��Ĭ�ϵ��ʺ�/��Կ���ɣ�����ͨ��������ҵ����Ա��ϵ������PM��������������������ʺš���Կ����֧����ʽ������ҳ��ѡ����Ӧ�Ļ������������ʺź���Կ��

=====

ע��

1. ���������cnvar�汾�޸ġ��Ŵ��Ѹ��µ����°�UPOP SDK���������µ����ù���

2.
��֧����ϻ���ʱ��������֧����ʽ�����ڻ��߲������󣡡���������ecshop��bug���£����޸ĸ�
ecshop Ŀ¼�µ� respond.php ������2.7.3 0411�汾�£���64���޸�Ϊ
    $plugin_file = ROOT_PATH . '/includes/modules/payment/' . $pay_code . '.php';
