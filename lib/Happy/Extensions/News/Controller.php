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
use Happy\Extensions\News\Model as NewsModel;

class Controller extends BaseController
{
    public function __construct()
    {   
        $this->setController('news', function() {
            $response = (new NewsModel())->newsList();
            
            return $this->render([
                    'template' => 'news_list',
                    'response' => $response
                ]
            );          
        });
        
        $this->setController('{news_link}', function($parameters) {
            $response = (new NewsModel())->newsItem($parameters['news_link']);
   
            if (!empty($response)) {
                return $this->render([
                        'template' => 'news_item',
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
        
        
        $this->setController('@/news', function() {
            $response = (new NewsModel())->newsList();
            
            return $this->render([
                    'template' => 'admin/news_list',
                    'response' => $response
                ]
            );      
        });
        
        $this->setController('@/news/{news_link}', function($parameters) {
            $response = (new NewsModel())->newsItem($parameters['news_link']);
            
            if (!empty($response)) {
                return $this->render([
                        'template' => 'admin/news_item',
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
        
        $this->setController('@/news/delete', function($parameters) {
            (new NewsModel())->newsDelete($parameters['post']['news_id']);          
        }, 'ajax');
        
        $this->setController('@/news/update', function($parameters) {
            (new NewsModel())->newsUpdate($parameters['post']);             
        }, 'ajax');
    }
}
?>
