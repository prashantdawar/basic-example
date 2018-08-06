<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\Room;

class RoomsController extends Controller {

    /**
     * Action for creating new room data
     */

    public function actionCreate() {

        $model = new Room();
        $modelCanSave = false;

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');

            if($model->fileImage) {
                $model->fileImage->saveAs(Yii::getAlias('@uploadedfilesdir/' . $model->fileImage->baseName . '.'. $model->fileImage->extension));
            }

            $modelCanSave = true;
        }

        return $this->render('create', [
            'model' => $model,
            'modelCanSave' => $modelCanSave
        ]);
    }

    /**
     * Action for displaying stored room data from db
     * 
     */

     public function actionIndex() {
    
        $sql = 'SELECT * FROM room ORDER BY id ASC';

        $db = Yii::$app->db;

        $rooms = $db->createCommand($sql)->queryAll();

        return $this->render('index', [
            'rooms' => $rooms
        ]);
     }

     /**
      *  Action for index search filter
      */
      public function actionIndexFiltered(){

        $query = Room::find();

        $searchFilter = [
            'floor' => ['operator' => '', 'value' => ''],
            'room_number' => ['operator' => '', 'value' => ''],
            'price_per_day' => ['operator' => '', 'value' => '']
        ];

        if(isset($_POST['SearchFilter'])) {
            $fieldsList =  ['floor', 'room_number', 'price_per_day'];

            foreach($fieldsList as $field) {
                $fieldOperator = $_POST['SearchFilter'][$field]['operator'];
                $fieldValue = $_POST['SearchFilter'][$field]['value'];

                $searchFilter[$field] = ['operator' => $fieldOperator, 'value' => $fieldValue];

                if($fieldValue != ''){
                    $query->andWhere([$fieldOperator, $field, $fieldValue]);
                }
            }
        }

        $rooms = $query->all();

        return $this->render('indexFiltered', [
            'rooms' => $rooms,
            'searchFilter' => $searchFilter
        ]);
      }
}