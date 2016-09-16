<?php
require_once('functions/view_helper.php');
class C_Images extends C_Base {

        protected function before(){
            parent::before();
            $this->menuActive = 'article';
        }

        // Главная страница
        public function action_index(){
            $this->title_page = 'Главная';
            $this->title .= '::' . $this->title_page;
            if($_SESSION['num'] === null) {
                $_SESSION['num'] = 5;
            }
            if(isset($_GET['num'])) {
                $valid_a = [3, 5, 10];
                if($this->validateParam($_GET['num'], $valid_a)) {
                    $_SESSION['num'] = $_GET['num'];
                }
                $this->redirect($_SERVER['PHP_SELF']);
            }
            $this->mUsers->ClearSessions();
            $count = $this->mImages->count();
            $n = $count / $_SESSION['num'];
            if(isset($_GET['page'])) {
                $valid_a = range(1, ceil($n));
                if(!$this->validateParam($_GET['page'], $valid_a)) {
                    $this->redirect($_SERVER['PHP_SELF']);
                }
            }
            $usersOnline = $this->mUsers->isOnline();
            $images = $this->mImages->getIntro(40, $_GET['page'], $_SESSION['num']);
            $sort = $this->template('view/templates/block/v_block_sort.php');
            $nav = $this->template('view/templates/block/v_block_nav.php', ['n' => $n]);
            $array = ['images' => $images, 'nav' => $nav, 'sort' => $sort, 'usersOnline' => $usersOnline];
            $this->content = $this->template('view/templates/v_index.php', $array);
        }

        // Страница просмотра одной картинки
        public function action_image(){
            if($this->isGet()) {
                $image = $this->mImages->getOne($_GET['id']);
                $user = $this->mUsers->get_information($image['id_user']);
            }
            $this->title_page = $image['name'];
            $this->title .= '::' . $this->title_page;
            $array = ['image' => $image, 'user' => $user];
            $this->content = $this->template('view/templates/v_image.php', $array);
        }

        //Просмотр галлереи чужого пользователя
        public function action_author(){
            $user = $this->mUsers->get_information($_GET['id']);
            $this->title_page = 'Галерея '.$user['name'];
            $this->title .= '::' . $this->title_page;
            if($this->isGet()){
                $image = $this->mImages->getImagesByAuthor($_GET['id']);
                $user = $this->mUsers->get_information($image['id_user']);
                if ($_GET['id'] == $_SESSION['id_user'] )
                    $this->redirect('index.php?c=user');
            }
            $this->content = $this->template('view/templates/v_user_view.php', ['images' => $image]);
        }
    }
?>