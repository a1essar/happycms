<?php
/*
 * Happy CMS 2
 *
 * Authors: Isa Ugurchiev, Magamed Esmurziev http://happycms.ru
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
 /*удалить*/
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

require_once __DIR__.'/../../vendor/autoload.php';

use Happy\Bootstrap;
(new Bootstrap)->run('testroot');

/*удалить*/
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<br/>Page generated in '.$total_time.' sec.';
echo '<br/>Memory peak usage ' . memory_get_peak_usage(false)/1024 . ' kb.';
?>