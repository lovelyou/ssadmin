<?php
namespace app\index\controller;


use think\Controller;
use think\View;
use think\Request;
use think\Session; 

class reset  extends Controller
{
    public function index()
    { 
    		       
			return $this->fetch();
			
			 
        }





        public function check()
          {
              


        $email=Request::instance()->param("email");
         $password=Request::instance()->param("password");
         //$sspass=Request::instance()->param("sspass");
         $code=Request::instance()->param("emailcode");
        // $contact=Request::instance()->param("contact");
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




         $ssuser=db('ssuser')->where('email',$email)->select();

         if (!$ssuser) {
            $msg = array('msg' =>'账号不存在');
            echo json_encode($msg);
            exit();
         }




        $userarry = array('email' =>$email ,

        'password'=>md5($password),


         );



        $ssuser=db('ssuser')->where('email',$email)->update($userarry);


        if ($ssuser) {

            $logarry = array('type' =>'重设密码' ,


                'content'=>$email.'重设密码',
                'time'=> strtotime("now")

             );

            $log=db('log')->insert($logarry);

            $msg = array('msg' =>'success');
                    echo json_encode($msg);
        }
          




          }  





}
