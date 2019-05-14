<?php

namespace app\models;

use yii\db\ActiveRecord;

class Brand extends ActiveRecord {
    public static function tableName() {
        return 'brands';
    }

    public function rules() {
        return [
            [['code', 'name'], 'required'],
            [['code', 'name'], 'unique']
        ];
    }
}