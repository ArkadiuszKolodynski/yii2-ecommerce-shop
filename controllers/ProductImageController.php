<?php

namespace app\controllers;

use app\models\ProductImage;
use app\models\Product;
use yii\web\Session;
use yii\web\Controller;

class ProductImageController extends Controller {
    public function init() {
        $session = new Session();
        $session->open();
        
        if (empty($session['account_id' ])) {
            return $this->redirect(Url::toRoute('/backend/index'));
        }
        
        parent::init();
    }
    
    public function actionIndex($product_id) {
        $product = Product::findOne($product_id);
        $productImages = ProductImage::find()
          ->where(['product_id'=>$product_id])
          ->orderBy('id')
          ->all();
          
        return $this->render('//ProductImage/Index', [
            'product' => $product,
            'productImages' => $productImages,
            'n' => 1
        ]);
    }

    public function actionForm($product_id) {
        $product = Product::findOne($product_id);
        $productImage = new ProductImage();
        
        if (!empty($_FILES['ProductImage'])) {
            $img = $_FILES['ProductImage']['name']['url'];
            $temp = explode(".", $img);
            $ext = end($temp);
            $name = microtime();
            $name = str_replace(' ', '', $name);
            $name = str_replace('.', '', $name);
            $name = $name.'.'.$ext;
            $tmp = $_FILES ['ProductImage']['tmp_name']['url'];
            $productImage->url = $name;
            move_uploaded_file($tmp, '../web/uploads/'.$name);
        }
        
        if (!empty($_POST)) {
            $productImage->name = $_POST['ProductImage']['name'];
            $productImage->product_id = $product_id;
            
            if ($productImage->save()) {
                $session = new Session();
                $session->open();
                $session->setFlash('message', 'Data Saved.');
                
                return $this->redirect(['index', 'product_id' => $product_id]);
            }
        }
         
        return $this->render('//ProductImage/Form', [
            'product' => $product,
            'productImage' => $productImage
        ]);
    }

    public function actionDelete($id) {
        $productImage = ProductImage::findOne($id);
        $product = $productImage->product;
        $image_url = $productImage->url;
        
        if ($productImage->delete()) {
            $session = new Session();
            $session->open();
            $session->setFlash('message', 'Data Deleted.' );
            
            unlink('../web/uploads/'.$image_url);
            
            return $this->redirect(['index', 'product_id' => $product->id]);
        }
    }
}
