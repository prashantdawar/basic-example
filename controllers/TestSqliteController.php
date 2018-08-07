<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Room;

class TestSqliteController extends Controller {

    /**
     * Action for creating room table in sqlite
     */
    public function actionCreateRoomTable(){

        //create room table sqlite
        $sql = 'CREATE TABLE IF NOT EXISTS room (
                    id int not null,
                    floor int not null,
                    room_number int not null,
                    has_conditioner int not null,
                    has_tv int not null,
                    has_phone int not null,
                    available_from date not null,
                    price_per_day float,
                    description text
                )';
        
        \Yii::$app->dbSqlite->createCommand($sql)->execute();
        echo 'Room table created in dbSqlite';
    }

    /**
     * 
     * Action for creating backup of room table from mysql to sqlite
     */
    public function actionBackupRoomTable() {

        //create room table sqlite
        $sql = 'CREATE TABLE IF NOT EXISTS room (
            id int not null,
            floor int not null,
            room_number int not null,
            has_conditioner int not null,
            has_tv int not null,
            has_phone int not null,
            available_from date not null,
            price_per_day float,
            description text
        )';

        \Yii::$app->dbSqlite->createCommand($sql)->execute();

        //Truncate room table in dbSqlite
        $sql = 'DELETE FROM room';
        \Yii::$app->dbSqlite->createCommand($sql)->execute();

        //Load records from mysql and insert to sqlite
        $models = Room::find()->all();

        foreach ($models as $m) {
            
            \Yii::$app->dbSqlite->createCommand()->insert('room', $m->attributes)->execute();
        }

        // Load all records from dbSqlite
        $sql = 'SELECT * FROM room';
        $sqliteModels = \Yii::$app->dbSqlite->createCommand($sql)->queryAll();

        return $this->render('backupRoomTable', [
            'sqliteModels' => $sqliteModels
        ]);
    }
}