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

?>