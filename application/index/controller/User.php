<?php
namespace app\index\controller;


use think\Controller;
use think\View;
use think\Request;
use think\Session; 

class User extends Controller
{
    public function index()
    { 
    	   if (Session::get('username')!="") {
            
           $server=db('server')->where('show',1)->order('id', 'desc')->select();

           //$server=db('server')->select();

            $this->assign('server',$server);
            $ssuser=db('ssuser')->where('email',Session::get('username'))->select();
            $order=db('order')->where('uid',$ssuser[0]['id'])->select();
            $this->assign('order',$order);
            $this->assign('ssuser',$ssuser[0]);
            return $this->fetch();
            //dump($ssuser);


        }else{

                $this->error('未登录录','/login');



        }    
			
			
			 
        }




 





}
