
<div>

    <?php /** @var \eduslim\domain\user\User $user */
    if(!empty($user)) :
        ?>

        <p> Hello, <?=$this->e($user->getUsername())?></p>
        <a href="/auth/unlog/">Unlog</a>

        <?php if(!empty($user->getClan())) : ?>

            <a href="/clan/<?=$user->getClanId() ?>"><?=$user->getClan()->getName()?></a>

        <?php endif ?>

    <?php else : ?>

         Haven't registered yet? <br>
        <a href="/auth/signup/">Sign up</a>
        <a href="/auth/login/">Log in</a>

    <?php endif  ?>

</div>