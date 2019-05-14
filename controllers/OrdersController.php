<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderDetails;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\Session;

class OrdersController extends Controller {
    public function init() {
        $session = new Session();
        $session->open();
        
        if (empty($session['account_id'])) {
            return $this->redirect(Url::toRoute('/backend/index'));
        }
        
        parent::init();
    }
    
    public function actionIndex() {
        $orders = Order::find()->orderBy('id DESC')->all();
        
        return $this->render('//Orders/Index', [
            'orders' => $orders
        ]);
    }
    
    public function actionDetails($id) {
        $order = Order::findOne($id);
        $orderDetails = OrderDetails::find()
          ->where(['order_id' => $id])
          ->orderBy('id DESC')
          ->all();
          
        return $this->render('//Orders/Details', [
            'order' => $order,
            'orderDetails' => $orderDetails,
            'n' => 1
        ]);
    }

    public function actionPay($id) {
        $order = Order::findOne($id);
        $order->status = 'paid';
        $order->pay_date = new Expression('NOW()');
        $order->save();
        
        return $this->redirect(['index']);
    }
    
    public function actionSend($id) {
        $order = Order::findOne($id);
        $order->status = 'sent';
        $order->send_date = new Expression('NOW()');
        $order->save();
        
        return $this->redirect(['index']);
    }
    
    public function actionCancel($id) {
        $order = Order::findOne($id);
        $order->status = 'canceled';
        $order->send_date = null;
        $order->pay_date = null;
        $order->save();
        
        return $this->redirect(['index']);
    }
}
