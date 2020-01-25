<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 17:47
 */

// There is a $map variable
/** @var \eduslim\domain\maps\Map $map **/

?>

<hr style="size: 6px; width: calc(100%-20px);">

<div>

    <img src="/images/maps/<?=$this->e($map->getName())?>.png" alt="No map">
    <h3>Name : <?=$this->e($map->getName())?></h3>

</div>

<hr style="size: 6px; width: calc(100%-20px);">
