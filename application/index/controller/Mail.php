<?php
namespace app\index\controller;


use think\Controller;
use think\Request;
use think\Session;
//use think\Loader;
use phpmailer\phpmailer;  

class Mail extends Controller
{
    public function index()
    {  


    		$mail=Request::instance()->param('email');
			//$password=Request::instance()->param('password');
			if ($mail!="") {
                # code...
                                   $vcode=mt_rand(100000,999999);
                                    Session::set('vcode',$vcode);

                                    $toemail=$mail;
                                    $subject="您的验证码!". $vcode;
                                    $body="您的验证码:" . $vcode;
                                    sendmail($toemail,$subject,$body);




            }
			
			
			 
        }  





        public function getinfo( )
        {
            # code...

            $orderid=Request::instance()->param('id');

            if (Session::get('username')!="") {
           
                //订单id

                $order=db('order')->where('id',$orderid)->select();

                if ($order) {


                    $node=$order[0]['node'];
                    $port=$order[0]['port'];
                    $pass=$order[0]['pass'];
                    $ep="aes-256-cfb";
                    $uid=$order[0]['uid'];

                    $ssuser=db('ssuser')->where('id',$uid)->select();


                    $toemail=$ssuser[0]['email'];
                    $subject="订单信息";
                    $body='节点：'.$node.'端口：'.$port.'密码：'.$pass.'加密方式：'.$ep;

                    

                    $msg = array('msg' =>sendmail($toemail,$subject,$body) , );

                    
               
                }else{

                      $msg= array('msg' =>'订单不存在啊' , );

                }





             }else{



                $msg= array('msg' =>'你都没登录来搞' , );


             }




               header("content-type:application/json");
            echo json_encode($msg);

        }





}
