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

class Config
{
    /**
     * @var array
     */
    public static $config = [
        'db' => [
            'mysql' => [
                'host' => '',
                'user' => '',
                'password' => '',
                'name' => ''
            ]
        ],
        'path' => [
            'root' => '',
            '/' => '/',
            'template' => 'app/templates',
            'template404' => '404',
            'images' => 'app/images',
            'css' => 'app/css',
            'js' => 'app/js',
            'plugins' => 'app/plugins',
            'fonts' => 'app/fonts'
        ]
    ];
    
    public static function get($key){
        return self::$config[$key];  
    }
    
    public static function set($key, $value){
        return self::$config[$key] = $value;  
    }
    
    public static function init(){
        return self::$config['path']['root'] = $_SERVER['SERVER_NAME'];  
    }
}
?>
