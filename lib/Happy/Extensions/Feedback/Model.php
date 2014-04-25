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

use Happy\BaseModel as BaseModel;

class Model extends BaseModel
{
    protected $tableName = 'feedback';


    public function __construct()
    {
        parent::__construct();
        $this->setStructure("feedback_id", "%s_id");       
    }


    /**
     * Get Feedback list
     *
     * @param  int  $limit - limit of list
     * @param  int  $offset - offset of list
     * @return array $response - contains a list of feedback records, count of records, limit, offset 
     */
    public function feedbackList($limit = null, $offset = null)
    {
        $feedbackList = $this->select()->orderBy('feedback_date', 'DESC')->orderBy('feedback_id');

        if (!empty($limit) and !empty($offset)) {
            $feedbackList = $feedbackList->limit($limit, $offset);
        } elseif (!empty($limit)) {
            $feedbackList = $feedbackList->limit($limit);
        }

        $response['content'] = array();
        
        foreach ($feedbackList as $item) {
            $response['content'][] = ([
                "feedback_id"       => $item->feedback_id,
                "feedback_name"     => $item->feedback_name,
                "feedback_date"     => $item->feedback_date,
                "feedback_active"   => $item->feedback_active
            ]);
        }

        $response['limit'] = $limit;
        $response['offset'] = $offset;
        $response['count'] = count($response['content']);

        return $response;
    }

    /**
     * Get Feedback item
     *
     * @param  int  $feedbackId - id of feedback record
     * @param  int  $feedbackActive - 1 record is active, 0 record is not active
     * @return array $response - contains feedback item 
     */
    public function feedbackItem($feedbackId, $feedbackActive = 1)
    {
        $feedbackItem = $this->where('feedback_active', $feedbackActive)->findOne($feedbackId);

        if (empty($feedbackItem)) {
            return;
        }
        
        $response = ([
            "feedback_id"       => $feedbackItem->feedback_id,
            "feedback_name"     => $feedbackItem->feedback_name,
            "feedback_date"     => $feedbackItem->feedback_date,
            "feedback_active"   => $feedbackItem->feedback_active
        ]);
        
        return $response;        
    }

    /**
     * Add Feedback item
     *
     * @param  array $parameters - data of feedback item
     * @return array $response - contains execution status 
     */
    public function feedbackAdd($parameters)
    {
        if (empty($parameters['feedback_name'])) {
            return $response['error'] = 'empty_name';
        }

        if (empty($parameters['feedback_email']) || !filter_var($parameters['feedback_email'], FILTER_VALIDATE_EMAIL)) {
            return $response['error'] = 'invalid_email';
        }

        if (empty($parameters['feedback_content'])) {
            return $response['error'] = 'empty_content';
        }

        if (mb_strlen($parameters['feedback_content'], 'UTF-8') > 500) {
            return $response['error'] = 'content_long';
        }

        $this->feedback_name    = $parameters['feedback_name'];
        $this->feedback_email   = $parameters['feedback_email'];
        $this->feedback_content = $parameters['feedback_content'];
        $this->feedback_date    = (new \DateTime())->format('Y-m-d H:i:s');        
        $this->save();
        
        $response['content'] = $parameters;
        $response['error'] = 'feedback_add_true';
        return $response;    
    }

    /**
     * Описание метода
     */
    public function feedbackDelete($feedbackId)
    {
        if (empty($feedbackId))
        {
            return $response['error'] = 'empty_id';
        }

        $feedbackItem = $this->reset()->findOne($feedbackId);
        
        if (empty($feedbackItem)) {
            return $response['error'] = 'record_not_found';
        }
        
        if ($feedbackItem->delete()==1) {
            $response['content'] = $feedbackId;
            $response['error'] = 'feedback_delete_true';    
        } else {
            $response['error'] = 'error';
        }
    }
    
    /**
     * Описание метода
     */
    public function feedbackUpdate($parameters)
    {
        if (empty($parameters['feedback_id']))
        {
            return $response['error'] = 'empty_id';
        }

        $feedbackItem = $this->reset()->findOne($parameters['feedback_id']);
        
        if (empty($feedbackItem)) {
            $response['error'] = 'record_not_found';
        }
        
        foreach ($parameters as $key=>$value) {
            $feedbackItem->$key = $parameters[$key];
        }
        
        $feedbackItem->save();
        
        $response['content'] = $parameters;
        $response['error'] = 'feedback_update_true';
        return $response; 
    }
}

?>
