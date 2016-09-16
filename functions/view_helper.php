<?php

// В качестве аргумента используется ключ массива в сессии, в котором хранится сообщение об ошибке
function vHelper_flashMessage($name)
{
    $storage = $_SESSION["$name"];
    unset($_SESSION["$name"]);
    return $storage;
}

// Функция для изменения цвета нажатой ссылки. Принимает два параметра для сравнения и название класса(css),
// при совпадении выводит класс
function vHelper_print_if_true($i, $num, $color)
{
    if($i == $num) {
        echo 'class="' . $color . '"';
    }
}