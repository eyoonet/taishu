<?php

/**
 *数字金额转换成中文大写金额的函数
 *String Int  $num  要转换的小写数字或小写字符串
 *return 大写字母
 *小数位为两位
 **/
function minToMax($num){
    $c1 = "零壹贰叁肆伍陆柒捌玖";
    $c2 = "分角元拾佰仟万拾佰仟亿";
    $num = round($num, 2);
    $num = $num * 100;
    if (strlen($num) > 10) {
        return "数据太长，没有这么大的钱吧，检查下";
    }
    $i = 0;
    $c = "";
    while (1) {
        if ($i == 0) {
            $n = substr($num, strlen($num)-1, 1);
        } else {
            $n = $num % 10;
        }
        $p1 = substr($c1, 3 * $n, 3);
        $p2 = substr($c2, 3 * $i, 3);
        if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
            $c = $p1 . $p2 . $c;
        } else {
            $c = $p1 . $c;
        }
        $i = $i + 1;
        $num = $num / 10;
        $num = (int)$num;
        if ($num == 0) {
            break;
        }
    }
    $j = 0;
    $slen = strlen($c);
    while ($j < $slen) {
        $m = substr($c, $j, 6);
        if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
            $left = substr($c, 0, $j);
            $right = substr($c, $j + 3);
            $c = $left . $right;
            $j = $j-3;
            $slen = $slen-3;
        }
        $j = $j + 3;
    }

    if (substr($c, strlen($c)-3, 3) == '零') {
        $c = substr($c, 0, strlen($c)-3);
    }
    if (empty($c)) {
        return "零元整";
    }else{
        return $c . "整";
    }
}



function formatSidebar($array,$pid=0) {
    $arr = array();
    $tem = array();
    foreach ($array as $v) {
        if ($v['pid'] == $pid) {
            $tem =formatSidebar($array, $v['id']);
            //判断是否存在子数组
            $tem && $v['amin'] = '';
            $tem && $v['sub'] = $tem;
            $arr[] = $v;
        }
    }
    return $arr;
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0){
    $type      = $type ? 1 : 0;
    static $ip = null;
    if (null !== $ip) {
        return $ip[$type];
    }

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos) {
            unset($arr[$pos]);
        }

        $ip = trim($arr[0]);
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}


/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string 
 */
function think_ucenter_md5($str, $key = 'ThinkUCenter'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 (单位:秒)
 * @return string 
 */
function think_ucenter_encrypt($data, $key, $expire = 0) {
    $key  = md5($key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char =  '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x=0;
        $char  .= substr($key, $x, 1);
        $x++;
    }
    $str = sprintf('%010d', $expire ? $expire + time() : 0);
    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data,$i,1)) + (ord(substr($char,$i,1)))%256);
    }
    return str_replace('=', '', base64_encode($str));
}

/**
 * 系统解密方法
 * @param string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param string $key  加密密钥
 * @return string 
 */
function think_ucenter_decrypt($data, $key){
    $key    = md5($key);
    $x      = 0;
    $data   = base64_decode($data);
    $expire = substr($data, 0, 10);
    $data   = substr($data, 10);
    if($expire > 0 && $expire < time()) {
        return '';
    }
    $len  = strlen($data);
    $l    = strlen($key);
    $char = $str = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char  .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else{
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}
