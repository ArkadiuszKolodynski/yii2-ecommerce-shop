<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Session;

class BackendController extends Controller {
    public function actionIndex() {
        $account = new \app\models\Account();

        if (!empty($_POST)) {
            if (empty($_POST['Account']['username']) || empty($_POST['Account']['password'])) {
                return $this->redirect(['index']);
            }

            $account = \app\models\Account::find()
              ->where('username = :username', [
                ':username' => $_POST['Account']['username']
              ])
              ->one();
            
            if (!empty($account) && \Yii::$app->getSecurity()->validatePassword($_POST['Account']['password'], $account->password)) {
                $session = new \yii\web\Session();
                $session->open();
                $session->set('account_id', $account->id);
                $session->set('account_username', $account->username);

                return $this->redirect(['home']);
            } else {
                $account = new \app\models\Account();
                $account->username = $_POST['Account']['username'];
                $account->password = $_POST['Account']['password'];
                $wrongPassword = true;
            }
        }
        return $this->render('//Backend/Index', ['account' => $account]);
    }

    public function actionHome() {
        $session = new \yii\web\Session();
        $session->open();

        if ($session['account_id'] === null) {
            return $this->redirect(['index']);
        }
        return $this->render('//Backend/Home');
    }

    public function actionLogout() {
        $session = new \yii\web\Session();
        $session->open();
        unset($session['account_id']);
        unset($session['account_username']);

        return $this->redirect(Url::toRoute('/backend/index'));
    }
}