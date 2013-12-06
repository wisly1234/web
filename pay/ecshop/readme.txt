银联在线支付（UPOP） ECSHOP支付插件

    2012.08.17

0. 此插件在ecshop 2.7.3
0411版本测试通过，应当适用于2.6.0以上版本，更低版本不确定，请自行测试修正。

1. 根据ecshop的编码版本（UTF-8/GBK）选择插件对应目录。

2. 将以下代码按其目录结构拷贝至ecshop相关路径下
    languages/zh_cn/payment/upop.php 
    includes/modules/payment/upop.php 
    includes/modules/payment/upop/quickpay_conf.php 
    includes/modules/payment/upop/quickpay_service.php 

3. 进入管理中心->支付方式

4. 找到“银联在线支付”，点击最后一列的“安装”，默认配置可直接用于开发测试。

5. 开发联调环境使用默认的帐号/密钥即可，测试通过后再与业务人员联系，分配PM环境、生产环境的相关帐号、密钥，在支付方式的配置页面选择相应的环境，并填入帐号和密钥。

=====

注：

1. 本插件基于cnvar版本修改、排错，已更新到最新版UPOP SDK，并增加新的配置功能

2.
若支付完毕回跳时遇到“此支付方式不存在或者参数错误！”，可能是ecshop的bug导致，可修改该
ecshop 目录下的 respond.php ，（在2.7.3 0411版本下）第64行修改为
    $plugin_file = ROOT_PATH . '/includes/modules/payment/' . $pay_code . '.php';
