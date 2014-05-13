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

use Happy\BaseModel as BaseModel;

class Model extends BaseModel
{
    protected $tableName = 'news';


    public function __construct()
    {
        parent::__construct();
        $this->setStructure("news_id", "%s_id");       
    }


    /**
     * Get News list
     *
     * @param  int  $limit - limit of list
     * @param  int  $offset - offset of list
     * @return array $response - contains a list of news records, count of records, limit, offset 
     */
    public function newsList($limit = null, $offset = null)
    {
        $newsList = $this->select()->orderBy('news_date', 'DESC')->orderBy('news_id');

        if (!empty($limit) and !empty($offset)) {
            $newsList = $newsList->limit($limit, $offset);
        } elseif (!empty($limit)) {
            $newsList = $newsList->limit($limit);
        }

        $response['content'] = array();
        
        foreach ($newsList as $item) {
            $response['content'][] = ([
                "news_id"          => $item->news_id,
                "news_link"        => $item->news_link,
                "news_title"       => $item->news_title,
                "news_content"     => $item->news_content
            ]);
        }

        $response['limit'] = $limit;
        $response['offset'] = $offset;
        $response['count'] = count($response['content']);

        return $response;
    }

    /**
     * Get News item
     *
     * @param  int  $newsId - id of news record
     * @param  int  $newsActive - 1 record is active, 0 record is not active
     * @return array $response - contains news item 
     */
    public function newsItem($newsLink, $newsActive = 1)
    {
        $newsItem = $this->where('news_link', $newsLink)->where('news_active', $newsActive)->findOne();

        if (empty($newsItem)) {
            return;
        }
        
        $response = ([
            "news_id"          => $newsItem->news_id,
            "news_link"        => $newsItem->news_link,
            "news_title"       => $newsItem->news_title,
            "news_content"     => $newsItem->news_content
        ]);
        
        return $response;        
    }


    /**
     * Описание метода
     */
    public function newsDelete($newsId)
    {
        if (empty($newsId))
        {
            return $response['error'] = 'empty_id';
        }

        $newsItem = $this->reset()->findOne($newsId);
        
        if (empty($newsItem)) {
            return $response['error'] = 'record_not_found';
        }
        
        if ($newsItem->delete()==1) {
            $response['content'] = $newsId;
            $response['error'] = 'news_delete_true';    
        } else {
            $response['error'] = 'error';
        }
    }
    
    /**
     * Описание метода
     */
    public function newsUpdate($parameters)
    {
        if (empty($parameters['news_id']))
        {
            return $response['error'] = 'empty_id';
        }

        $newsItem = $this->reset()->findOne($parameters['news_id']);
        
        if (empty($newsItem)) {
            $response['error'] = 'record_not_found';
        }
        
        foreach ($parameters as $key=>$value) {
            $newsItem->$key = $parameters[$key];
        }
        
        $newsItem->save();
        
        $response['content'] = $parameters;
        $response['error'] = 'news_update_true';
        return $response; 
    }
}

?>
