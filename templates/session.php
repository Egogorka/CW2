
<?php
/**
 * @var \eduslim\interfaces\domain\sessions\SessionInterface $session
 */
?>

<?=$this->layout("layouts/sessions/layout")?>


<!-- There must be a map -->

<div id="MapBoard"> </div>

<script> var mapRaw ='<?=$session->getMapStateR()?>'; </script>

<script src="/dist/map/bundle.js"></script>

