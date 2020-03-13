<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 07.04.2019
 * Time: 14:50
 */

namespace eduslim\interfaces\domain\action;

interface ActionInterface
{
    public function getId():?int;

    public function setId(int $id);

    public function getName():?string;

    public function setName(string $name);

    public function getUrl():?string;

    public function setUrl(string $url);
}