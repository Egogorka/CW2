<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 09.03.2019
 * Time: 17:25
 */

namespace eduslim\interfaces\domain\clan;

use eduslim\interfaces\domain\user\UserInterface;

interface ClanManagerInterface
{
    // Сохраняем готовый клан в БД
    public function save( ClanInterface $clan );

    // Ищем клан по id
    public function findById(int $id):?ClanInterface;

    // Ищем по имени
    public function findByName(string $name):?ClanInterface;

    // Ищем по члену клана
    // Должно быть в ClansDao, но т.к. условились, что юзеры уже имеют всё засетаное, то функция не требуется
    public function findByMember(UserInterface $user):?ClanInterface;

    // Получаем все кланы
    public function findAll():?array;

    // Получаем всех юзеров клана
    public function getUsersOf( ClanInterface $clan ):?array;
}