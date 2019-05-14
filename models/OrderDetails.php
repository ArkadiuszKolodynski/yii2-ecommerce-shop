<?php

namespace app\models;

use app\models\Product;
use yii\db\ActiveRecord;

class OrderDetails extends ActiveRecord {
    public static function tableName() {
        return 'order_details';
    }

    public function getProduct()  {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getOrder() {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
