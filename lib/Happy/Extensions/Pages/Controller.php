<?php
/*
 * Happy CMS 2
 *
 * Authors: Isa Ugurchiev, Magamed Esmurziev http://happycms.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Happy\Extensions\Pages;

use Happy\Controller as BaseController;
use Happy\Extensions\Pages\Model as PagesModel;

class Controller extends BaseController
{
    public function __construct()
    {   
        $this->setController('pages', function() {
            $response = (new PagesModel())->pagesList();
            
            return $this->render([
                    'template' => 'pages_list',
                    'response' => $response
                ]
            );          
        });
        
        $this->setController('{pages_link}', function($parameters) {
            $response = (new PagesModel())->pagesItem($parameters['pages_link']);
   
            if (!empty($response)) {
                return $this->render([
                        'template' => 'pages_item',
                        'response' => $response
                    ]
                );   
            } else {
                return $this->render([
                        'template' => '404'
                    ]
                );
            }            
        });
        

        $this->setController('@/pages', function() {
            $response = (new PagesModel())->pagesList();
            
            return $this->render([
                    'template' => 'admin/pages_list',
                    'response' => $response
                ]
            );      
        });
        
        $this->setController('@/pages/{pages_link}', function($parameters) {
            $response = (new PagesModel())->pagesItem($parameters['pages_link']);
            
            if (!empty($response)) {
                return $this->render([
                        'template' => 'admin/pages_item',
                        'response' => $response
                    ]
                );   
            } else {
                return $this->render([
                        'template' => 'admin/404'
                    ]
                );
            }             
        });
        
        $this->setController('@/pages/add', function($parameters) {
            (new PagesModel())->pagesAdd($parameters['post']);            
        }, 'ajax');
        
        $this->setController('@/pages/update', function($parameters) {
            (new PagesModel())->pagesUpdate($parameters['post']);             
        }, 'ajax');
        
        $this->setController('@/pages/delete', function($parameters) {
            (new PagesModel())->pagesDelete($parameters['post']['pages_id']);          
        }, 'ajax');
    }
}
?>
