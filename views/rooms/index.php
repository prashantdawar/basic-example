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