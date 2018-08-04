Detail item with title <b><?= $title ?></b>
<br><br>
<?php if($itemFound !=null) {?>
    <table border="1">
        <?php foreach ($itemFound as $key => $value) { ?>
            <tr>
                <th><?= $key ?></th>
                <td><?= $value ?></td>
            </tr>  
        <?php }?>
    </table>
    <br>
    Url for this item is: <?= yii\helpers\Url::to(['news/item-detail', 'title' => $title]); ?>
<?php } else { ?>
    <i>No item found</i>
<?php } ?>