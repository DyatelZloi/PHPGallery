<?php
function __autoload($classname){
    switch ($classname[0]) {
        case 'C':
            include_once("classes/controllers/$classname.php");
            break;
        case 'M':
            include_once("classes/model/$classname.php");
    }
}

$action = 'action_';
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

switch ($_GET['c']) {
    case 'auth':
        $controller = new C_Auth();
        break;
    case 'reg':
        $controller = new C_Registration();
        break;
    case 'user':
        $controller = new C_UserPanel();
        break;
    //case 'image':
    //    $controller = new C_Images();
    //    break;
    default:
        $controller = new C_Images();
}

$controller->request($action);