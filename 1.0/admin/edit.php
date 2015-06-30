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
        echo '<div class="wrapper">';
        
        if (!isset($_POST['edit'])) {
            if (filter_input(INPUT_GET, 'type') === 'article') {
                $id = filter_input(INPUT_GET, 'id');
                $query_pages = mysqli_query($link,"SELECT * FROM articles WHERE id=$id");
                $row_pages = mysqli_fetch_row($query_pages);
                echo '<div class="topmenu">Редактирование страницы</div>'
                    . '<div class="TTWForm-container"><form method="POST" class="TTWForm">'
                    . '<div id="field1-container" class="field f_100"><label>Название</label>'
                    . '<input name="name" type="text" value='.$row_pages[1].' id="name"></div>'
                    . '<div id="field2-container" class="field f_100 textarea"><label>HTML контент</label>'
                    . '<textarea rows="20" cols="45" name="text" id="text">'.$row_pages[2].'</textarea></div>'
                    . '<div id="field1-container" class="field f_100"><label>Шаблон</label>'
                    . '<input name="template" type="text" value='.$row_pages[3].' id="template"></div>'
                    . '<input name="edit" type="hidden" id="edit">'
                    . '<div id="form-submit" class="field f_100 clearfix submit">'
                    . '<input name="submit" type="submit" value="Сохранить" action="edit.php">'
                    . '<span class="custom"><a href="/admin/index.php">Отменить</a></span></div>'
                    . '</form></div>';
            }
            else {
                $id = filter_input(INPUT_GET, 'id');
                $query_pages = mysqli_query($link,"SELECT * FROM chunks WHERE id=$id");
                $row_pages = mysqli_fetch_row($query_pages);
                echo '<div class="topmenu">Редактирование чанка</div>'
                    . '<div class="TTWForm-container"><form method="POST" class="TTWForm">'
                    . '<div id="field1-container" class="field f_100"><label>Название</label>'
                    . '<input name="name" type="text" value='.$row_pages[1].' id="name"></div>'
                    . '<div id="field2-container" class="field f_100 textarea"><label>HTML контент</label>'
                    . '<textarea rows="20" cols="45" name="text" id="text">'.$row_pages[2].'</textarea></div>'
                    . '<input name="edit" type="hidden" id="edit">'
                    . '<div id="form-submit" class="field f_100 clearfix submit">'
                    . '<input name="submit" type="submit" value="Сохранить" action="edit.php">'
                    . '<span class="custom"><a href="/admin/index.php">Отменить</a></span></div>'
                    . '</form></div>';
            }
        }
        else {
            
            if (filter_input(INPUT_GET, 'type') === 'article') {
                $name = mysqli_real_escape_string($link, $_POST['name']);
                $text = mysqli_real_escape_string($link, $_POST['text']);
                $template = mysqli_real_escape_string($link, $_POST['template']);
                $query_pages = mysqli_query($link, "UPDATE articles SET name='".$name."', html_content='".$text."', template='".$template."' WHERE id='".$_GET['id']."'");
                header("Location: index.php"); exit();
            }
            else {
                $name = mysqli_real_escape_string($link, $_POST['name']);
                $text = mysqli_real_escape_string($link, $_POST['text']);
                $query_pages = mysqli_query($link, "UPDATE chunks SET name='".$name."', chunk_content='".$text."' WHERE id='".$_GET['id']."'");
                header("Location: index.php"); exit();
            }
            
        }
        echo '</div>';
    }
}
else
{
    print '<a href="/admin/login.php">Авторизуйтесь</a> (если вы уже авторизовались, то у вас могут быть отключены куки)';
}

include '../templates/admin/footer.php';