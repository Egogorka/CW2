<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 07.04.2019
 * Time: 14:51
 */

namespace eduslim\interfaces\domain\sessions;

// TODO SessionInterface

use eduslim\interfaces\domain\mapstate\MapStateInterface;
use eduslim\interfaces\domain\action\ActionInterface;
use eduslim\interfaces\domain\clan\ClanInterface;
use eduslim\interfaces\domain\maps\MapInterface;

interface SessionInterface
{
    // Setters
    public function setId(int $id);
    public function setName(string $name);

    public function setMapId(int $id);
    public function setActionId(int $id);

    public function setMap(MapInterface $map);
    public function setAction(ActionInterface $action);
    public function setMapState(MapStateInterface $mapState);
    public function setMapStateR(string $mapStateR);

    // Getters
    public function getId():? int;
    public function getName():? string;

    public function getMapId():? int;
    public function getActionId():? int;

    public function getMap():? MapInterface;
    public function getAction():? ActionInterface;
    public function getMapState():? MapStateInterface;
    public function getMapStateR(): ?string ;
}