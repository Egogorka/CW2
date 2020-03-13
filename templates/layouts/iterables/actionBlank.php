<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 07.03.2020
 * Time: 18:07
 */

/**
 * @var \eduslim\interfaces\domain\action\ActionInterface $action
 */
?>

<hr style="size: 6px; width: calc(100%-20px);">

<div>

    <h4>Name : <?=$this->e($action->getName())?></h4>
    <h4>Url : <?=$this->e($action->getUrl())?></h4>

</div>

<hr style="size: 6px; width: calc(100%-20px);">
