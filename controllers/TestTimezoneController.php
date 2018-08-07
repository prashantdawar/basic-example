<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class TestTimezoneController extends Controller {

    public function actionCheck() {

        $dt = new \DateTime();
        echo 'Current date and time: ' . $dt->format('Y-m-d H:i:s');
        echo '<br/>';
        echo 'Current timezone: ' .$dt->getTimezone()->getName();
        echo '<br />';
    }

    public function actionCheckDatabase() {

        $result = \Yii::$app->db->createCommand('SELECT NOW()')->queryColumn();
        echo 'Database current date and time : ' .$result[0];

    }
}