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
use Happy\Extensions\News\Controller as ControllerNews;

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
     * @var $controllers
     */
    private $controllers = array();
    
    /**
     * Constructor
     */
    public function __construct()
    {
    }    
    
    public function run($root = null)
    {
        $this->controller = new Controller();
        $this->controllers = array_merge($this->controllers, $this->controller->getController());
        //Загружаем контроллеры из модулей
        $this->controllers = array_merge($this->controllers, (new ControllerNews)->getController());
        $this->request = new Request($this->controllers, $root); 
        $this->controller->init($this->request->getRequestController(), $this->request->getRequestParameters());
    }
}
?>
