<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Order;
use app\models\OrderDetails;
use app\models\Brand;
use app\models\Category;
use app\models\Company;
use app\models\Customer;
use app\models\Product;
use app\models\ProductImage;
use yii\data\Pagination;
use yii\db\Expression;
use yii\web\Session;
use OpenPayU_Configuration;
use OpenPayU_Order;

require_once Yii::$app->basePath . '/config/config.php';

class ShopController extends Controller {
    public $layout = 'frontend';
    
    public function actionIndex($sort = 'box', $wrongPassword = 'false') {
        $totalCount = Product::find();
        
        if (!empty($_GET['search'])) {
            $search = '%'.$_GET['search'].'%';
            
            $totalCount = $totalCount->where('name LIKE(:search)', [
                ':search' => $search
            ]);
        }

        if (!empty($_GET['brand'])) {
            $brand = $_GET['brand'];
            
            $totalCount = $totalCount->where(['brand_id' => $brand]);
        }

        if (!empty($_GET['category'])) {
            $category = $_GET['category'];
            
            $totalCount = $totalCount->where(['category_id' => $category]);
        }

        if (!empty($_GET['brand']) && !empty($_GET['category'])) {
            $brand = $_GET['brand'];
            $category = $_GET['category'];
            
            $totalCount = $totalCount->where(['brand_id' => $brand, 'category_id' => $category]);
        }
        
        $totalCount = $totalCount->count();
        
        $pagination = new Pagination([
            'totalCount' => $totalCount,
            'pageSize' => 9
        ]);
        
        $products = Product::find()
            ->orderBy('RAND()')
            ->offset($pagination->offset)
            ->limit($pagination->limit); 
            
        if (!empty($_GET['search'])) {
            $search = '%'.$_GET['search'].'%';
            
            $products = $products->where('name LIKE(:search)', [
                ':search' => $search
            ]);
        }

        if (!empty($_GET['brand'])) {
            $brand = $_GET['brand'];
            
            $products = $products->where(['brand_id' => $brand]);
        }

        if (!empty($_GET['category'])) {
            $category = $_GET['category'];
            
            $products = $products->where(['category_id' => $category]);
        }

        if (!empty($_GET['brand']) && !empty($_GET['category'])) {
            $brand = $_GET['brand'];
            $category = $_GET['category'];
            
            $products = $products->where(['brand_id' => $brand, 'category_id' => $category]);
        }

        return $this->render('//Frontend/Index', [
            'brand' => null,
            'category' => null,
            'products' => $products->all(),
            'pagination' => $pagination,
            'sort' => $sort,
            'totalCount' => $totalCount,
            'wrongPassword' => $wrongPassword
        ]);
    }

    public function actionProductview($id) {
        $product = Product::findOne($id);
        $productImages = ProductImage::find()
          ->where(['product_id' => $id])
          ->orderBy('id')
          ->all();
          
        return $this->render('//Frontend/ProductView', [
            'product' => $product,
            'productImages' => $productImages
        ]);
    }

    public function actionRegister() {
        $customer = new Customer();
        
        if (!empty($_POST)) {
            $customer->username = $_POST['Customer']['username'];
            $customer->password = \Yii::$app->getSecurity()->generatePasswordHash($_POST['Customer']['password']);
            $customer->email = $_POST['Customer']['email'];
            $customer->first_name = $_POST['Customer']['first_name'];
            $customer->last_name = $_POST['Customer']['last_name'];
            $customer->address = $_POST['Customer']['address'];
            $customer->city = $_POST['Customer']['city'];
            $customer->zipcode = $_POST['Customer']['zipcode'];
            $customer->tel = $_POST['Customer']['tel'];
            
            if ($customer->save()) {
                $session = new Session();
                $session->open();
                $session->setFlash('message', 'Register Success.');
                
                return $this->redirect(['registersuccess']);
            }
        }
        
        return $this->render('//Frontend/Register', [
            'customer' => $customer
        ]);
    }
        
    public function actionRegistersuccess() {
        return $this->render('//Frontend/RegisterSuccess');
    }

    public function actionLogin() {
        if (!empty($_POST)) {
            $username = $_POST['username'];
            $password = $_POST ['password'];

            if (empty($username) || empty($password)) {
                return $this->redirect(['index?wrongPassword=true']);
            }
               
            $customer = Customer::find()->where([
                'username' => $username
            ])->one();
                
            if (!empty($customer) && \Yii::$app->getSecurity()->validatePassword($password, $customer->password)) {
                $session = new Session();
                $session->open();
                $session->set('customer_id', $customer->id);
                $session->set('customer_name', $customer->first_name.' '.$customer->last_name);
                    
                return $this->redirect(['loginsuccess']);
            } else {
                return $this->redirect(['index?wrongPassword=true']);
            }
        }
    }
       
    public function actionLoginsuccess() {
        return $this->render('//Frontend/LoginSuccess');
    }

    public function actionProfile() {
        $session = new Session();
        $session->open();
        $id = $session->get('customer_id');
            
        $customer = Customer::findOne($id);
            
        if (!empty($_POST)) {
            $customer->username = $_POST['Customer']['username'];
            $customer->password = \Yii::$app->getSecurity()->generatePasswordHash($_POST['Customer']['password']);
            $customer->email = $_POST['Customer']['email'];
            $customer->first_name = $_POST['Customer']['first_name'];
            $customer->last_name = $_POST['Customer']['last_name'];
            $customer->address = $_POST['Customer']['address'];
            $customer->city = $_POST['Customer']['city'];
            $customer->zipcode = $_POST['Customer']['zipcode'];
            $customer->tel = $_POST['Customer']['tel'];
                
            if ($customer->save()) {
                $session->setFlash('message', 'Update customer info success.');
                return $this->redirect(['profile']);
            }
        }
            
        return $this->render('//Frontend/Profile', [
            'customer' => $customer
        ]);
    }

    public function actionLogout() {
        $session = new Session();
        $session->open();
        $session->set('customer_id', null);
        $session->set('customer_name', null);
        $session->set('cart', null);
        
        return $this->redirect(['index']);
    }

    public function actionCart($id = null) {
        $product = Product::findOne($id);
        $session = new Session();
        $session->open();
        $cart = [];
        
        if (!empty($session->get('cart'))) {
            $cart = $session->get('cart');
        }
        
        if (!empty($_POST)) {
            $data = [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $_POST['qty']
            ];

            if (!empty($cart)) {
                $exist = false;
                foreach($cart as &$c) {
                    if ($c['id'] === $product->id) {
                        $c['qty'] += $_POST['qty'];
                        $exist = true;
                        break;
                    }
                }
                if (!$exist) {
                    $cart[count($cart)] = $data;
                }
            } else {
                $cart[count($cart)] = $data;   
            }
            $session->set('cart', $cart);
        }

        return $this->render('//Frontend/Cart', [
            'product' => $product,
            'cart' => $cart,
            'n' => 1,
            'sumQty' => 0,
            'sumPrice' => 0
        ]);
    }

    public function actionCartremove($index, $id = null) {
        $session = new Session();
        $session->open();
        
        $cart = $session['cart'];
        
        if (count($cart) > 0) {
            $cart[$index] = null;
            $newCart = [];
            
            foreach ($cart as $c) {
                if ($c != null) {
                    $newCart[] = $c;
                }
            }
            
            $session->set('cart', $newCart);
            
            return $this->redirect(['cart', 'id' => $id]);
        }
    }

    public function actionCheckout() {
        $session = new Session();
        $session->open();
        $cart = $session->get('cart');
        $order = new Order();
        $customer = Customer::findOne($session->get('customer_id'));
        
        if (!empty($_POST)) {
            // save order
            $order->customer_id = $session->get('customer_id');
            $order->created_at = new Expression('NOW()');
            $order->status = 'waiting';
            $order->email = $_POST['Order']['email'];
            $order->first_name = $_POST['Order']['first_name'];
            $order->last_name = $_POST['Order']['last_name'];
            $order->address = $_POST['Order']['address'];
            $order->city = $_POST['Order']['city'];
            $order->zipcode = $_POST['Order']['zipcode'];
            $order->tel = $_POST['Order']['tel'];
            
            if ($order->save()) {
                // loop read data from session to database
                foreach ($cart as $c) {
                    $orderDetails = new OrderDetails();
                    $orderDetails->order_id = $order->id;
                    $orderDetails->product_id = $c['id'];
                    $orderDetails->price = $c['price'];
                    $orderDetails->qty = $c['qty'];
                    $orderDetails->save();
                }
                
                // clear session
                $session-> set('cart', null);
                
                return $this->redirect(['checkoutsuccess', 'id' => $order->id]);
            }
        }
        
        return $this->render('//Frontend/Checkout', [
            'n' => 1,
            'cart' => $cart,
            'sumQty' => 0,
            'sumPrice' => 0,
            'order' => $order,
            'customer' => $customer
        ]);
    }

    public function actionCheckoutsuccess($id) {
        $order = Order::findOne($id);
        $orderDetails = OrderDetails::find()->where(['order_id' => $id])->all();

        $orderp = array();
        $totalAmount = 0;
        $i = 0;
        foreach ($orderDetails as $orderDetail) {          
            $orderp['products'][$i]['name'] = strval($orderDetail->product_id);
            $orderp['products'][$i]['unitPrice'] = floatval($orderDetail->price);
            $orderp['products'][$i]['quantity'] = $orderDetail->qty;
            $totalAmount += floatval($orderDetail->price) * $orderDetail->qty;
            $i++;
        }

        $totalAmount *= 100;

        $orderp['continueUrl'] = 'http://localhost:8080/shop/paymentstatus?id='.$id; //customer will be redirected to this page after successfull payment
        $orderp['notifyUrl'] = 'http://localhost:8080/';
        $orderp['customerIp'] = $_SERVER['REMOTE_ADDR'];
        $orderp['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
        $orderp['description'] = 'New order';
        $orderp['currencyCode'] = 'PLN';
        $orderp['totalAmount'] = $totalAmount;
        $orderp['extOrderId'] = $order->id; //must be unique!
        
        //optional section buyer
        $orderp['buyer']['email'] = $order->email;
        $orderp['buyer']['phone'] = $order->tel;
        $orderp['buyer']['firstName'] = $order->first_name;
        $orderp['buyer']['lastName'] = $order->last_name;
        $response = OpenPayU_Order::create($orderp);
        $response = $response->getResponse();
        $uri = $response->redirectUri;

        Yii::$app->mailer->compose()
            ->setFrom('orders@ecommerce.io')
            ->setTo($order->email)
            ->setSubject('[Ecommerce] Order number '.$id)
            ->setHtmlBody('<strong>Order ID: '.$id.'</strong><br><a href="'.$uri.'">Click here to make a payment</a>')
            ->send();
        return $this->render('//Frontend/CheckoutSuccess', ['id' => $id, 'uri' => $uri]);
    }

    public function actionPaymentstatus($id, $error = null) {
        $order = Order::findOne($id);
        if ($error === null) {
            $order->pay_date = new Expression('NOW()');
            $order->status = 'paid';
            $order->save();
            return $this->render('//Frontend/PaymentStatus', ['id' => $id, 'error' => false]);
        } else {
            $order->status = 'canceled';
            $order->save();
            return $this->render('//Frontend/PaymentStatus', ['id' => $id, 'error' => true]);
        }
    }

    public function actionHistory() {
        $session = new Session();
        $session->open();
        
        $orders = Order::find()
          ->where(['customer_id' => $session->get('customer_id')])
          ->orderBy('id DESC')
          ->all();
          
        return $this->render('//Frontend/History', [
            'orders' => $orders,
            'n' => 1,
            'sumQty' => 0,
            'sumPrice' => 0
        ]);
    }

    public function actionAbout() {
        $company = Company::find()->one();
        return $this->render('//Frontend/About', [
            'company' => $company
        ]);
    }

    public function actionPayment() {
        $company = Company::find()->one();
        return $this->render('//Frontend/Payment', [
            'company' => $company
        ]);
    }

    public function actionCategories($id = null, $sort = 'box') {
        $categories = Category::find()->orderBy('name')->all();
        if ($id === null) {
            return $this->render('//Frontend/Categories', ['categories' => $categories]);
        } else {
            $category = Category::findOne($id);
            
            if ($category !== null) {
                $products = Product::find()
                    ->where(['category_id' => $category->id]);
                $totalCount = $products->count();

                $pagination = new Pagination([
                    'totalCount' => $totalCount,
                    'pageSize' => 9
                ]);
                    
                $products = Product::find()
                    ->where(['category_id' => $category->id])
                    ->orderBy('id DESC')
                    ->offset($pagination->offset)
                    ->limit($pagination->limit);
                

                return $this->render('//Frontend/Index', [
                    'brand' => null,
                    'category' => $category,
                    'products' => $products->all(),
                    'pagination' => $pagination,
                    'sort' => $sort,
                    'totalCount' => $totalCount,
                    'wrongPassword' => false
                ]);
            }
        }
        return $this->redirect(['index']);
    }

    public function actionBrands($id = null, $sort = 'box') {
        $brands = Brand::find()->orderBy('name')->all();
        if ($id === null) {
            return $this->render('//Frontend/Brands', ['brands' => $brands]);
        } else {
            $brand = Brand::findOne($id);
            
            if ($brand !== null) {
                $products = Product::find()
                    ->where(['brand_id' => $brand->id]);
                $totalCount = $products->count();

                $pagination = new Pagination([
                    'totalCount' => $totalCount,
                    'pageSize' => 9
                ]);
                    
                $products = Product::find()
                    ->where(['brand_id' => $brand->id])
                    ->orderBy('id DESC')
                    ->offset($pagination->offset)
                    ->limit($pagination->limit);
                

                return $this->render('//Frontend/Index', [
                    'brand' => $brand,
                    'category' => null,
                    'products' => $products->all(),
                    'pagination' => $pagination,
                    'sort' => $sort,
                    'totalCount' => $totalCount,
                    'wrongPassword' => false
                ]);
            }
        }
        return $this->redirect(['index']);
    }
}
