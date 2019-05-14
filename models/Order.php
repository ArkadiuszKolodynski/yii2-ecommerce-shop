<?php

namespace app\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord {
    public static function tableName() {
        return 'orders';
    }
    
    public function rules() {
        return [
            [['first_name', 'last_name', 'email', 'city', 'zipcode', 'tel', 'address'], 'required']
        ];
    }
}
