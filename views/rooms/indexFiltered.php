<?php

use yii\helpers\Url;

    $operators = [ '=', '<=', '>=' ];
    $sf = $searchFilter;

    ?>

<form method="post" action="<?= Url::to(['rooms/index-filtered']); ?>">
    <input 
        type="hidden" 
        name="<?= Yii::$app->request->csrfParam; ?>"  
        value="<?= Yii::$app->request->csrfToken; ?>"
    />

    <div class="row">
        <?php $operator = $sf['floor']['operator']; ?>
        <?php $value = $sf['floor']['value']; ?>
        <div class="col-md-3">
            <label for="">Floor</label>
            <br>
            <select name="SearchFilter[floor][operator]">
                <?php foreach ($operators as $op) { ?>
                    <?php $selected = ($operator == $op) ? 'selected':''; ?>
                    <option value="<?= $op; ?>" <?= $selected ?>><?= $op; ?></option>
                <?php } ?>
            </select>
            <input type="text" name="SearchFilter[floor][value]" value="<?= $value?>">
        </div>

        <?php $operator = $sf['room_number']['operator']; ?>
        <?php $value = $sf['room_number']['value']; ?>
        <div class="col-md-3">
            <label for="">Room Number</label>
            <br>
            <select name="SearchFilter[room_number][operator]">
                <?php foreach($operators as $op) { ?>
                    <?php $selected = ($operator == $op)? 'selected' : ''; ?>
                    <option value="<?= $op ?>" <?= $selected ?>><?= $op; ?></option>
                <?php } ?>
            </select>
            <input type="text" name="SearchFilter[room_number][value]" value="<?= $value ?>" />
        </div>

        <?php $operator = $sf['price_per_day']['operator']; ?>
        <?php $value = $sf['price_per_day']['value']; ?>
        <div class="col-md-3">
            <label for="">Price Per Day</label>
            <br>
            <select name="SearchFilter[price_per_day][operator]">
                <?php foreach($operators as $op) { ?>
                    <?php $selected = ($operator == $op) ? 'selected' : ''; ?>
                    <option value="<?= $op; ?>" <?= $selected ?>><?= $op ?></option>
                <?php } ?>
            </select>
            <input type="text" name="SearchFilter[price_per_day][value]" value="<?= $value ?>" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <input type="submit" value="filter" class="btn btn-primary" />
            <input type="text"   value="reset"  class="btn btn-primary" />
        </div> 
    </div>
</form>

<table class="table">
    <tr>
        <th>Floor</th>
        <th>Room number</th>
        <th>Has Conitioner</th>
        <th>Has TV</th>
        <th>Has Phone</th>
        <th>Available From</th>
        <th>Available From (db format)</th>
        <th>Price per day</th>
        <th>Description</th>
    </tr>
    <?php foreach ($rooms as $room) { ?>
    <tr>
        <td><?= $room['floor'] ?></td>
        <td><?= $room['room_number'] ?></td>
        <td><?= Yii::$app->formatter->asBoolean($room['has_conditioner']) ?></td>
        <td><?= Yii::$app->formatter->asBoolean($room['has_tv']) ?></td>
        <td><?= ($room['has_phone'] == 1) ? 'Yes':'No' ?></td>
        <td><?= Yii::$app->formatter->asDate($room['available_from']) ?></td>
        <td><?= Yii::$app->formatter->asDate($room['available_from'], 'php:Y-m-d') ?></td>
        <td><?= Yii::$app->formatter->asCurrency($room['price_per_day'], 'EUR') ?></td>
        <td><?= $room['description'] ?></td>
    </tr>
    <?php } ?>
</table>