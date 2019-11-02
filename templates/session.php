
<?php
/**
 * @var \eduslim\interfaces\domain\sessions\SessionInterface $session
 * @var string $usersJSON
 */

?>

<?=$this->layout("layouts/sessions/layout")?>


<!-- There must be a map -->

<div id="MapBoard"> </div>

<script>

let serverData = {
    mapRaw: '<?=$session->getMapStateR()?>',
    usersJSON: '<?=$usersJSON?>'
};

</script>

<script src="/dist/map/bundle.js"></script>

