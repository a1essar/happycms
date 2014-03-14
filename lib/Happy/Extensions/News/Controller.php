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
        
        $this->setController('news/{category}', function($parameters){
            $this->newsCategoryPage($parameters['category']); 
        });
        
        $this->setController('news/{category}/page{id:int}', function($parameters){
            $this->newsCategoryPage($parameters['category'], $parameters['id']);     
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
	protected function newsCategoryPage($category, $id = null)
	{
        echo 'News Controller method <br />';
        echo '$category: ' . $category . ' $id: ' . $id;
	}
}
?>
