<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 17:55
 */

namespace eduslim\interfaces\domain\maps;

use eduslim\interfaces\domain\user\UserInterface;

interface MapInterface
{

    // Setters
    public function setId(int $id);

    public function setName(string $name);

    public function setMapR(string $map);

    // Setting the creator of the map (id)
    public function setCreatorId(int $userId);

    public function setCreator(UserInterface $user);

    // Getters

    /** @return int */
    public function getId():?int;

    /** @return string */
    public function getName():?string;

    /** @return string */
    public function getMapR():?string;

    /** @return int */
    public function getCreatorId():?int;

    public function getCreator():?UserInterface;

}
