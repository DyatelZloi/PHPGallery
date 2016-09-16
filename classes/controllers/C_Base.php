<?php
abstract class C_Base extends C_Controller{

	protected $title;
    protected $title_page;
	protected $content;
    protected $menuActive;
	protected $mArticles;
	protected $mUsers;
	protected $mImages;

	function __construct(){
		setlocale(LC_ALL, 'ru_RU.UTF-8');
		mb_internal_encoding('UTF-8');
		session_start();
		$this->mUsers = M_Users::getInstance();
		//$this->mArticles = M_Articles::getInstance();
		$this->mImages = M_Images::getInstance();
		$this->mUsers->get();

	}

	protected function before(){
		$this->title = 'Мой сайт';
		$this->title_page = '';
		$this->content = '';
	}

	protected function validateParam($value, $valid){
		if(in_array((int)$value, $valid)) {
			return true;
		}
		return false;
	}

	// генерация базового шаблона
	public function render(){
		$vars = ['title' => $this->title, 'content' => $this->content, 'title_page' => $this->title_page, 'menuActive' => $this->menuActive];
		$page = $this->template('view/v_main.php', $vars);
		@header('Content-type: text/html; charset=utf-8');
		echo $page;
	}

}