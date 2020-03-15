<?php

class Pagination
{
    private $paginationInfo;

    function __construct($paginationInfo)
    {
        $this->paginationInfo = $paginationInfo;
    }

    function getProperty($property)
    {
        return $this->paginationInfo[$property];
    }

    function addProperty($extendInfo)
    {
        $this->paginationInfo = array_merge($this->paginationInfo, $extendInfo);
    }

    public function getButtons()
    {
        // Проверяем нужны ли стрелки назад
        if ($this->paginationInfo['page'] != 1) $pervpage = '<div><a href= ./index?page=1><<</a></div>
        <div><a href= ./index?page='. ($this->paginationInfo['page'] - 1) .'><</a></div> ';
        // Проверяем нужны ли стрелки вперед
        if ($this->paginationInfo['page'] != $this->paginationInfo['countPage']) $nextpage = ' <div><a href= ./index?page='. ($this->paginationInfo['page'] + 1) .'>></a></div>
            <div><a href= ./index?page=' .$this->paginationInfo['countPage']. '>>></a></div>';

        // Находим две ближайшие станицы с обоих краев, если они есть
        if($this->paginationInfo['page'] - 2 > 0) $page2left = ' <a href= ./index?page='. ($this->paginationInfo['page'] - 2) .'>'. ($this->paginationInfo['page'] - 2) .'</a>';
        if($this->paginationInfo['page'] - 1 > 0) $page1left = '<a href= ./index?page='. ($this->paginationInfo['page'] - 1) .'>'. ($this->paginationInfo['page'] - 1) .'</a>';
        if($this->paginationInfo['page'] + 2 <= $this->paginationInfo['countPage']) $page2right = '<a href= ./index?page='. ($this->paginationInfo['page'] + 2) .'>'. ($this->paginationInfo['page'] + 2) .'</a>';
        if($this->paginationInfo['page'] + 1 <= $this->paginationInfo['countPage']) $page1right = '<a href= ./index?page='. ($this->paginationInfo['page'] + 1) .'>'. ($this->paginationInfo['page'] + 1) .'</a>';

        // Вывод меню
        return "$pervpage<div>$page2left</div><div>$page1left</div><div class='active'>{$this->paginationInfo['page']}</div><div>$page1right</div><div>$page2right</div>$nextpage";
    }
}