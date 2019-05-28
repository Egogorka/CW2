<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 09.03.2019
 * Time: 17:09
 */

namespace eduslim\interfaces\domain\clan;

use eduslim\interfaces\domain\user\UserInterface;

interface ClanInterface
{
    // Айди клана
    public function getId():?int;

    public function setId(int $id);

    // Название клана
    public function getName():?string;

    public function setName(string $name);

    // Айди лидера
    public function getLeaderId():?int;

    public function setLeaderId(int $id);

    // Сам лидер, если вообще нужен объект лидера
    public function getLeader():?UserInterface;
    public function setLeader(UserInterface $leader);
}