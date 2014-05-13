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

use Happy\Config as Config;
use Voodoo;

class BaseModel extends Voodoo\VoodOrm
{
    protected $pdo = null;
    protected $tableName;

    public function __construct()
    {
        $dsn = 'mysql:dbname='.Config::$config['db']['mysql']['name'].';host='.Config::$config['db']['mysql']['host'].';charset='.Config::$config['db']['mysql']['charset'];
        
        if (!$this->pdo) {
            $this->pdo = new \PDO($dsn, Config::$config['db']['mysql']['user'], Config::$config['db']['mysql']['password']);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);                
        }

        parent::__construct($this->pdo);
        $instance = parent::table($this->tableName);
        $this->table_name = $instance->getTablename();          
    }
    
    protected function checkLink($tableName, $columnName, $link)
    {
        $this->tableName = $tableName;
        $count = $this->where($columnName, $link)->count();

  		if ($count)
		{
			return true;
		}
		else
		{
            return false;
		}  
    }
    
   	protected function getAutoincrement($tablename)
	{
        $query = $this->pdo->prepare("SHOW TABLE STATUS LIKE '".$tablename."'");
        $query->execute();
        $autoIncrement = $query->fetch(\PDO::FETCH_ASSOC);
        return $autoIncrement['Auto_increment'];
	}
}
?>
