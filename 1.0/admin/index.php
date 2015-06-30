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
include '../templates/admin/header.php';

# Соединямся с БД
include '../includes/dbconnect.php';
$link = mysqli_connect($host, $user, $pswd, $database);
mysqli_set_charset($link, "utf8");

$cookie_id = filter_input(INPUT_COOKIE, 'id');
$cookie_hash = filter_input(INPUT_COOKIE, 'hash');
$server_remote = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
if (isset($cookie_id) and isset($cookie_hash))
{
    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($cookie_id)."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);

    if(($userdata['user_hash'] !== $cookie_hash) or ($userdata['user_id'] !== $cookie_id)
 or (($userdata['user_ip'] !== $server_remote)  and ($userdata['user_ip'] !== "0")))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        echo 'Хм, какие-то проблемы... Возможно кто-то вошёл на сайт с другого компьютера. '
        . '<a href="/admin/login.php">Авторизуйтесь заново</a>';
    }
    else
    {
        if ($userdata['user_password'] === '') {
            $attention = '<font color="red"><strong>Внимание! У вас пустой пароль. Срочно смените его!</strong></font> ';
        }
        else {
            $attention = '';
        }
        echo '<div class="wrapper">'
                . '<div class="topmenu">Панель администрирования</div>'
                . '<div class="title">Привет, '.$userdata['user_login'].'. '.$attention.'<a href="/admin/changepass.php">Смена пароля.</a></div>'
                . '<div class="help"><a href="/admin/readme.html" target="_blank">Справка</a></div>'
                . '<div class="clear"></div>';
                
                echo '<div class="form-articles">'
                    . '<div class="title-block"><a href="/admin/add.php?type=article"><strong>ДОБАВИТЬ СТРАНИЦУ</strong></a><hr class="style-one"></div>'
                    . 'Список страниц:<br>';
        
        $query_pages = mysqli_query($link,"SELECT * FROM articles");
        
        while($row_pages = mysqli_fetch_row($query_pages)) {
            if ($row_pages[0] == 1){
                echo '&bull;&nbsp;'
                    .'<a href="/index.php?id='.$row_pages[0].'" target="_blank">'.$row_pages[1].'</a>&nbsp;&raquo;&nbsp;'
                    . '<a href="/admin/edit.php?type=article&id='
                    .$row_pages[0].'">Редактировать</a><br>';
            }
            else {
            echo '&bull;&nbsp;'
                . '<a href="/index.php?id='.$row_pages[0].'" target="_blank">'.$row_pages[1].'</a>&nbsp;&raquo;&nbsp;'
                . '<a href="/admin/edit.php?type=article&id='.$row_pages[0].'">Редактировать</a>&nbsp;|&nbsp;'
                . '<a href="/admin/delete.php?type=article&id='.$row_pages[0].'">Удалить</a><br>';
            }
        }
        echo '</div>';
        echo '<div class="form-chunks">'
            . '<div class="title-block" data-title="Чанки - это куски HTML кода, которые можно использовать в любом месте, любое количество раз.'
            . ' Использование: добавьте в любое место в шаблоне или в форме редактирования страницы конструкцию вида chunk_номерID. '
            . 'Например, таким образом можно вставить код меню.">'
            . '<a href="/admin/add.php?type=chunk"><strong>ДОБАВИТЬ ЧАНК</strong></a> (наведите курсор для справки)'
            . '<hr class="style-one"></div>';
        echo 'Список чанков:<br>';
        $query_chunks = mysqli_query($link,"SELECT * FROM chunks");
        while($row_pages = mysqli_fetch_row($query_chunks)) {
            echo '&bull;&nbsp;'.$row_pages[1].'&nbsp;&bull;&nbsp;ID: '.$row_pages[0].'&nbsp;&raquo;&nbsp;'
                . '<a href="/admin/edit.php?type=chunk&id='.$row_pages[0].'">Редактировать</a>&nbsp;|&nbsp;'
                . '<a href="/admin/delete.php?type=chunk&id='.$row_pages[0].'">Удалить</a><br>';
        }
        echo '</div>';
        echo '<div class="clear"></div>';
        
        echo '<div class="bottommenu"><div class="author">Разработка: <a href="mailto:admin@admvk.ru">Кузнецов В. В.</a></div>'
        . '<div class="copyright">&copy; <a href="http://owlcrew.ru">Артель Полуночников</a>, 2015</div></div></div>';
    }
}
else
{
    print '<a href="/admin/login.php">Авторизуйтесь</a> (если вы уже авторизовались, то у вас могут быть отключены куки)';
}

include '../templates/admin/footer.php';
