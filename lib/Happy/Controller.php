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

class Controller
{
    /**
     * @var $controllers
     */
    private $controllers = array();
    
    public function __construct()
    {
        echo 'Controller class <br />';
        
        $this->setController('home', ['/'], function(){
            echo 'Home Controller <br />';    
        });
        
        $this->setController('main', ['/main'], function(){
            $this->main();  
        });
    }    
    
    /** 
     * Описание метода
	 */
	protected function setController($name, $request, $controller)
	{
        $this->controllers[$name] = [
            'request' => $request,
            'controller' => $controller
        ];
	}
    
    /** 
     * Описание метода
	 */
	public function getController($name = null)
	{
        return (!$name) ? $this->controllers : $this->controllers[$name];
	}
    
    /** 
     * Описание метода
	 */
	protected function main()
	{
        echo 'Main Controller <br />';
	}
}
?>
