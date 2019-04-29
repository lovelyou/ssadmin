<?php
namespace app\index\controller;


use think\Controller;
use think\View;
use think\Request;
use think\Session; 

class Login extends Controller
{
    public function index()
    { 
    		if (Session::get('username')!="") {
            $this->success('已登录','/index/user');
             }else{

                return $this->fetch('login');

        }          
			
			
			 
        }





        public function check()
          {
              # code...

            $username=Request::instance()->param('username');
            $password=Request::instance()->param('password');

            if ($username==""||$password=="") {
                $msg = array('msg' =>'用户名或者密码为空');
                header("content-type:application/json");
            echo json_encode($msg);
            exit();
            }
            
            $ssuser=db('ssuser')->where('email',$username)->where('password',md5($password))->select();

                                    //dump($ssuser);
            if ($ssuser) {
                                        # code...
            Session::set('username',$username);
            Session::set('usertype',$ssuser[0]['type']);
            
            $msg = array('msg' =>'success');



            } else {

            $msg = array('msg' =>'密码或者用户名有误');
            }


            $logarry = array('type' =>'登录' ,


                'content'=>$username.'用户登录',
                'time'=> strtotime("now")

             );

            $log=db('log')->insert($logarry);






                header("content-type:application/json");
            echo json_encode($msg);





          }  





}
