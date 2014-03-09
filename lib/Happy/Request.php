<?php
/*
 * Happy CMS 2
 *
 * Authors: Isa Ugurchiev, Magamed Esmurziev http://happycms.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Happy;

class Request
{
    /**
     * @var $controllers
     */
    private $controllers = array();
    
    /**
     * @var $controller
     */
    private $controller = array();
    
    /**
     * @var $parameters
     */
    private $parameters = array();
    
    /**
     * @var $request
     */
    private $request;
    
    /**
     * @var $type
     */
    private $type;
    
    /**
     * @var $patterns
     */
    private $patterns = [
        'parameters' => '/{([^}]*)}/',
        'any' => '[a-zA-Z0-9\.\-_%]+',
        'int' => '[0-9]+',
        'str' => '[a-zA-Z\.\-_%]+'
    ];
    
    /**
     * @var $root
     */
    private $root;
    
    public function __construct($controllers, $root = null)
    {
        echo '|-> Request class <br />';
        $this->controllers = $this->sortUrlsLength($controllers, 'request');
        $this->root = $root;
        $this->request = $this->getRequest();
        $this->type = $this->getRequestType();
        $this->controller = $this->urlMatcher();
        $this->parameters = $this->getParameters();
        echo 'current controller: ';
        var_dump($this->controller);
    }    
    
    /** 
     * Описание метода
	 */
    public function getRequest()
    {
        $request = $this->clearParameters($_SERVER['REQUEST_URI']);
        $query = '?' . $this->clearParameters($_SERVER['QUERY_STRING']);
       
        if (strpos($request, $this->root) !== false){
            $request = substr($request, strlen($this->root), strlen($request));
            $request = trim($request, '/');
        }
       
        if (strpos($request, $query) !== false){
            $request = substr($request, 0, strlen($request) - strlen($query));
        }
        
        if (!$request){
            return false;
        }
        
        return $request;    
    }
    
    /**
     * Получаем тип запроса
     */
    public function getRequestType()
    {
        if((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')){
            return 'ajax';    
        }else{
            return strtolower($this->clearParameters($_SERVER['REQUEST_METHOD']));    
        }
    }
    
    /** 
     * Описание метода
     */
    private function urlMatcher()
    {
        var_dump('getRequest:', $this->request);
        echo '<br />';
        
        foreach($this->controllers as $controller){
            //ищем абсолютные правила
            if($controller['request'] == $this->request){
                return $controller;    
            }
            
            //правила с переменными
            if(strpos($controller['request'], '{') !== false){
                $parameters = [];
                $matches = [];
                
                preg_match_all($this->patterns['parameters'], $controller['request'], $parameters);
                
                if(isset($parameters[1][0]) && $parameters[1][0] == ''){
                    return false;
                }
                
                $patternRules = '/' . str_replace('/', '\/', $controller['request']);
                
                foreach($parameters[0] as $key => $value){
                    if(strpos($value, ':int') !== false){
                        $patternRules = str_replace($value, $this->patterns['int'], $patternRules);
                        continue;   
                    }

                    if(strpos($value, ':str') !== false){ 
                        $patternRules = str_replace($value, $this->patterns['str'], $patternRules);  
                        continue;                        
                    }
                    
                    $patternRules = str_replace($value, $this->patterns['any'], $patternRules); 
                }    
                
                $patternRules .= '/';
                
                preg_match($patternRules, $this->request, $matches);
                
                if(isset($matches[0]) && $matches[0] !== '' && $controller['type'] == $this->type && strlen($matches[0]) == strlen($this->request)){
                    return $controller; 
                }
            }
        }   
        
        return false;
    }
    
    /** 
     * Описание метода
     */
    private function getParameters()
    {
        if($_POST){
            $parameters['post'] = $this->clearParameters($_POST);
        }
        
        if ($_GET){
            $parameters['get'] = $this->clearParameters($_GET);
        }
        
        if ($_FILES){
            $parameters['files'] = $this->clearParameters($_FILES);
        }
        
        if(isset($parameters)){
            return $parameters;
        }else{
            return false;
        }
    }
    
    /** 
     * Описание метода
     */
    private function clearParameters($parameters)
    {
        if(is_array($parameters)){
            foreach ($parameters as $key => $value){
                $a[$key] = self::clearParameters($value);                
            }
        } else {
            $a = trim(trim(htmlentities($parameters, ENT_QUOTES, 'UTF-8')), '/');    
        }

        return $a;
    }
    
    /** 
     * Описание метода
     */
    private function sortUrlsLength($array, $sortKey){
        $size  = sizeof($array)-1;
        $buff = '';
        for($i = $size; $i>=0; $i--){
            for ($j = 0; $j<=($i-1); $j++){
                if (isset($array[$j+1]) && strlen($array[$j][$sortKey]) <= strlen($array[$j+1][$sortKey]) && !is_array($array[$j][$sortKey])) {
                    $k = $array[$j];
                    $array[$j] = $array[$j+1];
                    $array[$j+1] = $k;                    
                }
            }
        }
      
        return $array;
    }
}
?>
