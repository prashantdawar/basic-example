<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Reservation;
use app\models\Room;
use app\models\ReservationSearch;
use yii\data\ActiveDataProvider;

class ReservationsController extends Controller {

    public function actionGrid(){
        $query = Reservation::find();

        $searchModel = new ReservationSearch();

        if(isset($_GET['ReservationSearch'])){

            $searchModel->load(\Yii::$app->request->get());

            $query->joinWith(['customer']);
            $query->andFilterWhere([
                'LIKE',
                'customer.surname',
                $searchModel->getAttribute('customer.surname')
            ]);

            $query->andFilterWhere([
                'id' => $searchModel->id,
                'customer_id' => $searchModel->customer_id,
                'room_id' => $searchModel->room_id,
                'price_per_day' => $searchModel->price_per_day
                // 'customer_id' => isset($_GET['Reservation']['customer_id']) ? $_GET['Reservation']['customer_id'] : null
            ]);
        }

        // passed from `grid` view
        $resultQueryAveragePricePerDay = $query->average('price_per_day');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $this->render('grid',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'resultQueryAveragePricePerDay' => $resultQueryAveragePricePerDay
        ]);
    }

    /**
     * Action for displaying reservationa and rooms grid in same page
     * completely independent from each other
     */

     public function actionMultipleGrid(){

        /**
         * Reservations
         */

         $reservationsQuery = Reservation::find();
         $reservationsSearchModel = new ReservationSearch();

         if(isset($_GET['ReservationSearch'])) {

            $reservationsSearchModel->load(\Yii::$app->request->get());

            $reservationsQuery->joinWith(['customer']);
            $reservationsQuery->andFilterWhere([
                'LIKE',
                'customer.surname',
                $reservationsSearchModel->getAttribute('customer.surname')
            ]);

            $reservationsQuery->andFilterWhere([
                'id' => $reservationsSearchModel->id,
                'customer_id' => $reservationsSearchModel->customer_id,
                'room_id' => $reservationsSearchModel->room_id,
                'price_per_day' => $reservationsSearchModel->price_per_day
            ]);
         }

         $reservationsDataProvider = new ActiveDataProvider([
                'query' => $reservationsQuery,
                'sort' => [
                    'sortParam' => 'reservations-sort-param'
                ],
                'pagination' => [
                    'pageSize' => 10,
                    'pageParam' => 'reservations-page-param'
                ]
         ]);

         /**
          * Rooms
          */

          $roomsQuery = Room::find();
          $roomsSearchModel = new Room();

          if(isset($_GET['Room'])){

            $roomsSearchModel->load(\Yii::$app->request->get());

            $roomsQuery->andFilterWhere([
                'id' => $roomsSearchModel->id,
                'floor' => $roomsSearchModel->floor,
                'room_number' => $roomsSearchModel->room_number,
                'has_conditioner' => $roomsSearchModel->has_conditioner,
                'has_phone' => $roomsSearchModel->has_phone,
                'has_tv' => $roomsSearchModel->has_tv,
                'available_from' => $roomsSearchModel->available_from
            ]);
          }

          $roomsDataProvider = new ActiveDataPRovider([
                'query' => $roomsQuery,
                'sort' => [
                    'sortParam' => 'rooms-sort-param'
                ],
                'pagination' => [
                    'pageSize' => 10,
                    'pageParam' => 'rooms-page-param'
                ]
          ]);

          return $this->render('multipleGrid', [
            'reservationsDataProvider' => $reservationsDataProvider,
            'reservationsSearchModel' => $reservationsSearchModel,
            'roomsDataProvider' => $roomsDataProvider,
            'roomsSearchModel' => $roomsSearchModel
          ]);
     }

     public function actionDetailDependentDropdown() {

        $showDetail = false;

        $model = new Reservation();

        if(isset($_POST['Reservation'])) {

            $model->load(Yii::$app->request->post());

            if(isset($_POST['Reservation']['id']) && ($_POST['Reservation']['id'] != null)) {
                $model = Reservation::findOne($_POST['Reservation']['id']);
                $showDetail = true;
            }
        }

        return $this->render('detailDependentDropdown', [
            'model' => $model,
            'showDetail' => $showDetail
        ]);
     }

     public function actionAjaxDropDownListByCustomerId($customer_id) {

        $output = '';

        $items = Reservation::findAll(['customer_id' => $customer_id]);

        foreach($items as $item) {
            $content = sprintf('reservation #%s at %s', $item->id, date('Y-m-d H:i:s', strtotime($item->reservation_date)));
            $output = \yii\helpers\Html::tag('option', $content, ['value' => $item->id]);
        }

        return $output;
     }

     public function actionCreateCustomerAndReservation(){

        $customer = new \app\models\Customer();
        $reservation = new \app\models\Reservation();

        
        // $reservation->customer_id = 0;

        if(
            $customer->load(Yii::$app->request->post())
            &&
            $reservation->load(Yii::$app->request->post())
            &&
            $customer->validate()
        ) {
            $dbTrans = Yii::$app->db->beginTransaction();

            $customerSaved = $customer->save();
            // var_dump($customer);
            // echo "hi"; die;
        //    echo $customer->id; die;
            if($customerSaved) {
                $reservation->customer_id = $customer->id;
                $reservationSaved = $reservation->save();

                if($reservationSaved){
                    $dbTrans->commit();
                } else {
                    $dbTrans->rollBack();
                }
            } else {
                $dbTrans->rollback();
            }
        }

        return $this->render('createCustomerAndReservation',[
            'customer' => $customer,
            'reservation' => $reservation
        ]);
     }
}