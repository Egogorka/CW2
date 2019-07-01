<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 06.04.2019
 * Time: 17:29
 */

/**@var \eduslim\interfaces\domain\clan\ClanInterface $clan
 * @var bool $clanLeaderBool
 * @var array $sessions
 * @var array $clanMembers

 */
?>

<?=$this->layout("layouts/main/qwerty", ['title' => $clan->getName(), 'error' => $error ?? null]) ?>

<div class="qwertyForm" style="
    margin: auto;
    width: calc(90% - 10px);
">
    <div style=" width: 100%;">

        <?php if($clanLeaderBool) $this->insert("layouts/clan/leaderInterface"); ?>

        <h2> Info </h2>

        <hr style="size: 6px; width: calc(100%-20px);">

        <h2> List of current sessions</h2>
        <ol>
            <?php
            /** @var \eduslim\interfaces\domain\sessions\SessionInterface $session */
            foreach ($sessions as $session){
                echo "<li>".$session->getName()."</li>";
            }

            ?>
        </ol>
        <hr style="size: 6px; width: calc(100%-20px);">

        <h2> List of users </h2>

        <h4> Leader : <?= /** @var \eduslim\interfaces\domain\clan\ClanInterface $clan */
            $clan->getLeader()->getUsername() ?> </h4>

        <ol>
            <?php
            /** @var \eduslim\interfaces\domain\user\UserInterface $member */
            foreach ($clanMembers as $member){
                echo "<li>".$member->getUsername()."</li>";
            }
            ?>
        </ol>

        <hr style="size: 6px; width: calc(100%-20px);">

<!--        <h2> Voting </h2>-->
<!---->
<!--        <hr style="size: 6px; width: calc(100%-20px);">-->
<!---->
<!--        <h2> Requests </h2>-->
<!---->
<!--        <hr style="size: 6px; width: calc(100%-20px);">-->

    </div>
</div>

