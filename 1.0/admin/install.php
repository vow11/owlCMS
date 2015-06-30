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

if(isset($_POST['submit'])) {
    $login = $_POST['login'];
    # Записываем в БД новый login
    mysqli_query($link, "INSERT INTO users (user_login) VALUES ('".$login."')");
    # Переадресовываем браузер на страницу авторизации
    header("Location: login.php"); exit();
}
    


?>

<div class="wrapper">
<div class="topmenu">Создание администратора</div>

<div class="TTWForm-container"><form method="POST" class="TTWForm">
        <div id="field1-container" class="field f_100"><label>Логин (допустимые символы: A..Z, a..z, 0..9)</label><br>
            <strong>!!! Не забудьте задать пароль и удалить файл install.php !!!</strong><br><br><br>
    <input name="login" type="text"></div>
<div id="form-submit" class="field f_100 clearfix submit">
<input name="submit" type="submit" value="Создать" action="install.php">
</div>
    </form></div>
<div class="bottommenu"><div class="author">Разработка: <a href="mailto:admin@admvk.ru">Кузнецов В. В.</a></div>
<div class="copyright">&copy; <a href="http://owlcrew.ru">Артель Полуночников</a>, 2015</div></div>
</div>

<?php
include '../templates/admin/footer.php';