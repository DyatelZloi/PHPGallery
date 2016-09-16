<?php
class M_Images {

    private static $instance;
    private $mysql;

    // Получение единственного экземпляра
    public static function getInstance(){
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct(){
        $this->mysql = M_MYSQL::getInstance();
    }

    // Выборка всех статей в виде превью
    public function getIntro($sub, $page, $app){
        $sub = (int)$sub;
        $page = (int)$page;
        $page = !empty($page) ? $page : 1;
        $skip = ($page-1) * $app;
        $query = "SELECT * FROM `image` ORDER BY id_image LIMIT ".$skip.",".$app;
        return $this->mysql->select($query);
    }

    //TODO Выборка всех статей одного автора
    //Реализуем с помощью natural join
    //
    public function getImagesByAuthor($author){
        $query = "SELECT * FROM `image` WHERE `id_user` =".$author;
        return $this->mysql->select($query);
    }

    // выборка одной картинки по id
    public function getOne($id){
        $id = (int)$id;
        $query = "SELECT * FROM `image` WHERE `id_image` = '" . $id . "'";
        return $this->mysql->selectOne($query);
    }

    // Добавление картинки
    //Тут делаем и загрузку
    public function add($name, $id_author){
        $name = (string)$name;
        $id_author = (integer)$id_author;
        $object = ['name' => $name, 'id_user' => $id_author];
        return $this->mysql->insert('image', $object);
    }

    // Удаление картинки по ее id
    public function delete($id){
        $id = (int)$id;
        $where = "`id_image` = '$id'";
        return $this->mysql->delete('Image', $where);
    }

    // возвращает кол-во картинок в БД
    function count(){
        $query = "SELECT COUNT(*) AS `count` FROM `image`";
        return $this->mysql->select($query)['0']['count'];
    }
}
?>