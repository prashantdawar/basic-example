<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\Room;

class RoomsController extends Controller {

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
}