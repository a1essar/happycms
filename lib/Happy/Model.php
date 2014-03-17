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

use Happy\Config;

class Model
{
    public $dbh;
    
    public function __construct()
    {   
        $dsn = 'mysql:dbname='.Config::$config['db']['mysql']['name'].';host='.Config::$config['db']['mysql']['host'].';charset='.Config::$config['db']['mysql']['charset'];
        
        try {
            $this->dbh = new \PDO($dsn, Config::$config['db']['mysql']['user'], Config::$config['db']['mysql']['password']);
        } catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
    }
    
    public function __destruct()
    {
        $this->dbh = NULL;
    }
}
?>
