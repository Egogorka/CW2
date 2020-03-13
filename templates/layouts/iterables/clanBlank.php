<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 31.03.2019
 * Time: 14:32
 *
 * @var \eduslim\interfaces\domain\clan\ClanInterface $clan
 *
 */
?>

<hr style="size: 6px; width: calc(100%-20px);">

<div>

    <h4>Name : <?=$this->e($clan->getName())?></h4>
    <h4> <?=$this->e( ($leader = $clan->getLeader()) ? "Leader : ".$leader->getUsername() : "")?></h4>

</div>

<hr style="size: 6px; width: calc(100%-20px);">