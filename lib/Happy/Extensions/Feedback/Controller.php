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
            $response = $this->feedback();
            
            return $this->render([
                    'template' => 'feedback',
                    'response' => $response
                ]
            );          
        });
    }
    
    
    /** 
     * Описание метода
	 */
	protected function feedback()
	{
        $model_feedback = new FeedbackModel();
        return $model_feedback->feedback();         
	}
}
?>
