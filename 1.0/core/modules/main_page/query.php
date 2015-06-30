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

$query_html = "SELECT html_content FROM `articles` where id=1";
$res_html =  mysqli_query($dbh, $query_html);
$row_html_main = mysqli_fetch_row($res_html);

$query_name = "SELECT name FROM `articles` where id=1";
$res_name =  mysqli_query($dbh, $query_name);
$row_name = mysqli_fetch_row($res_name);
$page_name = $row_name[0];
