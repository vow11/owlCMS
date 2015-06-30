<?php

/* 
 * This file is part of owlCMS
 * owlCMS is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     owlCMS is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with owlCMS.  If not, see <http://www.gnu.org/licenses/>.
 *  author: Vladimir Kuznetsov (admin@admvk.ru)
 */

require_once 'includes/dbconnect.php';
require_once 'includes/variables.php';
require_once 'templates/index.php';
require_once 'core/modules/main_page/index.php';
require_once 'core/modules/articles/index.php';


if ($uri === '/') {
    $res_html_main = $header.$row_html_main[0].$footer;
    $i = preg_match_all("/chunk_\d+/i", $res_html_main, $matches);
    $n = 0;
    $patterns = array();
    $replacements = array();
    while ($n < $i) {
        preg_match_all("/chunk_\d+/i", $res_html_main, $matches);
        $chunk_id = substr($matches[0][$n], 6);
        $query_chunk = "SELECT chunk_content FROM `chunks` where id=$chunk_id";
        $res_chunk =  mysqli_query($dbh, $query_chunk);
        $res = mysqli_fetch_row($res_chunk);
        $patterns[$n] = '/chunk_'.$chunk_id.'/i';
        $replacements[$n] = $res[0];
        $n = $n + 1;
    }
    ksort($patterns);
    ksort($replacements);
    $chunk_res_main = preg_replace($patterns, $replacements, $res_html_main);
    echo $chunk_res_main;
}
else {
    $res_html = $header.$row_html_articles[0].$footer;
    $i = preg_match_all("/chunk_\d+/i", $res_html, $matches);
    $n = 0;
    $patterns = array();
    $replacements = array();
    while ($n < $i) {
        preg_match_all("/chunk_\d+/i", $res_html, $matches);
        $chunk_id = substr($matches[0][$n], 6);
        $query_chunk = "SELECT chunk_content FROM `chunks` where id=$chunk_id";
        $res_chunk =  mysqli_query($dbh, $query_chunk);
        $res = mysqli_fetch_row($res_chunk);
        $patterns[$n] = '/chunk_'.$chunk_id.'/i';
        $replacements[$n] = $res[0];
        $n = $n + 1;
    }
    ksort($patterns);
    ksort($replacements);
    $chunk_res = preg_replace($patterns, $replacements, $res_html);
    echo $chunk_res;
}

mysqli_close($dbh);