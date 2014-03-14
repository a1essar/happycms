<?php
/*
 * Happy CMS 2
 *
 * Authors: Isa Ugurchiev, Magamed Esmurziev http://happycms.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Happy;

class Response
{
    /**
     * @var array
     */
    private $send = [
        'template' => null,
        'response' => [],
        'format' => 'php',
        'status-code' => 200,
        'config' => []
    ];
    
    /**
     * Constructor
     */
    public function __construct()
    {
    } 
    
    /**
     * �������� ������
     */
    private function setParameters($send = [])
    {
        if($send == null){
            $send = [];
        }
        
        return $this->send = array_merge($this->send, $send);
    } 
    
    /**
     * �������� ������
     */
    private function sendHeaders()
    {
        if($this->send['format'] == 'php'){
            header('Content-Type: text/html; charset=utf-8');
        }
        
        if($this->send['format'] == 'json'){
            header('Content-Type: application/json');
        }
        
        header('X-Powered-By: Happy CMS');
        http_response_code($this->send['status-code']);
    }  
    
    /**
     * �������� ������
     */
    private function sendContent()
    {
        if($this->send['format'] == 'json'){
            echo json_encode($this->send['response']);
            return true;
        }
        
        if($this->send['template'] && $this->send['format'] == 'php'){
            $response = $this->send['response'];
            $config = $this->send['config'];
            require_once $this->send['config']['template'] . $this->send['config']['/'] . $this->send['template'] . '.php';
        }
    }  
    
    /**
     * �������� ������
     */
    public function send($send = [])
    {
        if(!$send){
            return false;
        }
        
        $this->setParameters($send);
        
        if(!file_exists($this->send['config']['template'] . $this->send['config']['/'] . $this->send['template'] . '.php') && $this->send['format'] == 'php'){
            $this->send['status-code'] = 404;
            $this->send['template'] = 404;               
        }

        $this->sendHeaders(); 
        $this->sendContent();   
    }
    
    /**
     * �������� ������
     */
    private function getTemplate($temptale)
    {
        if(file_exists($this->send['config']['template'] . $this->send['config']['/'] . $temptale . '.php')){
            require_once $this->send['config']['template'] . $this->send['config']['/'] . $temptale . '.php';               
        }
    }
}
?>
