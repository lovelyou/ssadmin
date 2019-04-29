<?php
namespace app\index\controller;


use think\Controller;
use think\View;
use think\Request;
use think\Session; 
use think\Config;

class Change extends Controller
{
    public function index()
    { 
    	  


          // echo "string改变";

 $id=Request::instance()->param("id");

 //echo  $id;


 $order=db('order')->where('id',$id)->select();


 if($order){


$showorder=$order[0];

$this->assign('order',$showorder);


 }else{



$this->error('没有订单','/');


 }

 //dump($order);

$server=db('server')->where('show',1)->order('id', 'desc')->select();
//$server=db('server')->select();

$this->assign('server',$server);



return $this->fetch();

            //dump($ssuser);


			
			
			 
        }







        public function changeip()
        {
            

             $orderid=Request::instance()->param('orderid');
            // $oldip=Request::instance()->param('oldip');
             //$port=Request::instance()->param('port');
             $newip=Request::instance()->param('newip');
            //$etime=Request::instance()->param('etime');
             //$pass=Request::instance()->param('pass');
             $user=Session::get('username');

            //通过订单id查找，所属用户ID

             $ssorder=db('order')->where('id',$orderid)->select();

             $uid=$ssorder[0]['uid'];

             $oldip=$ssorder[0]['node'];
             $port=$ssorder[0]['port'];
             $etime=$ssorder[0]['etime'];
             $pass=$ssorder[0]['pass'];










               if ($orderid==""||$oldip==""||$port==""||$newip==""||$etime==""||$pass=="") {
                   $msg = array('msg' =>'参数有误,请选一个IP', 
                    'status'=>'error'

                  );

                   header("content-type:application/json");
                      echo json_encode($msg);

                  exit();
                }







             $total=round((($etime-strtotime("now"))/86400))*1366;



             //通过用户名查找用户id
             $ssuser=db('ssuser')->where('email',$user)->select();

             $userid=$ssuser[0]['id'];

             $oldipprice=db('server')->where('ip',$oldip)->value('price');
             $newipprice=db('server')->where('ip',$newip)->value('price');



             if ($oldipprice<$newipprice) {
                 # code...
                $msg = array('msg' =>'原IP价格太低，请更换价格合理的服务器，微信：nqxnqx','status'=>'error'
 );

                   header("content-type:application/json");
                      echo json_encode($msg);

                  exit();
             }




                if ($user=="") {
                 $msg = array('msg' =>'你没登录', 'status'=>'error'
);

                   header("content-type:application/json");
                      echo json_encode($msg);

                  exit();

                }

               


                if ($uid!=$userid) {
                   $msg = array('msg' =>'无权操作他人账户','status'=>'error'
 );

                   header("content-type:application/json");
                      echo json_encode($msg);

                  exit();
                }


                if ($etime<strtotime("now")) {
                    # code...

                    $msg = array('msg' =>'已过期，微信：nqxnqx','status'=>'error'
 );

                   header("content-type:application/json");
                      echo json_encode($msg);


                      exit();
                }



                if ($ssorder[0]['status']==0||$ssuser[0]['status']==0) {
                    $msg = array('msg' =>'用户或者订单无效,微信：nqxnqx','status'=>'error'
);

                   header("content-type:application/json");
                      echo json_encode($msg);


                      exit();
                }



//删除原有服务器

$del=delssuser($oldip,$port);
//如果新服务器有端口也需要删除

delssuser($newip,$port);


if ($del=='success') {
   //如果删除成功，创建新服务器addss($ip='',$port='2025',$pwd,$total,$due_time='')

    $add=addssuser($newip,$port,$pass,$total,$etime);


    if ($add=='success') {
        # 如果增加成功
        $arrayorder = array('id' =>$orderid , 'node'=>$newip
    );  

        $arrayuser = array('id' =>$uid ,  'node'=>$newip );

        $order=db('order')->update($arrayorder);
        $ssuser=db('ssuser')->update($arrayuser);

        $msg = array('msg' =>'更换成功，IP更换为：'.$newip.'方可正常使用', 'status'=>'success'
);  







    }else{

    #如果增加失败
        $add=addssuser($oldip,$port,$pass,$total,$etime);

        $msg = array('msg' =>'目标服务器故障，请选择其它IP','status'=>'error'
 );

    }

 $logarry = array('type' =>'更换服务器IP' ,


                'content'=>$user.'原IP'.$oldip.'更换'.$newip,
                'time'=> strtotime("now")

             );

            $log=db('log')->insert($logarry);





}else{

//如果删除失败

$msg = array('msg' =>'原服务器删除失败,联系微信nqxnqx 帮您更换','status'=>'error'
 );








}


//增加新服务器






header("content-type:application/json");
echo json_encode($msg);




        }














   






       




 





}
