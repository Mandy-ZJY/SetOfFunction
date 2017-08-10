<?php 
  
  class UrlGenerateProvider{

  	     public function  __construct($name){

               $this->UrlParams= array(

               	"Action"=>"DescribeDomainWhoisInfo",
               	"DomainName"=>$name,
               	"Version"=>"2015-01-09",
               	"AccessKeyId"=>"testKeyId",
               	"Format"=>"JSON",
               	"SignatureMethod"=>"HMAC-SHA1",
               	"Timestamp"=>gmdate('Y-m-d\\TG:i:s\\Z', time()),
               	"SignatureVersion"=>"1.0",
               	"SignatureNonce"=>uniqid()

               	);

               $this->Signature=$this->GetSignature();
  	      }

           private $AccessKeySecret="testKeySecret";

           private $Signature;

           private $UrlParams;

           public function GetUrl(){    

           	   $pro="http://alidns.aliyuncs.com/?";

           	   $pro.=substr($this->GetCanonicalizedQueryStr(), 1)."&".$this->MyUrlEncode("Signature")."=".$this->MyUrlEncode($this->Signature);

           	   return $pro;
           }


          /* 使用请求字符串构造签名*/
           function GetSignature(){

           	      $CanonicalizedQuery=substr($this->GetCanonicalizedQueryStr(), 1);
           	      
                  $StrToSign="GET"."&".$this->MyUrlEncode("/")."&".$this->MyUrlEncode($CanonicalizedQuery);
                  
                  $hmacStr= hash_hmac("sha1", $StrToSign, $this->AccessKeySecret."&",true);

                  return base64_encode($hmacStr);
           }


            /* 构造规范化的请求字符串*/
           function GetCanonicalizedQueryStr(){
              
              ksort($this->UrlParams);

              $resultStr="";

              foreach ($this->UrlParams as $key => $value) {

              	$resultStr.="&";
              	$resultStr.=$this->MyUrlEncode($key)."=".$this->MyUrlEncode($value);
              
              }
 
              return $resultStr;
           }


          /*  URL编码 utf-8*/
          function MyUrlEncode($val){

            if($val==null)	
              return null;

            else{
             $val1=UrlEncode(utf8_encode($val));

             $val1=str_replace("+", "%20",$val1);

             $val1=str_replace("*", "%2A",$val1);

             $val1=str_replace("%7E", "~",$val1);

             return  $val1;
           }

         }      

  }

?>