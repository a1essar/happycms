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

use Happy\Model as BaseModel;

class Model extends BaseModel
{
    /** 
     * Описание метода
	 */
	public function feedbackList()
	{	   
	   $sth = $this->dbh->prepare("SELECT * FROM feedback ORDER BY feedback_date DESC, feedback_id DESC");
       $sth->execute();
       $response = $sth->fetchAll();      
       return $response;
    }
    
    /** 
     * Описание метода
	 */
	public function feedbackItem($feedbackId)
	{
        $sth = $this->dbh->prepare("SELECT * FROM feedback WHERE feedback_id = :feedback_id");
        $sth->bindParam(':feedback_id', $feedbackId, \PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }
    
    /** 
     * Описание метода
	 */
    public function feedbackAdd($parameters)
    {
        if(empty($parameters['feedback_name'])){
            //укажите имя
            return;  
        }
        
        if(!filter_var($parameters['feedback_email'], FILTER_VALIDATE_EMAIL)){
            //неверный формат почты
        }
        
        if(empty($parameters['feedback_content'])){
            //введите текст   
        }
        
        if(mb_strlen($parameters['feedback_content'],'UTF-8') > 500){
            //текст не должен превышать 500 символов     
        }
        
        $parameters['feedback_date'] = (new \DateTime())->format('Y-m-d H:i:s');
        
        $sql = "INSERT INTO feedback (feedback_name, feedback_email, feedback_content, feedback_date)
                              VALUES (:feedback_name, :feedback_email, :feedback_content, :feedback_date)";
               
        $sth = $this->dbh->prepare($sql);              
        $sth->bindParam(':feedback_name', $parameters['feedback_name'], \PDO::PARAM_STR);
        $sth->bindParam(':feedback_email', $parameters['feedback_email'], \PDO::PARAM_STR);
        $sth->bindParam(':feedback_content', $parameters['feedback_content'], \PDO::PARAM_STR);
        $sth->bindParam(':feedback_date', $parameters['feedback_date'], \PDO::PARAM_STR);
                                
        $sth->execute();        
    }
    
    /** 
     * Описание метода
	 */
    public function feedbackDelete($feedbackId)
    {
        if(empty($feedbackId)){
            //укажите имя
            return;  
        }

        $sth = $this->dbh->prepare("DELETE FROM feedback WHERE feedback_id = :feedback_id");
        $sth->bindParam(':feedback_id', $feedbackId, \PDO::PARAM_INT);   
        $sth->execute();
        
        if($sth->rowCount()>0)
        {
            return;
        }      
    }
}
?>
