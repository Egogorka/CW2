<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 17:55
 */

namespace eduslim\interfaces\domain\maps;

interface MapInterface
{

    // Setters
    public function setId(int $id);

    public function setName(string $name);

    public function setMap(string $map);

    // Setting the creator of the map (id)
    public function setCreator(int $user);


    // Getters

    /** @return int */
    public function getId():?int;

    /** @return string */
    public function getName():?string;

    /** @return string (JSON */
    public function getMap():?string;

    /** @return int */
    public function getCreator():?int;

}
