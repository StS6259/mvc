<?php if(\application\components\Messages::hasError()) : ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <ul>
            <?php echo \application\components\Messages::displayError() ?>
        </ul>
    </div>
<?php endif ?>

<?php if(\application\components\Messages::hasSuccess()): ?>
    <div class="alert alert-success alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <ul>
            <?php echo \application\components\Messages::displaySuccess() ?>
        </ul>
    </div>
<?php endif ?>

<?php if(\application\components\Messages::hasWarning()): ?>
    <div class="alert alert-warning alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <ul>
            <?php echo \application\components\Messages::displayWarning() ?>
        </ul>
    </div>
<?php endif ?>
