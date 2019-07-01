
<div>

    <?php /** @var \eduslim\domain\user\User $user */
    if(!empty($user)) :
        ?>

        <b><?=$this->e($user->getUsername())?></b><br>
        <a href="/auth/unlog/">Unlog</a>

        <?php if(!empty($user->getClan())) : ?>

            <b><a href="/clan/<?=$user->getClanId() ?>"><?=$user->getClan()->getName()?></a></b>

        <?php endif ?>

    <?php else : ?>

         Haven't registered yet? <br>
        <a href="/auth/signup/">Sign up</a>
        <a href="/auth/login/">Log in</a>

    <?php endif  ?>

</div>