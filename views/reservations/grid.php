<?php
 
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Room;

 $roomFilterData = ArrayHelper::map(
                       Room::find()->all(),
                       'id',
                       function($model, $defaultValue) {
                           return sprintf('Floor: %d - Number: %d', $model->floor, $model->room_number);
                    });
?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'header' => 'Room',
                'filter' => Html::activeDropDownList(
                                $searchModel,
                                'room_id',
                                $roomFilterData,
                                [
                                    'prompt' => '--- all'
                                ]),
                'content' => function($model) {
                    return $model->room->floor;
                }
            ],
            [
                'header' => 'Customer',
                'attribute' => 'customer.surname'
            ],
            'price_per_day',
            'date_from',
            'date_to',            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'header' => 'Actions'
            ]
        ]
]); ?>