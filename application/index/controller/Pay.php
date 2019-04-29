<?php
namespace app\index\controller;


use think\Controller;
use think\View;
use think\Request;
use think\Session; 
use alipay\aop\AopClient; 

class Pay extends Controller
{
    public function index()
    { 
    	   if (Session::get('username')!="") {
          


         


            $url="https://openapi.alipay.com/gateway.do";


            $data = array('app_id' => '2016061001500507',


                'method'=>'alipay.trade.query',
                'charset'=>'GBK',
               //'format'=>'',

                'sign_type'=>'RSA1',
                'sign'=>'',
               // 'timestamp'=>,
                'version'=>'1.0'
                //'biz_content'=>,
                //'trade_no'=>



             );



$str = '11223344';
 
echo '待签名的数据是' . $str . '<hr>';
 
//$obj = new RSA();
 
$sign = $obj->rsaSign($str,file_get_contents('./private.txt'));
 
echo '签名后的数据是' . $sign . '<hr>';
 
if($obj->rsaCheck($str,file_get_contents('./public.txt'),$sign)){
    echo '验证成功';
}else{
    echo '验证失败';
}















         return   $this->fetch();


        }else{

                $this->error('未登录录','/login');



        }    
			
			
			 
        }




 





}
