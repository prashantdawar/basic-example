<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="room-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="model">
        <?php for($k = 0; $k < sizeof($models); $k++) { ?>
            <?php $model = $models[$k]; ?>
            <hr>
            <label for="">Model # <?= $k+1 ?></label>
            <?= $form->field($model, "[$k]name")->textInput();?>
            <?= $form->field($model, "[$k]surname")->textInput(); ?>
            <?= $form->field($model, "[$k]phone_number")->textInput();?>
        <?php } ?>
    </div>
    <hr>

    <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>