<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 07.03.2020
 * Time: 18:07
 */

/**
 * @var \eduslim\interfaces\domain\action\ActionInterface[] $actions
 */
?>

<?=$this->layout("layouts/main/layout") ?>

<?php
foreach ($actions as $action)
    $this->insert('layouts/iterables/actionBlank', ["action" => $action]);
?>

