<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "user_card".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $card_number
 * @property integer $cv2
 * @property string $expiration_date
 * @property string $card_holder_number
 * @property string $card_amount
 *
 * @property User $user
 */
class UserCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_number', 'cv2', 'expiration_date'], 'required'],
            [['user_id', 'card_number', 'cv2'], 'integer'],
            [['expiration_date'], 'safe'],
            [['card_amount'], 'number'],
            [['card_holder_number'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'card_number' => 'Card Number',
            'cv2' => 'Cv2',
            'expiration_date' => 'Expiration Date',
            'card_holder_number' => 'Card Holder Number',
            'card_amount' => 'Card Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
