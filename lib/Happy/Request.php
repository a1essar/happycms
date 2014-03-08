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
    public function __construct($appRoot)
    {
        echo 'Request class <br />';
        echo $this->getRequest($appRoot);
        echo '<br />';
    }    
    
    /** 
     * Описание метода
	 */
	public function getRequest($appRoot = '')
	{
        $request = $this->clearParameters($_SERVER['REQUEST_URI']);
        $query = '?' . $this->clearParameters($_SERVER['QUERY_STRING']);
       
        if (strpos($request, $appRoot) !== false){
            $request = substr($request, strlen($appRoot), strlen($request));
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
}
?>
