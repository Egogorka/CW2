<?php
/**
 * Created by PhpStorm.
 * User: EGor
 * Date: 31.03.2019
 * Time: 14:29
 */
?>

<?=$this->layout("layouts/main/layout") ?>

<?php if($user AND !$user->getClanId() ) : ?>
    <h3> Wanna to create your own clan? Press <a href="clancreate">here</a> then! </h3>
<?php endif ?>

<?php
foreach ($clans as $clan)
    $this->insert('layouts/clans/clanBlank', ["clan" => $clan]);
?>
