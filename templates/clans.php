<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 31.03.2019
 * Time: 14:29
 */

/**
 * @var \eduslim\interfaces\domain\user\UserInterface $user
 * @var \eduslim\interfaces\domain\clan\ClanInterface[] $clans
 */
?>

<?=$this->layout("layouts/main/layout") ?>

<?php if($user AND !$user->getClanId() ) : ?>
    <h3> Wanna to create your own clan? Press <a href="clancreate">here</a> then! </h3>
<?php endif ?>

<?php
foreach ($clans as $clan)
    $this->insert('layouts/iterables/clanBlank', ["clan" => $clan]);
?>
