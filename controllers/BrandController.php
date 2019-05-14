<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\web\Session;
use yii\web\Controller;
use app\models\Brand;

class BrandController extends Controller {
    public function init() {
        $session = new Session();
        $session->open();
        
        if (empty($session['account_id'])) {
            return $this->redirect(Url::toRoute('/backend/inedx'));
        }
        
        parent::init();
    }
    
    public function actionIndex() {
        $categories = Brand::find()->orderBy('id')->all();
        
        return $this->render('//Brand/Index', [
            'categories' => $categories
        ]);
    }

    public function actionForm() {
        $session = new Session();
        $session->open();

        $brand = new Brand();

        if (!empty($_POST)) {
            if (!empty($_POST['Brand']['id'])) {
                $id = $_POST['Brand']['id'];
                $brand = Brand::findOne($id);
            }

            $brand->code = $_POST['Brand']['code'];
            $brand->name = $_POST['Brand']['name'];
            $brand->remark = $_POST['Brand']['remark'];

            if ($brand->save ()) {
                $session->setFlash ( 'message', 'Saved.' );
                return $this->redirect (['index' ]);
            }
        }

        return $this->render('//Brand/Form', [
            'brand' => $brand,
            'icon' => 'glyphicon glyphicon-plus',
            'title' => 'New Brand'
        ]);
    }
        
    public function actionDelete($id) { 
        $brand = Brand::findOne($id)->delete();
            
        $session = new Session ();
        $session->open();
        $session->setFlash('message', 'Deleted.');
            
        return $this->redirect(['index']);
    }
        
    public function actionEdit($id) {
        $brand = Brand::findOne($id);
            
        return $this->render('//Brand/Form', [
            'brand' => $brand,
            'icon' => 'glyphicon glyphicon-pencil',
            'title' => 'Edit Brand'
        ]);
    }
}
            