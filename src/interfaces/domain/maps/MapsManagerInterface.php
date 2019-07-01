<?php


namespace eduslim\interfaces\domain\maps;


interface MapsManagerInterface
{
    public function findById(int $id):?MapInterface;
    public function findByName(string $name):?MapInterface;
    public function findAll():?array;

    //public function findByCreator()

}