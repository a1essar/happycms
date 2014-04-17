<?php
/*
 * Happy CMS 2
 *
 * Authors: Isa Ugurchiev, Magamed Esmurziev http://happycms.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Happy\Extensions\Feedback;

use Happy\Controller as BaseController;
use Happy\Extensions\Feedback\Model as FeedbackModel;

class Controller extends BaseController
{
    public function __construct()
    {   
        $this->setController('feedback', function(){
            $response = (new FeedbackModel())->feedbackList();
            
            return $this->render([
                    'template' => 'feedback_list',
                    'response' => $response
                ]
            );          
        });
        
        $this->setController('feedback/{id:int}', function($parameters){
            $response = (new FeedbackModel())->feedbackItem($parameters['id']);
   
            if(!empty($response)){
                return $this->render([
                        'template' => 'feedback_item',
                        'response' => $response
                    ]
                );   
            }else{
                return $this->render([
                        'template' => '404'
                    ]
                );
            }            
        });
        
        $this->setController('feedback/add', function($parameters){
            (new FeedbackModel())->feedbackAdd($parameters);            
        }, 'ajax');
        
        $this->setController('@/feedback', function(){
            $response = (new FeedbackModel())->feedbackList();
            
            return $this->render([
                    'template' => 'admin/feedback_list',
                    'response' => $response
                ]
            );      
        });
        
        $this->setController('@/feedback/{id:int}', function($parameters){
            $response = (new FeedbackModel())->feedbackItem($parameters['id']);
            
            if(!empty($response)){
                return $this->render([
                        'template' => 'admin/feedback_item',
                        'response' => $response
                    ]
                );   
            }else{
                echo '404';
            }            
        });
        
        $this->setController('@/feedback/delete', function($parameters){
            (new FeedbackModel())->feedbackDelete($parameters['id']);          
        }, 'ajax');
        
        $this->setController('@/feedback/update', function($parameters){
            (new FeedbackModel())->feedbackUpdate($parameters);             
        }, 'ajax');
    }
}
?>
