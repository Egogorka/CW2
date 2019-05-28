<?php
/*
 * enablejs(path) позволяет
 * подключить любой скрипт, если он не был подключен
 * path - строка пути (полного)
 */

class EnableJS{

    protected $enabledArr = [];

    function enable($path){

        // Создаём вариант пути без / или ., чтобы точно его идентефицировать

            // Убираем /
            $sarr = explode('/', $path);
            // Если перед / не текст, убираем
            if ($path[0] == '/' or $sarr[0][0] == '.' ) $sarr[0] = '';
            $npath = join('',$sarr);
            // Создаём путь

        foreach ($this->enabledArr as $val) {
            if ($val == $npath)
                return 0; // Мы нашли, что этот файл уже подключен - не подключаем
        }

        $this->enabledArr[count($this->enabledArr)] = $npath;
        echo '<script type="text/javascript" src="'.$path.'"></script>';
        return null;
    }

}

//$GLOBALS['enableJs'] = new EnableJS();

$_JSEnable = new EnableJS();