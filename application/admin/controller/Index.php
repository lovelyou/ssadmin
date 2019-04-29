<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;
use think\Config;

class Index extends  Controller
{


     //前置方法
        protected $beforeActionList = [
        'loginecheck'=> ['except'=>''],


            ];

        protected function loginecheck()
        {
          if (Session::get('username')==""||Session::get('usertype')!="admin") {
          $this->error('还没登录呢','/');
           die();  } 
          
         
          
        }








    public function index()
    {      

            $ssuser=db('ssuser')->order('id desc')->paginate(10);
            $server=db('server')->order('id desc')->select();
            $port=db('ssuser')->order('port desc')->select();

        if ($port) {
            #说明有用户
            $setport=$port[0]['port']+1;


        } else {
            # code...如果没有用户直接9999开始分配
            $setport=8800;
        }
        $this->assign('setport',$setport);
            $this->assign('ssuser',$ssuser);
            $this->assign('server',$server);

            return $this->fetch();          
            	
			

        

    }


    public function otime()
    {
            $order=db('order')->order('etime asc')->paginate(10);
           $this->assign("order",$order);

            return $this->fetch();          
                
    }


    public function user()
    {
    	       $id=Request::instance()->param("id");

        if ($id!="") {
            $ssuser=db('ssuser')->where('id',$id)->select();
            if ($ssuser) {
               $order=db('order')->where('uid',$ssuser[0]['id'])->select();
               $server=db('server')->order('id desc')->select();
               $port=db('order')->where('status',1)->order('port desc')->select();
               //$userport=db('ssuser')->order('port desc')->select();
        if ($port) {
            #说明有用户
            $setport=$port[0]['port']+1;


        } else {
            # code...如果没有用户直接9999开始分配
            $setport=8800;
        }
               $this->assign('server',$server);
               $this->assign("ssuser",$ssuser[0]);
               $this->assign('order',$order);
               $this->assign('setport',$setport);

            return $this->fetch();  
            }else{
            
            echo "所在的ID用户不存在";

            }
            

                
           
            

        } else {
            # code...
            echo "ID为空值";
        }
    }



        public function order()
    {
        $keyword=Request::instance()->param("keyword");

        if ($keyword!="") {
            # code...
            $order=db('order')->whereor('port','like', "%" . $keyword . "%")->whereor('node','like', "%" . $keyword . "%")->paginate(20);
        } else {
          

            $order=db('order')->order('id desc')->paginate(20);

        }

        $this->assign("order",$order);
        return $this->fetch();
        

        
    }




    public function search()
    {
    	$keyword=Request::instance()->param("keyword");

    	if ($keyword!="") {
    		$ssuser=db('ssuser')->whereor('port','like', "%" . $keyword . "%")->whereor('email','like', "%" . $keyword . "%")->whereor('node','like', "%" . $keyword . "%")->order('addtime desc')->select();
            $server=db('server')->order('id desc')->select();



            $port=db('ssuser')->order('port desc')->select();

     	if ($port) {
     		#说明有用户
     		$setport=$port[0]['port']+1;


     	} else {
     		# code...如果没有用户直接9999开始分配
     		$setport=8800;
     	}
     	$this->assign('setport',$setport);
    	$this->assign("ssuser",$ssuser);
        $this->assign('server',$server);
    	//dump($ssuser);
    	}else{



    		//echo "string";
    	}
    	

    

		return $this->fetch();



    }





    public function log()
    {
      # code...

        $log=db('log')->order('id DESC')->paginate(10);

       // $this->assign('list', $log);



        $this->assign('log',$log);
          return $this->fetch();


    }




    public function server($value='')
    {


      
      $server=db('server')->order('id desc')->select();

        $this->assign('server',$server);

       return $this->fetch();




    }
   



}
