<?php
/**
 * @var \eduslim\domain\session\ClanData[] $clanData
 * @var \eduslim\domain\user\User $user
 *
 * @var \eduslim\interfaces\domain\clan\ClanInterface $userClan
 * @var \eduslim\interfaces\domain\clan\ClanInterface[] $clans
 */

use eduslim\interfaces\domain\mapstate\CellInterface;

?>

<div id="navbar">

    <div id="navigation">

        <a class="nav" href="/clan/<?=$user->getClanId()?>">
            Clan
        </a>

        <a class="nav" id="nav-info">
            Info
        </a>

        <a class="nav" id="nav-plans">
            Plans
        </a>
    </div>

    <div style="display: flex; justify-content: center; align-items: center">
        <img src="/images/icons/placeholder.png" alt="ClanLogo"
             style="border: 3px solid #060c18; width: 100px; height: 100px; margin-top: 40px"
        >

        <div id="clan-readiness">

            <?php
            foreach ($clans as $clan){
                $data = $clanData[$clan->getId()];
                echo "<div class='readyIcon ".CellInterface::COLORS[$data->getColor()].
                    " ".(($data->getPlansStatus()) ? 'ready' : 'notReady').
                    "' data-clan-id='".$clan->getId()."'></div>";
            }
            ?>

        </div>
    </div>

    <div id="budget-box">
        <span id="current-budget">$<?=$clanData[$userClan->getId()]->getBudget()?></span> <br>
        <span id="spendings">$0</span>
    </div>

</div>

<?=$this->insert("layouts/sessions/plans")?>