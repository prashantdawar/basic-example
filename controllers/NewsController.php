<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class NewsController extends Controller {

    public function dataItems() {
        
        $newsList = [
            ['id' => 1, 'title' => 'First World War', 'date' => '1914-07-28'],
            ['id' => 2, 'title' => 'Second World War', 'date' => '1919-09-01'],
            ['id' => 3, 'title' => 'Third World War', 'date' => '1969-07-20']
        ];

        return $newsList;
    }

    /**
     * main news controller index page
     */
    public function actionIndex(){
        
        echo "this is my first controller";
    }

    /**
     * Action list items in table format
     */

    public function actionItemsList() {
        
        $newsList = $this->dataItems();

        return $this->render('itemsList', [
            'newsList' => $newsList
        ]);
    }

    /**
     * Action lists cliclked item detail
     */

    public function actionItemDetail($id) {

        $newsList = $this->dataItems();

        $item = null;
        foreach ($newsList as $n) {
            if($id == $n['id']) $item = $n;
        }
        
        return $this->render('itemDetail',[
            'item' => $item
        ]);
    }

    /**
     * Action gives static info
     */

     public function actions(){
         return [
            'static' => [
                'class' => 'yii\web\ViewAction',
                'viewPrefix' => 'static'
            ]
         ];
     }
     
     /**
      * Action for test advertisement
      */

      public function actionAdvTest(){
          
        return $this->render('advTest');
      }

      /**
       * Action for responsive and non-responsive content
       * 
       */

       public function actionResponsiveContentTest() {

            $responsive = Yii::$app->request->get('responsive', 0);

            $this->layout = $responsive ? 'responsive' : 'main';

            return $this->render('responsiveContentTest',[
                'responsive' => $responsive
            ]);
       }
}