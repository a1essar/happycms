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
        echo '|-> News Controller class <br />';
        
        $this->setController('/news', function(){
            $this->news();  
        });
        
        $this->setController('/news/:id[int]', function(){
            $this->news();  
        });
    }
    
    /** 
     * Описание метода
	 */
	protected function news()
	{
        echo 'News Controller method <br />';
	}
}
?>
