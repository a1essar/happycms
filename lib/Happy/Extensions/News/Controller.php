<?php
/*
 * Happy CMS 2
 *
 * Authors: Isa Ugurchiev, Magamed Esmurziev http://happycms.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Happy\Extensions\News;

use Happy\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct()
    {   
        $this->setController('news', function(){
            $this->news();  
        });
        
        $this->setController('news/{id:int}', function($parameters){
            echo 'News Controller: news/{id:int} <br />'; 
            echo 'id: ' . $parameters['id']; 
        });
        
        $this->setController('news/{link:str}', function($parameters){
            echo 'News Controller: news/{link:str} <br />';
            echo 'link: ' . $parameters['link']; 
        });
        
        $this->setController('news/page{id:int}', function($parameters){
            echo 'News Controller: news/page{id:int} <br />';  
            echo 'id: ' . $parameters['id'];
        });
        
        $this->setController('news/category/{category}', function($parameters){
            echo 'News Controller: news/category/{category} <br />';   
            echo '$category: ' . $parameters['category'];
        });
        
        $this->setController('news/{category}/page{id:int}', function($parameters){
            $this->newsCategoryPage($parameters['category'], $parameters['id']);     
        });
        
        $this->setController('@/news/add', function(){
            echo 'News Controller: @/news/add <br />';   
        }, 'post');
        
        $this->setController('@/news/edit/{id:int}', function(){
            echo 'News Controller: @/news/edit/{id:int} <br />';   
        });
    }
    
    /** 
     * Описание метода
	 */
	protected function news()
	{
        echo 'News Controller method <br />';
	}
    
    /** 
     * Описание метода
	 */
	protected function newsCategoryPage($category, $id)
	{
        echo 'News Controller method <br />';
        echo '$category: ' . $category . ' $id: ' . $id;
	}
}
?>
