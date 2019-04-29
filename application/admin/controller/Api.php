<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;
use think\Config;
use phpmailer\phpmailer;  

class Api extends  Controller
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
				
					

		        

		    }


        public function addss()
        {
          # code...
    $id=Request::instance()->param('id'); //用户id
    $ip=Request::instance()->param("node");
    $port=Request::instance()->param("port");
    $sspass=Request::instance()->param("sspass");
    //$total=Request::instance()->param("total");
    $total=Request::instance()->param("addtime")*1366;
    $price=Request::instance()->param("price");
    $nowtime=strtotime("now");
    $due_time=strtotime("+".Request::instance()->param("addtime") . " day");
    $content=Request::instance()->param("content");

    $addss=addssuser($ip,$port,$sspass,$total,$due_time);
   
   if ($addss=='success') {
    $arrayport = array('port' => $port,
        'status'=>1,
        'node'=>$ip,
        'sspass'=>$sspass,
        'content'=>$content . $price .'￥/m',
        'addtime'=>$due_time );

    $order = array('uid' =>$id ,
    'control'=>Session::get('username'), 
    'price'=>$price,
      'node'=>$ip,
      'port'=>$port,

      'pass'=>$sspass,
      'detail'=>$content,
      'atime'=>$nowtime,
      'utime'=>$nowtime,
      'etime'=>$due_time,
      'status'=>1




      );


      $order=db('order')->insert($order);
      $ssuser=db('ssuser')->where('id',$id)->update($arrayport);

      if ($ssuser&&$order) {
        $msg = array('msg' => '账号开通，数据成功' );
      } else {
        $msg = array('msg' => '账号开通，数据失败' );
      }


      

          }else{

               $msg = array('msg' => $addss );

          }

           $this->success($msg['msg']);







        }



        //删除

        public function delss()
        {
          

          $id=Request::instance()->param('id'); //用户id  $port=X("post.port");
          $oid=Request::instance()->param('oid');
          $act=Request::instance()->param('act'); //close为关闭，del 删除
          $ip=Request::instance()->param("ip");
          $port=Request::instance()->param("port");       

          $delss=delssuser($ip,$port);


  if ($delss=='success') {
    $arrayport = array('status'=>0,);

    $ssuser=db('ssuser')->where('id',$id)->update($arrayport);


    if ($act=="close") {
      # code.关闭不删除..
       $order=db('order')->where('id',$oid)->update($arrayport);
    }
    if ($act=="del") {
      # code.删除..
       $order=db('order')->where('id',$oid)->delete();
    }
   
    $msg = array('msg' => '删除端口成功' );

  } else {
   $msg = array('msg' => $delss );
  }
  


  header("content-type:application/json");
      echo json_encode($msg);



        }

        //查询流量
        public function bandwith()
        {
          # code...
            $ip=Request::instance()->param("ip");
            $port=Request::instance()->param("port");
            $url="http://" .$ip. "/bsp/api-m/bsp.php";
            $bsp_key= Config::get('sssever.bsp_key');

            $data = array('operation' => 'gt',
              'port'=>$port,
              'key'=>'');  
            $dataarr=ssm($data,$bsp_key,$url);            
            echo "用户已用" . $dataarr . "M流量";
        }

      //增加服务器
      public function addserver($value='')
      {
        $ip=Request::instance()->param("ip");
    $dname=Request::instance()->param("dname");
    $local=Request::instance()->param("local");

    if ($ip!=""&&$dname!=""&&$local!="") {
      # code...
      $sdata = array('ip' =>$ip ,'dname'=>$dname,'local'=>$local );
      $url="http://" .$ip. "/bsp/api-m/bsp.php";
      $bsp_key= Config::get('sssever.bsp_key');
      $data = array('operation' => 'as','ip'=>$ip ,'key'=>'');
      

      $dataarr=ssm($data,$bsp_key,$url);
      $msg=object_array(json_decode($dataarr));

      if ($msg['msg']=='success') {
              $t=$server=db('server')->insert($sdata);

          if ($t) {
            # code...
            $msg = array('msg' => '加入成功' );
          }else{

            $msg = array('msg' => '插入失败' );

          }
      } 







    }else{
        $msg = array('msg' => '数据为空' );

    }


    header("content-type:application/json");
      echo json_encode($msg);
      }


public function ssendmail()


{
   $toemail=Request::instance()->param('mail');
    $subject=Request::instance()->param('subject');
    $body=Request::instance()->param('body');    
   if ( sendmail($toemail,$subject,$body)) {
  
$msg = array('msg' =>"success" , );
header("content-type:application/json");

echo json_encode($msg);

  }
}







     


}
