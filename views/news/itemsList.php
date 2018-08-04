<?php

    //$newsList is from actionItemsList
?>
<?= $this->context->renderPartial('_copyright'); ?>

<table>
    <tr>
        <th>Title</th>
        <th>Date</th>   
    </tr>
    <?php foreach($newsList as $item) { ?>
        <tr>
            <td>
                <a href="<?= Yii::$app->urlManager->createUrl(['news/item-detail', 'id' => $item['id']]) ?>"><?= $item['title']?></a>
            </td>
            <td>
                <?= Yii::$app->formatter->asDatetime($item['date'], 'php:d/m/Y'); ?>
            </td>
        </tr>
    <?php }?>
</table>