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
        echo '|-> Controller class <br />';
        
        $this->setController('home/long/rules', function(){
            echo 'Home Controller <br />';    
        });
        
        $this->setController('/', function(){
            echo 'Home Controller <br />';    
        });
        
        $this->setController('/main', function(){
            $this->main();  
        });
    }    
    
    /** 
     * Описание метода
     */
    protected function setController($request, $controller, $type = 'get')
    {
        $this->controllers[] = [
            'request' => $request,
            'type' => $type,
            'controller' => $controller
        ];
    }
    
    /** 
     * Описание метода
     */
    public function getController()
    {
        return $this->controllers;
    }
    
    /** 
     * Описание метода
     */
    protected function main()
    {
        echo 'Main Controller method <br />';
    }
}
?>
