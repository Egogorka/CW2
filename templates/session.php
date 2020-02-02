
<?php
/**
 * @var \eduslim\interfaces\domain\sessions\SessionInterface $session
 * @var string $usersJSON
 * @var \eduslim\interfaces\domain\user\UserInterface $user
 */
?>

<?=$this->layout("layouts/sessions/layout")?>


<!-- There must be a map -->

<div id="MapBoard"> </div>

<script>

let serverData = {
    user : '<?=json_encode($user)?>',
    sessionId : '<?=$session->getId()?>',
    mapRaw: '<?=$session->getMapStateR()?>',
    usersJSON: '<?=$usersJSON?>'
};

</script>

<script src="/dist/session.bundle.js"></script>

