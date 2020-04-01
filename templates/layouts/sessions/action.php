<?php
/**
 * @var \eduslim\interfaces\domain\action\ActionInterface $action
 */
?>

<div id="action-div" style="display: none">
    <form id="action-form" action="<?=$action->getUrl()?>">
        <input type="button" value="Play!">
    </form>
</div>