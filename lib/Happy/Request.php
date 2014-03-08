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
    public function __construct()
    {
        echo 'Request class <br />';
    }    
    
    /** 
     * Описание метода
	 */
	public static function getRequest()
	{
	   $request = $_SERVER['REQUEST_URI'];
       var_dump($request);
       return $request;    
	}
}
?>
