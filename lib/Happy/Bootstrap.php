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

use Happy\Request;
use Happy\Controller;

class Bootstrap
{
    /**
     * @var Happy\Request
     */
    private $request;
    
    /**
     * @var Happy\Controller
     */
    private $controller;
    
    /**
     * Constructor
     */
    public function __construct($appRoot)
    {
        echo 'Bootstrap class <br />';
        
        $this->initialize($appRoot);
    }    
    
    private function initialize($appRoot){
        $this->request = new Request($appRoot); 
        $this->controller = new Controller();
        $test = $this->controller->getController()['main']['controller'];
        $test();
    }
}
?>
