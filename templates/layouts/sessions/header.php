
<?php

/** @var \eduslim\domain\session\ClanData $clanData */
/** @var \eduslim\domain\user\User $user */

?>

<div id="navbar">

    <div id="navigation">

        <img src="/images/icons/placeholder.png" alt="ClanLogo"
            style="border: 3px solid #060c18; width: 100px; height: 100px;"
        >

        <a class="nav" href="/clan/<?=$user->getClanId()?>">
            CLAN
        </a>

        <a class="nav" href="#">
            INFO
        </a>

        <a class="nav" href="#">
            PLANS
        </a>
    </div>

    <?=$this->insert("layouts/userbar")?>

</div>