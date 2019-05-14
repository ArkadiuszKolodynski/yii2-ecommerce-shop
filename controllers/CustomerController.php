<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\web\Session;
use yii\web\Controller;
use app\models\Customer;
use yii\data\Pagination;

class CustomerController extends Controller {
    public function init() {
        $session = new Session();
        $session->open();
        
        if (empty($session['account_id'])) {
            
            return $this->redirect(Url::toRoute('/backend/index'));
        }
        
        parent::init();
    }
    
    public function actionIndex() {
        $totalCount = Customer::find()->count();
        $pages = new Pagination([
            'totalCount' => $totalCount,
            'pageSize' => 10
        ]);
        $customers = Customer::find()
          ->offset($pages->offset)
          ->limit($pages->limit)
          ->orderBy('id')
          ->all();
          
        return $this->render('//Customer/Index', [
            'customers' => $customers,
            'pages' => $pages
        ]);
    }
}
