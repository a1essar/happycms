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

use Happy\Config;

class Controller
{
    /**
     * @var array
     */
    private $controllers = [];
    
    public function __construct()
    {   
        $this->setController('', function(){
            return $this->render(['template' => 'home']);    
        });
    }    

    /** 
     * Описание метода
     */
    public function init($controller, $parameters)
    {
        if(!$controller){
            $this->error404();
            return false;    
        }
        
        return $controller['controller']($parameters);
    }
    
    /** 
     * Описание метода
     * @todo возможность указывать необязательный параметр в запросе: page/{param1:str}/({param2:int})
     * @todo возможность передовать в контроллере запросы массивом: ['home', 'main', 'page/{param}']
     * @todo объеденить запросы и тип в одну строку: page/{param}:post
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
    protected function error404()
    {
        echo 'error 404 <br />';
    }
    
    /** 
     * Описание метода
     * @param array $send
     * @todo метод render, загружает шаблон и передает в него параметры
     */
    protected function render($send)
    {   
        Config::init();
        $send['config'] = Config::get('path');
                        
        return $send;
    }
}
?>
