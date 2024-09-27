<?php
/**
* Class CSRF
* Permet de sécuriser les formulaire avec un token
*/
class CSRF
{
    
    /**
    * @param $length int Longueur de la chaine a generer
    * @return string
    */
    static function GenString($length = 100) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
    * @param $length int Longueur de la chaine a generer
    * @return string
    */
    static function GenStringWithoutNumber($length = 100) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    static function AsciiEncode($str)
    {
        $dec_array = [];
        for ($i = 0, $j = strlen($str); $i < $j; $i++) {
        $dec_array[] = ord($str[$i]);
        }
        $dec_str = "";
        foreach ($dec_array as $val) {
            $dec_str .= "\\".$val;
        }
        return $dec_str;
    }

    /**
    * @param $time int timestamp
    * @return string
    */
    static function TimeAgo($time) {
        $etime = time() - $time;

        if ($etime < 60)
        {
            return 'Now';
        }

        $a = array( 365 * 24 * 60 * 60  =>  'year',
                     30 * 24 * 60 * 60  =>  'month',
                          24 * 60 * 60  =>  'day',
                               60 * 60  =>  'hour',
                                    60  =>  'minute',
                                     1  =>  'second'
                    );
        $a_plural = array( 'year'   => 'years',
                           'month'  => 'months',
                           'day'    => 'days',
                           'hour'   => 'hours',
                           'minute' => 'minutes',
                           'second' => 'seconds'
                    );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return 'About ' .$r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }

    }

    /**
    * @return string
    */
    public static function CreateToken()
    {
        $current_url = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
        $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $expire_to = 15 * 60; // Expires in 1 minutes
        $time_expire = time() + $expire_to;
        $token = CSRF::GenString();
       
        $GLOBALS['DB']->Insert('csrf', ['token' => $token, 'ip' => $ip, 'url' => $current_url, 'expire_time' => $time_expire]);
        return $token;
    }
    
    /**
    * @param $csrf_token string Token à vérifier
    * @return boolean
    */
    static function VerifyToken($csrf_token)
    {
        $referer_url = $_SERVER['HTTP_REFERER'];
        $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $current_time = time();
        
        if ($GLOBALS['DB']->Count('csrf', ['token' => $csrf_token]) == 1)
        {
            $token_info = $GLOBALS['DB']->GetContent('csrf', ['token' => $csrf_token])[0];
            if ($token_info['ip'] == $ip && $current_time < $token_info['expire_time'] && $token_info['url'] == $referer_url)
            {
                $GLOBALS['DB']->Delete('csrf', ['id' => $token_info['id']]);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    
    /**
    * @return boolean
    */
    static function isAjaxRequest()
    {
        return (boolean)((isset($_SERVER['HTTP_X_REQUESTED_WITH'])) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }

    /**
     * @return string
     */
    public static function BadRequestJson()
    {
        http_response_code(400);
        return json_encode(['success' => false, 'message' => "400 Bad Request"]);
    }

    /**
     * GetVisitorIP function returns the visitor's IP address
     * @return string
     */
    public static function GetVisitorIP(): string
    {
        return isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR'];
    }
}
?>