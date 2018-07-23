<?php

namespace app\models\brand;

use Yii;

/**
 * This is the model class for table "brand_images".
 *
 * @property int $id
 * @property string $image_key 图片地址
 * @property string $create_time 插入时间
 */
class BrandImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time'], 'safe'],
            [['image_key'], 'string', 'max' => 200],
            [['image_key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_key' => 'Image Key',
            'create_time' => 'Create Time',
        ];
    }
}
