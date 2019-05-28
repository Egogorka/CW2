<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 17:46
 */
?>

<?=$this->layout("layouts/main/layout") ?>

<?php
foreach ($maps as $map)
    $this->insert('layouts/maps/mapBlank', ["map" => $map]);
?>
