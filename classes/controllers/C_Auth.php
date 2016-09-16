<?php
require_once('functions/view_helper.php');

class C_Auth extends C_Base{

    protected function before(){
        parent::before();
        $this->menuActive = 'auth';
    }

    public function action_index(){
        $this->title_page = 'Авторизация';
        $this->title .= '::' . $this->title_page;
        $this->mUsers->logout();
        if($this->isPost()) {
            if($this->mUsers->login($_POST['login'], $_POST['password'], isset($_POST['remember'])))
                $this->redirect('index.php');
        }
        $this->content = $this->template('view/templates/v_auth.php');
    }

}