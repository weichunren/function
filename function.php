<?php


/**
* 和服务端交互,并返回数据
* @param type $url 地址
* @param type $fields 附带参数，可以是数组，也可以是字符串
* @return array
*/
function my_curl($url, $fields){
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 ); 

    if (is_array($fields)) {
        $sets = array();
        foreach ($fields AS $key => $val) {
            $sets[] = $key . '=' . urlencode($val);
        }
        $fields = implode('&', $sets);
    }

    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    
    //设置cookie 根据需求写
    curl_setopt($ch, CURLOPT_COOKIE, 'user='.'username'.';ip='.$_SERVER['REMOTE_ADDR'].';');
    
    $return = curl_exec ( $ch );
    curl_close ( $ch );
    $res = json_decode($return,ture);
    return $res;
}

/**
* 二级制方式提交文件
* @param type $host ip
* @param type $port 端口
* @param type $path 路径
* @param type $imgpath 本地文件路径
* @param type $fields 附带参数，可以是数组，也可以是字符串
* @return array
*/
function img_curl($imgpath, $hots, $port, $path = ''){
    $data = file_get_contents($imgpath);
    $http_entity_body = $data;
    $http_entity_type = 'application/x-www-form-urlencoded';
    $http_entity_length = strlen($http_entity_body);
    $host = '127.0.0.1';
    $port = 88;
    $path = '';
    $fp = fsockopen($host, $port, $error_no, $error_desc, 30);
    if ($fp) {
      fputs($fp, "POST {$path} HTTP/1.1\r\n");
      fputs($fp, "Host: {$host}\r\n");
      fputs($fp, "Content-Type: {$http_entity_type}\r\n");
      fputs($fp, "Content-Length: {$http_entity_length}\r\n");
      fputs($fp, "Connection: close\r\n\r\n");
      fputs($fp, $http_entity_body . "\r\n\r\n");
       
      while (!feof($fp)) {
        $d .= fgets($fp, 4096);
      }
      fclose($fp);
      return $d;
    }  
}

?>