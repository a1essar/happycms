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

use Happy\BaseModel as BaseModel;
use Happy\Helpers as Helpers;

class Model extends BaseModel
{
    protected $tableName = 'pages';


    public function __construct()
    {
        parent::__construct();
        $this->setStructure("pages_id", "%s_id");       
    }


    /**
     * Get Pages list
     *
     * @param  int  $limit - limit of list
     * @param  int  $offset - offset of list
     * @return array $response - contains a list of pages records, count of records, limit, offset 
     */
    public function pagesList($limit = null, $offset = null)
    {
        $pagesList = $this->select()->orderBy('pages_date', 'DESC')->orderBy('pages_id');

        if (!empty($limit) and !empty($offset)) {
            $pagesList = $pagesList->limit($limit, $offset);
        } elseif (!empty($limit)) {
            $pagesList = $pagesList->limit($limit);
        }

        $response['content'] = array();
        
        foreach ($pagesList as $item) {
            $response['content'][] = ([
                "pages_id"          => $item->pages_id,
                "pages_link"        => $item->pages_link,
                "pages_title"       => $item->pages_title,
                "pages_content"     => $item->pages_content
            ]);
        }

        $response['limit'] = $limit;
        $response['offset'] = $offset;
        $response['count'] = count($response['content']);

        return $response;
    }

    /**
     * Get Pages item
     *
     * @param  int  $pagesId - id of pages record
     * @param  int  $pagesActive - 1 record is active, 0 record is not active
     * @return array $response - contains pages item 
     */
    public function pagesItem($pagesLink, $pagesActive = 1)
    {
        $pagesItem = $this->where('pages_link', $pagesLink)->where('pages_active', $pagesActive)->findOne();

        if (empty($pagesItem)) {
            return;
        }
        
        $response = ([
            "pages_id"          => $pagesItem->pages_id,
            "pages_link"        => $pagesItem->pages_link,
            "pages_title"       => $pagesItem->pages_title,
            "pages_content"     => $pagesItem->pages_content
        ]);
        
        return $response;        
    }
    
    /**
     * Add pages item
     *
     * @param  array $parameters - data of pages item
     * @return array $response - contains execution status 
     */
    public function pagesAdd($parameters)
    {
        if (empty($parameters['pages_title'])) {
            return $response['error'] = 'empty_title';
        }
        
        if (empty($parameters['pages_link'])) {
            $parameters['pages_link'] = Helpers::translit($parameters['pages_title']);   
        } else {
            $parameters['pages_link'] = Helpers::translit($parameters['pages_link']);
        }
        
        if ($this->checkLink($this->tableName,'pages_link', $parameters['pages_link'])) {
            $parameters['pages_link'] .= $this->getAutoincrement($this->tableName);
        }
        
        $this->pages_title = $parameters['pages_title'];
        $this->pages_link = $parameters['pages_link'];
        $this->pages_date = $this->now();        
        $this->save();
        
        $response['content'] = $parameters;
        $response['error'] = 'pages_add_true';
        return $response;    
    }

    
    /**
     * Описание метода
     */
    public function pagesUpdate($parameters)
    {
        if (empty($parameters['pages_id']))
        {
            return $response['error'] = 'empty_id';
        }
        
        if (empty($parameters['pages_title'])) {
            return $response['error'] = 'empty_title';
        }
        
        if (empty($parameters['pages_link'])) {
            $parameters['pages_link'] = Helpers::translit($parameters['pages_title']);   
        } else {
            $parameters['pages_link'] = Helpers::translit($parameters['pages_link']);
        }
        
        if ($this->checkLink($this->tableName,'pages_link', $parameters['pages_link'])) {
            $parameters['pages_link'] .= $this->getAutoincrement($this->tableName);
        }

        $pagesItem = $this->reset()->findOne($parameters['pages_id']);
        
        if (empty($pagesItem)) {
            $response['error'] = 'record_not_found';
        }
        
        foreach ($parameters as $key=>$value) {
            $pagesItem->$key = $parameters[$key];
        }
        
        $pagesItem->save();
        
        $response['content'] = $parameters;
        $response['error'] = 'pages_update_true';
        return $response; 
    }
    
    
    /**
     * Описание метода
     */
    public function pagesDelete($pagesId)
    {
        if (empty($pagesId))
        {
            return $response['error'] = 'empty_id';
        }

        $pagesItem = $this->reset()->findOne($pagesId);
        
        if (empty($pagesItem)) {
            return $response['error'] = 'record_not_found';
        }
        
        if ($pagesItem->delete()==1) {
            $response['content'] = $pagesId;
            $response['error'] = 'pages_delete_true';    
        } else {
            $response['error'] = 'error';
        }
    }
}

?>
