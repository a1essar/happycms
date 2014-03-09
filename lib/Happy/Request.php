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
     * @var $root
     */
    private $root;
    
    public function __construct($controller, $root = null)
    {
        echo '|-> Request class <br />';
        $this->controllers = $this->sortUrlsLength($controller, 'request');
        $this->root = $root;
        var_dump('getRequest:', $this->getRequest());
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
     * Описание метода
	 */
    private function urlMatch()
    {
        
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
                if (isset($array[$j+1]) && strlen($array[$j][$sortKey]) <= strlen($array[$j+1][$sortKey])) {
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
