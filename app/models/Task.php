<?php

class Task extends Model
{
    public static function insert($task)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO `tasks`(`user_name`,`email`, `text`, `is_performed`, `is_edited_admin`) VALUES (:name_bind, :email_bind, :text_bind, 0, 0)';
        $result = $db->prepare($sql);
        $result->bindParam(':name_bind', htmlspecialchars($task['userName'], ENT_QUOTES), PDO::PARAM_STR);
        $result->bindParam(':email_bind', htmlspecialchars($task['email'], ENT_QUOTES), PDO::PARAM_STR);
        $result->bindParam(':text_bind', htmlspecialchars($task['text'], ENT_QUOTES), PDO::PARAM_STR);
        return $result->execute();
    }

    public static function getAll($pagination = null)
    {

        $sortField = isset($_SESSION['sortField']) ? $_SESSION['sortField'] : 'user_name';
        $sortType = isset($_SESSION['sortType']) ? $_SESSION['sortType'] : 'desc';


        $limitSql = '';
        $db = Db::getConnection();

        if(isset($pagination)){
            $numTaskOnPage = $pagination->getProperty('numTaskOnPage');
            $page = $_GET['page'];
            $result = $db->query("SELECT COUNT(*) FROM tasks");
            $countTasks = $result->fetch()[0];
            $countPage = intval(($countTasks - 1) / $numTaskOnPage) + 1;
            $page = intval($page);
            if(empty($page) or $page < 0){
                $page = 1;
            }
            if($page > $countPage){
                $page = $countPage;
            }
            $start = $page * $numTaskOnPage - $numTaskOnPage;
            $limitSql = " LIMIT $start, $numTaskOnPage";
            $pagination->addProperty(['page' => $page, 'countPage' => $countPage]);
        }
        

        $sql = "SELECT * FROM `tasks` ORDER BY {$sortField} {$sortType}{$limitSql}";
        $result = $db->query($sql);
        $index = array();
        $i=0;
        if(!empty($result)){
            while($row = $result->fetch()) {
                $index[$i] = $row;
                $i++;
            }
        }
        return $index;
    }

    public static function update($task)
    {
        $db = Db::getConnection();
        $sql = 'UPDATE `tasks` SET user_name=:name_bind, email=:email_bind, text=:text_bind, is_edited_admin=1 WHERE id=:id_bind';
        $result = $db->prepare($sql);
        $result->bindParam(':name_bind', htmlspecialchars($task['userName'], ENT_QUOTES), PDO::PARAM_STR);
        $result->bindParam(':email_bind', htmlspecialchars($task['email'], ENT_QUOTES), PDO::PARAM_STR);
        $result->bindParam(':text_bind', htmlspecialchars($task['text'], ENT_QUOTES), PDO::PARAM_STR);
        $result->bindParam(':id_bind', htmlspecialchars($task['id'], ENT_QUOTES), PDO::PARAM_STR);
        return $result->execute();
    }

    public static function delete($id)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM `tasks` WHERE id=:id_bind';
        $result = $db->prepare($sql);
        $result->bindParam(':id_bind',$id, PDO::PARAM_INT);
        return $result->execute();
    }

    public static function perform($id)
    {
        $db = Db::getConnection();
        $sql = 'UPDATE `tasks` SET is_performed=1 WHERE id=:id_bind';
        $result = $db->prepare($sql);
        $result->bindParam(':id_bind',$id, PDO::PARAM_INT);
        return $result->execute();
    }
}