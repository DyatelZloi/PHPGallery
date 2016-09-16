<?php
require_once('functions/view_helper.php');

class C_UserPanel extends C_Base{

        protected function before(){
            parent::before();
            $this->menuActive = 'user';
        }

        function __construct(){
            parent::__construct();
            if (!isset($_SESSION['id_user'])) {
                $this->redirect('index.php', 1, 'Отказано в доступе.');
            }
        }

        //Меню пользователя
        //TODO доделать
        public function action_index(){
            $this->title_page = 'Домашняя страница';
            $this->title .= '::' . $this->title_page;
            if($this->isGet()) {
                if (isset($_GET['delete']) && isset($_GET['name'])) {
                    if ($this->mImages->delete($_GET['delete']) > 0) {
                        $name_image = $_GET['name'];
                        $filename = $_SERVER['DOCUMENT_ROOT'] . '/img/mini/' . $name_image;
                        unlink($filename);
                        $filename = $_SERVER['DOCUMENT_ROOT'] . '/img/original/' . $name_image;
                        unlink($filename);
                        $_SESSION['notice'] = 'Картинка успешно удаленна';
                        $this->redirect('index.php?c=user&act=index');
                    } else {
                        $_SESSION['notice'] = 'Ошибка';
                    }
                }
            }
            $user = $_SESSION['id_user'];
            $images = $this->mImages->getImagesByAuthor($user);
            $this->content = $this->template('view/templates/v_user.php', ['images' => $images]);
        }

        //Редактирование информации о себе
        public function action_edit(){
            $this->title_page = 'Редактировать';
            $this->title .= '::'.$this->title_page;
            if($this->isPost()){
                if(!empty($_POST) && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['name'])){
                    $this->mUsers->update($_POST['mail'], $_POST['pass'], $_POST['name'], $_SESSION['id_user']);
                    $_SESSION['notice'] = 'Информация изменена';
                    $this->redirect('index.php?c=user&act=index');
                }
            }
            $this->content = $this->template('view/templates/v_update.php');
        }

        // Загрузка новой картинки
        public function action_upload(){
            $this->title_page = 'Загрузить картинку';
            $this->title .= '::' . $this->title_page;
            if($this->isPost()) {
                if(isset($_FILES['file'])) {
                    if ($this->upload_file($_FILES['file'])) {
                        $file = $_FILES['file'];
                        $user = $_SESSION['id_user'];
                        $this->mImages->add($file['name'], $user);
                        $_SESSION['notice'] = 'Картинка успешно загружена';
                        $this->redirect('index.php?c=user&act=index');
                    }
                }else $_SESSION['notice'] = 'Ошибка загрузки файла';
            }
            $this->content = $this->template('view/templates/v_upload.php');
        }

        //TODO подумай о загрузке файлов с одинаковыми именами
        //Загрузка самого изображения
        private function upload_file($file){
            if(copy($file['tmp_name'], 'img/original/'.$file['name'])){
                copy($file['tmp_name'], 'img/mini/'.$file['name']);
                $this->create_thumb('img/mini/'.$file['name']);
                return true;
            } return false;
        }

        //Создание копии изображения
        //TODO width and height в константы, в отдельный файл
        private function create_thumb($src){
            $source=$src;
            $dest = $src;
            $height=200;
            $width=200;
            $rgb=0xffffff;
            $size = getimagesize($source);
            $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
            $icfunc = "imagecreatefrom" . $format;
            if (!function_exists($icfunc)) return false;
            $x_ratio = $width / $size[0];
            $y_ratio = $height / $size[1];
            $ratio       = min($x_ratio, $y_ratio);
            $use_x_ratio = ($x_ratio == $ratio);
            $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
            $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
            $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
            $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
            $img = imagecreatetruecolor($width,$height);
            imagefill($img, 0, 0, $rgb);
            $photo = $icfunc($source);
            imagecopyresampled($img, $photo, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);
            imagejpeg($img, $dest);
            imagedestroy($img);
            imagedestroy($photo);
        }
    }
?>