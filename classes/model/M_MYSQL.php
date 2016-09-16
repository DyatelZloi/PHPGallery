<?php

class M_MYSQL extends mysqli{

    private $hostname = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbName   = 'malkov_db';
    private static $instance;

    public static function getInstance(){
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Подключение к БД с помощью родительского конструктора
    private function __construct(){
        parent::__construct($this->hostname, $this->username, $this->password);
        //TODO переделать это...
        !$this->select_db($this->dbName);
        $this->set_charset('utf8');
    }

    // Закрываем соединение при завершении скрипта
    function __destruct(){
        $this->close();
    }

    // Выборка строк
    // $query       - полный текст SQL запроса
    // результат    - ассоцыативный массив полученных строк из БД
    public function select($query){
        $array = [];
        if ($result = $this->query($query)){
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
        }
        if(!$result) {
            die($this->error);
        }
        return $array;
    }

    // Выборка строки
    // $query       - полный текст SQL запроса
    // результат    - массив полученной строки из БД
    public function selectOne($query){
        $row = '';
        if($result = $this->query($query)) {
            $row = $result->fetch_assoc();
        }
        if(!$result) {
            die($this->error);
        }
        return $row;
    }

    // Вставка строки
    // $table       - имя таблицы
    // $object      - ассоциативный массив с парами вида "имя столбца - значение"
    // результат    - идентификатор новой строки
    public function insert($table, $object){
        $columns = [];
        $values = [];
        foreach ($object as $key => $value) {
            $key = $this->real_escape_string($key . '');
            $columns[] = "`$key`";
            if($value === null) {
                $values[] = null;
            } else {
                $value = $this->real_escape_string($value . '');
                $values[] = "'$value'";
            }
        }
        $columns = implode(', ', $columns);
        $values = implode(', ', $values);
        $query = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $table, $columns, $values);
        $result = $this->query($query);
        if(!$result) {
            die($this->error);
        }
        return $this->insert_id;
    }

    // Изменение строк
    // $table       - имя таблицы
    // $object      - ассоциативный массив с парами вида "имя столбца - значение"
    // $where       - условие (часть SQL запроса)
    // результат    - число измененных строк
    public function update($table, $object, $where){
        $sets = [];
        foreach ($object as $key => $value) {
            $key = $this->real_escape_string($key . '');
            if ($value === null) {
                $sets[] = "`$key`=NULL";
            } else {
                $value = $this->real_escape_string($value . '');
                $sets[] = "`$key`='$value'";
            }
        }
        $sets = implode(',', $sets);
        $query = sprintf("UPDATE `%s` SET %s WHERE %s", $table, $sets, $where);
        $result = $this->query($query);
        if (!$result) {
            die($this->error);
        }
        return $this->affected_rows;
    }

    // Удаление строк
    // $table 		- имя таблицы
    // $where		- условие (часть SQL запроса)
    // результат	- число удаленных строк
    public function delete($table, $where){
        $query = sprintf("DELETE FROM `%s` WHERE %s", $table, $where);
        $result = $this->query($query);
        if (!$result) {
            die($this->error);
        }
        return $this->affected_rows;
    }

}