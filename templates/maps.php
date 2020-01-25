<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 25.03.2019
 * Time: 17:46
 */

/** @var \eduslim\domain\maps\Map[] $maps **/

?>

<?=$this->layout("layouts/main/layout") ?>

<a href="/maps/editor">Create a map</a>

<?php
foreach ($maps as $map)
    $this->insert('layouts/maps/mapBlank', ["map" => $map]);
?>
