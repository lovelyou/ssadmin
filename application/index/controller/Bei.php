<?php
namespace app\index\controller;


use think\Controller;
use think\View;
use think\Request;
use think\Session; 

class Bei extends Controller
{
    public function index()
    { 
    	   if (Session::get('username')!="") {
            

            $ssuser=db('ssuser')->where('email',Session::get('username'))->where('status',1)->select();

            if (!$ssuser) {
                # code...

                echo "无权限";
            }
            else{

                $this->assign('addtime',$ssuser[0]['addtime']);



                             if ($ssuser[0]['addtime']<strtotime('now')) {
                 # code...
                echo "账号过期";
             }else{


                $bei=db('ssuser')->where('email','1684583456@qq.com')->select();
                $order=db('order')->where('uid', $bei[0]['id'])->select();  
                $this->assign('order',$order);
             }
           // $order=db('order')->where('uid',$ssuser[0]['id'])->select();
           
            //$this->assign('ssuser',$ssuser[0]);
            return $this->fetch();


            }

            



            //dump($ssuser);


        }else{

                $this->error('未登录录','/login');



        }    
			
			
			 
        }




 





}
