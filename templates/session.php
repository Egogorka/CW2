
<?php
/**
 * @var \eduslim\interfaces\domain\sessions\SessionInterface $session
 * @var string $usersJSON
 * @var \eduslim\interfaces\domain\user\UserInterface $user
 * @var \eduslim\interfaces\domain\action\ActionInterface $action
 *
 * @var \eduslim\domain\session\ClanData[] $clanData
 *
 * @var \eduslim\interfaces\domain\clan\ClanInterface $userClan
 * @var \eduslim\interfaces\domain\clan\ClanInterface[] $clans
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
    usersJSON: '<?=$usersJSON?>',
    actionUrl: '<?=(is_null($action)) ? null : $action->getUrl()?>',
    budget: '<?=$clanData[$userClan->getId()]->getBudget()?>'
};

</script>

<script src="/dist/session.bundle.js"></script>

