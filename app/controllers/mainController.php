<?php
include 'app/models/Task.php';
include 'app/models/User.php';

class mainController extends Controller
{
    public function indexAction(){
        $tasks = Task::GetAll();
        $paginationInfo = $tasks['paginationInfo'];
        unset($tasks['paginationInfo']);

        $this->view->generate('main.php', 'mainLayout.php', ['tasks' => $tasks, 'paginationInfo' => $paginationInfo]);
    }

    public function loginAction(){
        if($_SESSION['user']['isLogin']){
            $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
            header('Location:'.$host);
        } else {
            if(!empty($_POST)){
                $login = htmlspecialchars($_POST['login'], ENT_QUOTES);
                $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES);
                $users = User::GetAll();
                if($users[$login] && $users[$login] == $pass){
                    $_SESSION['user'] = ['isLogin' => 1, 
                                        'name' => $login];
                    echo 1;
                } else {
                    echo 'Некорректные логин/пароль';
                }
                
            } else {
                $this->view->generate('login.php', 'mainLayout.php');
            }
        }
    }

    public function logoutAction(){
        unset($_SESSION['user']);
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('Location:'.$host);
    }


    public function page404Action(){
        $this->view->generate('404.php', 'mainLayout.php');
    }

    public function addtaskAction(){
        if ($_POST) {
            foreach($_POST as $key => $value){
                if ($key == 'email') {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        echo "E-mail адрес '$value' указан неверно.\n";
                        exit;
                    }
                }
                if(empty($value)){
                    echo "Поле $key не может быть пустым.\n";
                    exit;
                }
            }
        }
        if(Task::insertTask($_POST)){
            $_SESSION['success'] = 'Задача успешно создана';
            echo 1;
        } else {
            echo "Ошибка при запросе к базе данных.\n";
        }

    }

    public function sortAction()
    {
        if($_POST){
            switch($_POST['sort']){
                case 'sortField':
                    switch($_POST['sortValue']){
                        case 'email':
                            $_SESSION['sortField'] = 'email';
                            break;
                        case 'user_name':
                            $_SESSION['sortField'] = 'user_name';
                            break;
                        case 'is_performed':
                            $_SESSION['sortField'] = 'is_performed';
                            break;
                        default:
                            echo 'Неверное значение сортировки';
                            exit;
                    }
                    break;
                case 'sortType':
                    switch($_POST['sortValue']){
                        case 'asc':
                            $_SESSION['sortType'] = 'asc';
                            break;
                        case 'desc':
                            $_SESSION['sortType'] = 'desc';
                            break;
                        default:
                            echo 'Неверное значение сортировки';
                            exit;
                    }
                    break;
                default:
                    echo 'Тип сортировки неверный!';
                    exit;
            }
            echo 1;
        }
    }

    public function deletetaskAction()
    {
        if($_SESSION['user']['isLogin']){
            if($_POST['id']){
                $id = intval($_POST['id']);
                if(Task::deleteTask($id)){
                    $_SESSION['success'] = 'Задача успешно удалена';
                    echo 1;
                } else {
                    echo 'Возникла ошибка при запросе к базе';
                    exit;
                }
            } else {
                echo 'Ошибка! Нет POST параметра';
                exit;
            }
        } else {
            echo 'Ошибка! Нет прав. Пожалуйста, выполните вход в приложение.';
            exit;
        }
    }

    public function performtaskAction()
    {
        if($_SESSION['user']['isLogin']){
            if($_POST['id']){
                $id = intval($_POST['id']);
                if(Task::performTask($id)){
                    $_SESSION['success'] = 'Отметка о выполнении поставлена';
                    echo 1;
                } else {
                    echo 'Возникла ошибка при запросе к базе';
                    exit;
                }
            } else {
                echo 'Ошибка! Нет POST параметра';
                exit;
            }
        } else {
            echo 'Ошибка! Нет прав. Пожалуйста, выполните вход в приложение.';
            exit;
        }
    }

    public function edittaskAction()
    {
        if($_SESSION['user']['isLogin']){
            if ($_POST) {
                foreach($_POST as $key => $value){
                    if ($key == 'email') {
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            echo "E-mail адрес '$value' указан неверно.\n";
                            exit;
                        }
                    }
                    if(empty($value)){
                        echo "Поле $key не может быть пустым.\n";
                        exit;
                    }
                }
            }
            if(Task::updateTask($_POST)){
                $_SESSION['success'] = 'Задача успешно изменена';
                echo 1;
            } else {
                echo "Ошибка при запросе к базе данных.\n";
            }
        } else {
            echo 'Ошибка! Нет прав. Пожалуйста, выполните вход в приложение.';
            exit;
        }
    }
}