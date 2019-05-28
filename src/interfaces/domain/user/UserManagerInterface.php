<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 09.03.2019
 * Time: 16:48
 */
namespace eduslim\interfaces\domain\user;

use eduslim\interfaces\domain\clan\ClanInterface;

interface UserManagerInterface
{
    // Сохраняем данного юзера в БД
    public function save(UserInterface $user):bool;

    // Выбираем всех юзеров
    public function findAll():?array;

    // Ищем юзера по айди
    public function findById(int $id):?UserInterface;

    // Ищем юзера по имени
    public function findByName(string $name):?UserInterface;

    // Ищем юзеров по клану
    public function findByClan(ClanInterface $clan):?array ;
}