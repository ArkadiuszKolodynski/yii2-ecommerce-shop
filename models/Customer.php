<?php

namespace app\models;

use yii\db\ActiveRecord;

class Customer extends ActiveRecord {
    public static function tableName() {
        return 'customers';
    }
    
    public function rules() {
        return [
            [['first_name', 'last_name', 'address', 'city', 'email', 'zipcode', 'tel', 'username', 'password'], 'required'],
            [['username', 'email'], 'unique']
        ];
    }
}
