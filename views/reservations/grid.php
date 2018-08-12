<?php
 
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Room;

?>

<h2>Reservations</h2>

<?php
//passed to controller
    // $sumOfPricesPerDay = 0;
    // $averagePricePerDay = 0;

    // if(count($dataProvider->getModels()) >= 0){
    //     foreach ($dataProvider->getModels() as $m) {
    //         $sumOfPricesPerDay += $m->price_per_day;            
    //     }

    //     $averagePricePerDay = $sumOfPricesPerDay / sizeof($dataProvider->getModels());
    // }
?>


<?php
 $roomFilterData = ArrayHelper::map(
                       Room::find()->all(),
                       'id',
                       function($model, $defaultValue) {
                           return sprintf('Floor: %d - Number: %d', $model->floor, $model->room_number);
                    });
?>

<?= \app\components\GridViewReservation::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
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
            [
                'attribute' => 'price_per_day',
                'footer' => sprintf('Average: %0.2f', $resultQueryAveragePricePerDay)
            ],
            'date_from',
            'date_to',            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'header' => 'Actions'
            ]
        ]
]); ?>