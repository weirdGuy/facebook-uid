<?php


    class FUID {
        
        
        public $loged = false;
        
        public $username = '';
        public $password = '';
        
        function __construct($username, $password){
            
            if(!file_exists("cookie.txt")){
                echo 123;
                $ccreate = fopen("cookie.txt", "w");
                fclose($ccreate);
            }
            $this->username = $username;
            $this->password = $password;
            
            
            $this->login($this->username, $this->password);
            
        }
        
        
        function getUID($link){
            
            if(!$this->loged){
                $this->login($this->username, $this->password);
            }
            $ch = curl_init();
            $link = 'https://m.facebook.com/'.$link;
            curl_setopt ($ch, CURLOPT_URL, $link); 
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
            curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
            curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
            curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0); 
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt ($ch, CURLOPT_COOKIEJAR, realpath("cookie.txt"));
            curl_setopt ($ch, CURLOPT_COOKIEFILE, realpath("cookie.txt"));
            curl_setopt ($ch, CURLOPT_REFERER, $link); 
             
            $result = curl_exec($ch);
            curl_close($ch);
            $matches = array();
            $link = preg_match_all('/subjectid=(.*?)&/s', $result, $matches);
            if(isset($matches[1][0])){
                 return $matches[1][0];
            }
            return 'error';
        }
        
        
        
        function login($username, $password){
            $url = "https://m.facebook.com/login.php?page=login";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS,'email='.urlencode($username).'&pass='.urlencode($password).'&login=Login');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_COOKIEJAR, realpath("cookie.txt"));
            curl_setopt($ch, CURLOPT_COOKIEFILE, realpath("cookie.txt"));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
            curl_setopt($ch, CURLOPT_REFERER, "https://m.facebook.com/login.php");
            $page = curl_exec($ch) or die(curl_error($ch));
            curl_close($ch);
            
            
            preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $page, $matches);
            $this->cookies = array();
            foreach($matches[1] as $item) {
                parse_str($item, $cook);
                $this->cookies = array_merge($this->cookies, $cook);
            }
            if(isset($this->cookies['datr'])){
                $this->loged = true;
            }
        }
        
        
    }


?>