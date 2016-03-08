<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "user_transaction".
 *
 * @property integer $id
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property integer $card_number_sender
 * @property integer $card_number_receiver
 * @property double $sum
 * @property string $datetime
 *
 * @property User $receiver
 * @property User $sender
 */
class UserTransaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender_id', 'receiver_id', 'card_number_sender', 'card_number_receiver', 'sum'], 'required'],
            [['sender_id', 'receiver_id'], 'integer'],
            [['sum'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'card_number_sender' => 'Card Number Sender',
            'card_number_receiver' => 'Card Number Receiver',
            'sum' => 'Sum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(User::className(), ['id' => 'receiver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }
}
