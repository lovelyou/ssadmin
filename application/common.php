<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Config;
use phpmailer\phpmailer; 
// 
// 
// 
function is_mobile_request() 
{ 
$_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : ''; 
$mobile_browser = '0'; 
if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) 
$mobile_browser++; 
if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false)) 
$mobile_browser++; 
if(isset($_SERVER['HTTP_X_WAP_PROFILE'])) 
$mobile_browser++; 
if(isset($_SERVER['HTTP_PROFILE'])) 
$mobile_browser++; 
$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4)); 
$mobile_agents = array( 
'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac', 
'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno', 
'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-', 
'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-', 
'newt','noki','oper','palm','pana','pant','phil','play','port','prox', 
'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar', 
'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-', 
'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp', 
'wapr','webc','winw','winw','xda','xda-' 
); 
if(in_array($mobile_ua, $mobile_agents)) 
$mobile_browser++; 
if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) 
$mobile_browser++; 
// Pre-final check to reset everything if the user is on Windows 
if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) 
$mobile_browser=0; 
// But WP7 is also Windows, with a slightly different characteristic 
if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) 
$mobile_browser++; 
if($mobile_browser>0) 
return true; 
else 
return false; 
}




function object_array($array) {  
    if(is_object($array)) {  
        $array = (array)$array;  
     } if(is_array($array)) {  
         foreach($array as $key=>$value) {  
             $array[$key] = object_array($value);  
             }  
     }  
     return $array;  
}


function objtoarr($obj){
$ret = array();
foreach($obj as $key =>$value){
if(gettype($value) == 'array' || gettype($value) == 'object'){
$ret[$key] = objtoarr($value);
}else{
$ret[$key] = $value;
}
}
return $ret;
}







//用户操作

function ssm($arr,$bsp_key,$url){
$operation=$arr['operation'];
    switch($operation){
      case 'au':
        # code...
      $arr['key']=md5($bsp_key . $arr['port'] . $arr['pwd']. $arr['total'].$arr['due_time']);
        break;


      case 'mu':
        # code...
      $arr['key']=md5($bsp_key . $arr['port'] . $arr['pwd'].$arr['used'] . $arr['total'].$arr['due_time']);
        break;
      case 'as':
        # code...
      $arr['key']=md5($bsp_key  . $arr['ip']);
      //return $arr();
        break;
      case 'lu':
        # code...
      $arr['key']=md5($bsp_key  . $arr['port']);
      //return $arr();
        break;
      case 'du':
        # code...
      $arr['key']=md5($bsp_key  . $arr['port']);
      
        break;
      case 'ls':
        # code...
      $arr['key']=md5($bsp_key);
      
        break;
      case 'ds':
      $arr['key']=md5($bsp_key . $arr['id']);
      
        # code...
        break;
      case 'gt':
        # code...
      $arr['key']=md5($bsp_key . $arr['port']);
      
        break;
      case 'ut':
        # code...
      $arr['key']=md5($bsp_key . $arr['port'] .$arr['t']);
        break;
      }
  return curl($arr,$url);

      //dump($arr);
   
}


//CUL数据据转输
function curl($post_data,$url){   
//echo $post_data['key'];
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);  
  $urls = curl_exec($curl);
  if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
  curl_close($curl);
//echo $urls;

   return $urls ;
}




//发送邮件

function sendmail($toemail,$subject,$body)
{  
    //$toemail=Request::instance()->param('mail');
    //$subject=Request::instance()->param('subject');
    //$body=Request::instance()->param('body');     
    $mail = new phpmailer();                           
    $mail->isSMTP();// 使用SMTP服务  
    $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码  
    $mail->Host = "smtp.exmail.qq.com";// 发送方的SMTP服务器地址  
    $mail->SMTPAuth = true;// 是否使用身份验证  
    $mail->Username = "vip@qloves.com";
            //发送方的163邮箱用户名，就是你申请163的SMTP服务使用的163邮箱</span><span style="color:#333333;">  
    $mail->Password = "mrpDAXnEbQ5uABbf";
            //写的是“客户端授权密码”而不是邮箱的登录密码！</span><span style="color:#333333;">  
    $mail->SMTPSecure = "ssl";
           //</span><span style="color:#ff6666;">// 使用ssl协议方式</span><span style="color:#333333;">  
    $mail->Port = 465;// 163邮箱的ssl协议方式端口号是465/994                            
    $mail->setFrom("vip@qloves.com","神笔 ShenBi.Me");// 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示  
    $mail->addAddress($toemail,'顾客您好');// 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@163.com)  
    $mail->addReplyTo("1684583456@qq.com","Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址 
    $mail->isHTML(true);                     
    $mail->Subject = $subject;// 邮件标题  
    $mail->Body = $body ;// 邮件正文  
          //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用  
                          
       if(!$mail->send()){// 发送邮件  
          //echo "Message could not be sent.";  
           $msg= "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息  
         }else{  
           $msg='发送成功';  
          return $msg;
           } 
      

        }



  function delssuser($ip='',$port='')
        {
         


             $url="http://" .$ip. "/bsp/api-m/bsp.php";
             $bsp_key= Config::get('sssever.bsp_key');
             $data = array('operation' => 'du',
            'port'=>$port,
            'key'=>'');


  

              $dataarr=ssm($data,$bsp_key,$url);
              $msg=object_array(json_decode($dataarr));



              if ($msg['msg']=='success') {
             return  'success';
        }else{


            return $msg['msg'];
        }






        }






 function addssuser($ip='',$port='2025',$pwd,$total,$due_time='')
        {
           



    $url="http://" .$ip. "/bsp/api-m/bsp.php";
    $bsp_key= Config::get('sssever.bsp_key');

    $data = array('operation' => 'au',
      'port'=>$port,
      'pwd'=>$pwd,
      'total'=>$total,
      'due_time'=>$due_time,
      
      'key'=>'');
    //$UserLib = L("User");

     $dataarr=ssm($data,$bsp_key,$url);
     $msg=object_array(json_decode($dataarr));


        if ($msg['msg']=='success') {
             return  'success';
        }else{


            return  $msg['msg'];
        }



          
        }





function rsaSign($data, $private_key) {
 
            $search = [
                    "-----BEGIN RSA PRIVATE KEY-----",
                    "-----END RSA PRIVATE KEY-----",
                    "\n",
                    "\r",
                    "\r\n"
            ];
 
            $private_key=str_replace($search,"",$private_key);
            $private_key=$search[0] . PHP_EOL . wordwrap($private_key, 64, "\n", true) . PHP_EOL . $search[1];
            $res=openssl_get_privatekey($private_key);
 
            if($res)
            {
                    openssl_sign($data, $sign,$res);
                    openssl_free_key($res);
            }else {
                    exit("私钥格式有误");
            }
            $sign = base64_encode($sign);
            return $sign;
    }
 
    /**
     * RSA验签
     * @param $data 待签名数据
     * @param $public_key 公钥字符串
     * @param $sign 要校对的的签名结果
     * return 验证结果
     */
    function rsaCheck($data, $public_key, $sign)  {
            $search = [
                    "-----BEGIN PUBLIC KEY-----",
                    "-----END PUBLIC KEY-----",
                    "\n",
                    "\r",
                    "\r\n"
            ];
            $public_key=str_replace($search,"",$public_key);
            $public_key=$search[0] . PHP_EOL . wordwrap($public_key, 64, "\n", true) . PHP_EOL . $search[1];
            $res=openssl_get_publickey($public_key);
            if($res)
            {
                    $result = (bool)openssl_verify($data, base64_decode($sign), $res);
                    openssl_free_key($res);
            }else{
                    exit("公钥格式有误!");
            }
            return $result;
    }
