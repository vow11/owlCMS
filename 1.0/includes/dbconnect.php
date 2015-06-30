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

$host='localhost'; // имя хоста (уточняется у провайдера)
$database=''; // имя базы данных, которую вы должны создать
$user=''; // заданное вами имя пользователя, либо определенное провайдером
$pswd=''; // заданный вами пароль
 
$dbh = mysqli_connect($host, $user, $pswd, $database) or die("Don't connect to MySQL.");
mysqli_select_db($dbh, $database) or die("Don't connect to base.");
mysqli_set_charset($dbh, "utf8");
