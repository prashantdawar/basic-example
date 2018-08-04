<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class NewsController extends Controller {

    public function dataItems() {
        
        $newsList = [
            [ "id" => 1, "date" => "2015-04-19", "category" => "business","title" => "Test news of 2015-04-19" ],
            [ "id" => 2, "date" => "2015-05-20", "category" => "shopping","title" => "Test news of 2015-05-20" ],
            [ "id" => 3, "date" => "2015-06-21", "category" => "business","title" => "Test news of 2015-06-21" ],
            [ "id" => 4, "date" => "2016-04-19", "category" => "shopping","title" => "Test news of 2016-04-19" ],
            [ "id" => 5, "date" => "2017-05-19", "category" => "business","title" => "Test news of 2017-05-19" ],
            [ "id" => 6, "date" => "2018-06-19", "category" => "shopping","title" => "Test news of 2018-06-19" ]         
        ];

        return $newsList;
    }

    /**
     * main news controller index page
     */
    public function actionIndex(){
        
        return $this->render('index');
    }

    /**
     * Action list items in table format
     */

    public function actionItemsList() {

        $year = Yii::$app->request->get('year');
        $category = Yii::$app->request->get('category');
        
        $newsList = $this->dataItems();
        $filteredData = [];

        foreach ($newsList as $n) {
            if(($year != null) && (date('Y', strtotime($n['date'])) == $year)) 
                $filteredData[] = $n;
            if(($category != null) && ($n['category'] == $category))
                $filteredData[] = $n;
        }

        return $this->render('itemsList', [
            'year' => $year,
            'category' => $category,
            'filteredData' => $filteredData
        ]);
    }

    /**
     * Action lists cliclked item detail
     */

    public function actionItemDetail() {

        $title = Yii::$app->request->get('title');
        $newsList = $this->dataItems();
        $itemFound = null;

        foreach ($newsList as $n) {
            if($n['title'] == $title) $itemFound = $n;
        }

        return $this->render('itemDetail',[
            'title' => $title,
            'itemFound' => $itemFound 
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

       /**
        * Action for internation index

        */

        public function actionInternationalIndex() {
            
            $lang = Yii::$app->request->get('lang', 'en');
            Yii::$app->language = $lang;

            return $this->render('internationalIndex');
        }
}