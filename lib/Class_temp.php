<?php
/*
 * Generator Email Class Code by sandroputraa
 * https://github.com/sandrocods
 * Created At 31-10-2020
 * Updated at 01-11-2020
 */
class GenEmail
{
    const API = 'https://generator.email/';
    private static function headers($name = null, $domain = null){
        $headers_tempm = array();
        $headers_tempm[] = 'Host: generator.email';
        $headers_tempm[] = 'Connection: keep-alive';
        $headers_tempm[] = 'Upgrade-Insecure-Requests: 1';
        $headers_tempm[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36';
        $headers_tempm[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
        $headers_tempm[] = 'Sec-Fetch-Site: none';
        $headers_tempm[] = 'Sec-Fetch-Mode: navigate';
        $headers_tempm[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
        $headers_tempm[] = 'Cookie: _ga=GA1.2.727824364.1578704779; _gid=GA1.2.139870167.1578704779; embx=%5B%22'.$name.'%40'.$domain.'%22%5D; surl='.$domain.'%2F%3F'.$name.'';
        return $headers_tempm;
    }
    public static function getStr($string, $start, $end){
        $str = explode($start, $string);
        $str = explode($end, ($str[1]));
        return $str[0];
    }
    public static function curl($url, $method = null, $postfields = null, $followlocation = null, $headers = null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        if ($followlocation !== null) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }
        if ($method == "GET") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        }
        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        }
        if ($headers !== null) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $result = curl_exec($ch);
        $header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
        $cookies = array();
        foreach ($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        return array(
            $httpcode,
            $header,
            $body,
            $cookies,
            array(
                "url" => $url,
                "header_post" => $headers,
                "post" => $postfields
            ),
        );
    }
    public static function GetEmail($name = null){

        $get_email = GenEmail::curl(self::API, 'GET', null, '1', null);
        preg_match('/var gasmurl="\/(.*?)\/(.*?)";/', $get_email[2], $value);
        if (empty($value[2])) {
            return array(
                "status" => "Error Processing Request"
            );
        } else {
            if(empty($name)){
               $name = $value[2]; 
            }
            return array(
                "email" => $name.'@'.$value[1],
                "name" => $name,
                "domain" => $value[1],
            );
        }
    }
    public static function ReadSingleMessage($name = null, $domain = null){
        $read_email = GenEmail::curl(self::API, 'GET', null, '1', GenEmail::headers($name ,$domain));
        return $read_email;
        if (preg_match('/<div class="e7m from_div_45g45gg">(.*?)<\/div>/', $read_email[2], $sender)) {
            return array(
                "Sender" => $sender[1],
                "Time" => GenEmail::getStr($read_email[2], '<div class="e7m time_div_45g45gg">', '</div>'),
                "Subject" => GenEmail::getStr($read_email[2], '<div class="e7m subj_div_45g45gg">', '</div>'),
                "Message" => GenEmail::getStr($read_email[2], '<div class="e7m mess_bodiyy">', '<div class="e7m border-right">')
            );
            return $read_email;
        } else {
            return array(
                "status" => "Email Box Empty / Error Processing Request"
            );
        }
    }
    public static function ReadSecret($name = null, $domain = null){
        $ReadMultiMessage = GenEmail::curl(self::API, 'GET', null, '1', GenEmail::headers($name ,$domain));
        if (preg_match('/<div class="e7m from_div_45g45gg">(.*?)<\/div>/', $ReadMultiMessage[2], $sender)) {
            preg_match('/<span id="mess_number">(.*?)<\/span>/', $ReadMultiMessage[2], $output_counter);
            preg_match_all('/<a href="\/'.$domain.'\/'.$name.'\/(.*?)"/',$ReadMultiMessage[2],$output_secret);
            return array(
                "Total Message" => $output_counter[1],
                "Secret" => $output_secret[1]
            );
        } else {
            return array(
                "status" => "Email Box Empty / Error Processing Request"
            );
        }
    }

    public static function ReadMessagebySecret($name = null, $domain = null, $secret = null){   
        $headers_tempm = array();
        $headers_tempm = GenEmail::headers($name ,$domain);
        $pop = array_pop($headers_tempm);
        $headers_tempm[] = 'Cookie: _ga=GA1.2.727824364.1578704779; _gid=GA1.2.139870167.1578704779; embx=%5B%22'.$name.'%40'.$domain.'%22%5D; surl='.$domain.'%2F%3F'.$name.'%2F'.$secret;
        $read_email = GenEmail::curl(self::API, 'GET', null, '1', $headers_tempm);
        if (preg_match('/<div class="e7m from_div_45g45gg">(.*?)<\/div>/', $read_email[2], $sender)) {
            return array(
                "Sender" => $sender[1],
                "Time" => GenEmail::getStr($read_email[2], '<div class="e7m time_div_45g45gg">', '</div>'),
                "Subject" => GenEmail::getStr($read_email[2], '<div class="e7m subj_div_45g45gg">', '</div>'),
                "Message" => GenEmail::getStr($read_email[2], '<div class="e7m mess_bodiyy">', '<div class="e7m border-right">')
            );
        } else {
            return array(
                "status" => "Email Box Empty / Error Processing Request"
            );
        }
    }

    public static function MarkAllRead($name = null, $domain = null){
        $read_email = GenEmail::curl(self::API, 'GET', null, '1', GenEmail::headers($name ,$domain));
        $Get_dell = GenEmail::getStr($read_email[2],'{ delll: "','" }');
        $MarkAllRead = GenEmail::curl(self::API.'del_mail.php', 'POST', 'markall='.$Get_dell.'', null, GenEmail::headers($name ,$domain));
        return array(
            'Status' => $MarkAllRead[2] 
        );

    }

    public static function DeleteAll($name = null, $domain = null)
    {
        $read_email = GenEmail::curl(self::API, 'GET', null, '1', GenEmail::headers($name ,$domain));
        $Get_dell = GenEmail::getStr($read_email[2],'{ delll: "','" }');
        $DeleteAll = GenEmail::curl(self::API.'del_mail.php', 'POST', 'dellall='.$Get_dell.'', null, GenEmail::headers($name ,$domain));
        return array(
            'Status' => $DeleteAll[2] 
        );
    }

    public static function ReadAllMessage($name = null, $domain = null){
        $Get_secret = GenEmail::ReadSecret($name , $domain);
        foreach ($Get_secret['Secret'] as $secret) {
            $Get_message = GenEmail::ReadMessagebySecret($name , $domain, $secret);
            $array[] = $Get_message;
        }
        return $array;
    }   

    public static function CheckStatus($name = null, $domain = null){
        $Get_status = GenEmail::curl(self::API.'check_adres_validation3.php','POST','usr='.$name.'&dmn='.$domain.'',null,GenEmail::headers($name ,$domain));
        return array(
            "Email" => $name."@".$domain,
            "Result" => $Get_status[2]
        );
    }
}
