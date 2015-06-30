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


// Страница авторизации

# Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

# Соединямся с БД
include '../includes/dbconnect.php';
$link = mysqli_connect($host, $user, $pswd, $database);
mysqli_set_charset($link, "utf8");

if(isset($_POST['submit']))
{
    # Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
    # Проверяем наличие install.php
    if (file_exists('install.php')) {
        echo '<div style="text-align:center; margin:auto; position:relative; clear:both; height: 40px; line-height:40px;">'
        . '<font color="red"><h1><strong>!!! Удалите install.php !!!</strong></h1></font></div>';
    }
    else {
    # Сравниваем пароли
    if ($data['user_password'] === '') {
        # Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        if(!@$_POST['not_attach_ip'])
        {
            # Если пользователя выбрал привязку к IP
            # Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        }

        # Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

        # Ставим куки
        setcookie("id", $data['user_id'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30);

        # Переадресовываем браузер на главную страницу админки
        header("Location: index.php"); exit();
    }
    else {
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        # Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        if(!@$_POST['not_attach_ip'])
        {
            # Если пользователя выбрал привязку к IP
            # Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        }

        # Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

        # Ставим куки
        setcookie("id", $data['user_id'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30);

        # Переадресовываем браузер на главную страницу админки
        header("Location: index.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
    }
}
}
?>
<div class="wrapper">
<div class="topmenu">Авторизация</div>

<div class="TTWForm-container"><form method="POST" class="TTWForm">
<div id="field1-container" class="field f_100"><label>Логин</label>
<input name="login" type="text"></div>
<div id="field2-container" class="field f_100"><label>Пароль</label>
<input name="password" type="password"></div>
<div id="field3-container" class="field f_100"><label>Не прикреплять к IP (не безопасно)</label>
<input name="not_attach_ip" type="checkbox"></div>
<div id="form-submit" class="field f_100 clearfix submit">
<input name="submit" type="submit" value="Войти" action="login.php">
</div>
    </form></div>
<div class="bottommenu"><div class="author">Разработка: <a href="mailto:admin@admvk.ru">Кузнецов В. В.</a></div>
<div class="copyright">&copy; <a href="http://owlcrew.ru">Артель Полуночников</a>, 2015</div></div>
</div>

<?php
    
include '../templates/admin/footer.php';