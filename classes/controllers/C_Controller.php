<?php
abstract class C_Controller{

	// Генерация внешнего шаблона
	protected abstract function render();

	// Функция отрабатывающая до основного метода
	protected abstract function before();

	public function request($action){
		$this->before();
		$this->$action();
		$this->render();
	}

	// Проверка метода запроса GET
	protected function isGet(){
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	// Првоерка метода запроса POST
	protected function isPost(){
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	// Шаблонизатор
	protected function template($fileName, $vars = []){
		// Устанавливаем переменные
		extract($vars);

		// Генерация HTML в строку.
		ob_start();
		include $fileName;
		return ob_get_clean();
	}

	// Функция редиректа
	protected function redirect($url, $time = '', $message = ''){
		if($time == '') {
			header("Location: $url");
			die;
		}
		if($time != '') {
			header("Refresh: $time; URL = $url");
			die($message);
		}
	}

	// Обработка вызова несуществующего метода
	public function __call($name, $params){
		die('404 Not found, такой страницы не существует');
	}

}