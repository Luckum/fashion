<?php
/**
* HTTP CURL request utilities
*/

class HttpHelper 
{
    public $cookieFile;
    public $requestQuery;
    public $responseHeaders = array();
    public $responseBody;
    public $boundary;
    public $isCurl = true;
    public $cookie = array();

    const PREVIOUS_GET_PARAMETERS = 'prevGetParams';
    const PREVIOUS_URL = 'prevUrl';
    
    /**
    * Object creator
    * 
    */
    public function __construct() 
    {
        $this->cookieFile = Yii::app()->basePath . '/../public_html/assets/'. substr(md5(time()), 0, 5) . '.txt';
    }
    
    public function __destruct() {
        @unlink($this->cookieFile);
    }
    
    /**
    * Sends HTTP request to specified URL with options (optional)
    * 
    * @param string $url
    * @param array $options - extra CURL options (optional)
    * @param bool $stop - wheither to stop on failure (optional)
    */
    public function send($url, $options = array(), $stop = false) {
        set_time_limit(0);
        if($this->isCurl) {
            return $this->sendCurl($url, $options, $stop);
        }
        else {
            return $this->sendSocket($url, $options, $stop);
        }
    }
    
    public function sendSocket($url, $options, $stop) {
        $url = str_replace(array('http://', 'https://'), '', $url);
        list($host, $uri) = explode('/', $url, 2);
        $uri = '/' . $uri;
        
        if(isset($options[CURLOPT_POST])) {
            $method = 'POST';
            $query = $options[CURLOPT_POSTFIELDS];
        }
        else {
            $method = 'GET';
            $query = '';
        }
        
        $headers = $method  . " " . $uri . " HTTP/1.1\r\n" . 
        "Host: " . $host . "\r\n" . 
        "User-Agent: Opera/9.80 (Windows NT 5.1) Presto/2.12.388 Version/12.16\r\n";
        
        
        /// process custom headers
        if(isset($options[CURLOPT_HTTPHEADER]) && count($options[CURLOPT_HTTPHEADER]) > 0) {
            for($i = 0; $i < count($options[CURLOPT_HTTPHEADER]); $i++) {
                $headers .= $options[CURLOPT_HTTPHEADER][$i] . "\r\n";
            }
        }
        
        /// process custom cookies
        $cookie = '';
        for($i = 0; $i < count($this->cookie); $i++) {
            $cookie .= $this->cookie[$i] . '; ';
        }
        if(isset($options[CURLOPT_COOKIE])) {
            $cookie .= $options[CURLOPT_COOKIE];
        }
        $headers .= "Cookie: " . $cookie . "\r\n";
        $headers .= "\r\n";
        
        $fp = fsockopen($host, 80);
        if(!$fp) {
            if($stop) {
                throw new Exception("Remote connection error (" . curl_error($ch) . ")", curl_errno($ch));
            }
            return false;
        }
        fputs($fp, $headers . $query);
        $content = '';
        while($line = fgets($fp)) {
            $content .= $line;
        }
        list($this->responseHeaders, $this->responseBody) = self::parseResponse($content);
        return $this->responseBody;
    }
    
    /**
    * Sends CURL request to specified URL with options (optional)
    * 
    * @param string $url
    * @param array $options - extra CURL options (optional)
    * @param bool $stop - wheither to stop on failure (optional)
    */
    public function sendCurl($url, $options = array(), $stop = false) 
    {
        set_time_limit(0);
        $ch = curl_init($url);
        $defaults = array(
            CURLOPT_COOKIEFILE => $this->cookieFile,
            CURLOPT_COOKIEJAR => $this->cookieFile,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HEADER => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_FOLLOWLOCATION => true,
        );
        $options = $options + $defaults;
        
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        
        // clear cached values and parse response
        $this->responseBody = '';
        $this->responseHeaders = array();
        if(curl_error($ch) && $stop) {
            throw new Exception("Remote connection error (" . curl_error($ch) . ")", curl_errno($ch));
        }
        curl_close($ch);
        if(isset($options[CURLOPT_HEADER]) && $options[CURLOPT_HEADER]) {
            list($this->responseHeaders, $this->responseBody) = self::parseResponse($response);    
        }
        else $this->responseBody = $response;
        return $this->responseBody;
    }
    
    /**
    * Get content of specified URL
    * 
    * @param string $url
    * @param array $data - list of query params (optional)
    * @param array $options - extra CURL options (optional)
    * @param bool $stop - wheither to stop on failure (optional)
    */
    public function get($url, $data = array(), $options = array(), $stop = false) 
    {
        $this->requestQuery = $this->formatParams($data);
        if(count($data) > 0) {
            $url .= '?' . $this->requestQuery;
        }
        return $this->send($url, $options, $stop);
    }
    
    /**
    * Sends POST request to specified URL
    * 
    * @param mixed $url
    * @param mixed $data - list of POST fields with values (optional)
    * @param bool $multipart - wheither to use multipart/form-data formatting for POST fields
    * @param mixed $options - extra CURL options (optional)
    * @param bool $stop - wheither to stop on failure (optional)
    */
    public function post($url, $data = array(), $multipart = false, $options = array(), $stop = false) {
        $this->requestQuery = $this->formatParams($data, $multipart);
        $extra = array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $this->requestQuery,
        );
        $options = $options + $extra;
        
        return $this->send($url, $options, $stop);
    }
    
    /**
    * formats query params for HTTP CURL requests
    * 
    * @param mixed $params - list of query params
    * @param bool multipart - whether to use multipart/form-data formatting
    */
    public function formatParams($params, $multipart = false) {
        if(count($params) == 0) return '';
        if(!$multipart) {
            $data = array();
            while(list($key, $value) = each($params)) {
                if(!is_array($value)) {
                    $data[] = $key .'='.urlencode($value);
                }
                else {
                    while($val = each($value)) {
                        $data[] = $key . '=' . urlencode($val['value']);
                    }
                }
            }
            return implode('&', $data);    
        }
        else {
            $content = '';
            while(list($key, $value) = each($params)) {
                $content .= 
                $this->boundary . "\r\n" . 
                'Content-Disposition: form-data; name="' . $key . '"' . "\r\n\r\n" . 
                $value . "\r\n";
            }
            $content .= $this->boundary . '--' . "\r\n";
            $result = $content;
            return $result;
        }
    }
    
    public static function parseResponse($response) {
        $lines = explode("\n", $response);
        $headersEnd = false;
        $content = '';
        $headers = array();
        for($i = 1; $i < count($lines); $i++) {
            if(trim($lines[$i]) == '' && !$headersEnd) {
                $headersEnd = true;
                continue;
            }
            if(!$headersEnd) {
                list($key, $value) = explode(': ', $lines[$i]);
                $headers[trim($key)] = trim($value);
            }
            else {
                preg_match('/^HTTP\/1\.(0|1) [0-9]{3} [a-zA-Z]+$/', trim($lines[$i]), $matches);
                if(count($matches) > 0) {
                    $headersEnd = false;
                    continue;
                }
                $content .= $lines[$i] . "\n";
            }
        }
        return array($headers, $content);
    }

    public static function saveGetParameters(){
        $params = Yii::app()->getRequest()->queryString;

        Yii::app()->member->setState(self::PREVIOUS_GET_PARAMETERS, $params);
    }

    public static function retrievePreviousGetParameters(){
        $user = Yii::app()->member;
        $params = $user->getState(self::PREVIOUS_GET_PARAMETERS);

        return $params ? '?' . $params : $params;
    }

    public static function saveUrl(){
        $url = Yii::app()->getRequest()->requestUri;

        Yii::app()->member->setState(self::PREVIOUS_URL, $url);
    }

    public static function retrievePreviousUrl(){
        $user = Yii::app()->member;
        $url = $user->getState(self::PREVIOUS_URL);

        return $url;
    }
}






















