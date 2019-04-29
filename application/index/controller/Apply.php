<?php
namespace app\index\controller;

use think\Controller;
use think\View;
use think\Request;
use think\Session;

class Apply extends  Controller
{
    public function index()
    {

        

    return    $this->fetch();





    }


    public function check()
    {
    	# code...


    	 $email=Request::instance()->param("email");
		 $password=Request::instance()->param("password");
		 //$sspass=Request::instance()->param("sspass");
		 $code=Request::instance()->param("emailcode");
		 $contact=Request::instance()->param("contact");
		 $vcode=  Session::get("vcode");


		 if ($email==""||$password=="") {

		 	$msg = array('msg' =>'邮件和密码不能为空');
			echo json_encode($msg);
			exit();


		 	# code...
		 }




		 if ($code=="") {
		 	# code...
			$msg = array('msg' =>'验证码不能为空');
			echo json_encode($msg);
			exit();

		 }



		 if ($code!=""&&$code!=$vcode) {


		 	$msg = array('msg' =>'验证码填写错误');
			echo json_encode($msg);
			exit();
		 	
		 }


		 if ($code==$vcode) {
		 	# code...

		 $ssuser=db('ssuser')->where('email',$email)->select();
		 if ($ssuser) {
		 	
		 	$msg = array('msg' =>'邮箱已注册，请登录');

		 }else{	 	

		 	$data = array('email' =>$email,
		 		'password'=>md5($password),
		 		//'sspass'=>$sspass,
		 		'type'=>'user',
		 		'contact'=>$contact,
		 		'regtime'=>strtotime("now")
		 		//'addtime'=>strtotime($addtime)
		 	 );

		 	$ssuser=db('ssuser')->insert($data);
		 	if ($ssuser) {

		 		//var_dump($re);
		 		$msg = array('msg' =>'success');

		 	}
		 }





		 echo json_encode($msg);
			//exit();

		 }














    }




}
