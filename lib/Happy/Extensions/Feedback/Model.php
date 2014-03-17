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
	public function feedback()
	{
	   $sth = $this->dbh->prepare("SELECT * FROM feedback");
       $sth->execute();
       return $sth->fetchAll();
    }
}
?>
