<?php

namespace app\models;

use yii\db\ActiveRecord;

class Product extends ActiveRecord
{

    public function rules()
    {
        return [
            [['sku', 'title', 'qty'], 'required'],
            [['sku', 'title', 'type'], 'string'],
            [['qty'], 'integer'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 1],
        ];
    }

    public function uploadImage($timestamp)
    {
        $this
            ->image
            ->saveAs(\Yii::getAlias('@productImagesPath').'/'.$timestamp.'_'.$this->image->baseName.'.'.$this->image->extension);
    }

}