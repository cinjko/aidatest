<?php

namespace frontend\controllers;


use yii\base\Exception;
use yii\base\Model;
use yii\web\Controller;
use yii\db\Transaction;
use yii\web\Session;

use frontend\models\UserCard;
use frontend\models\UserTransaction;

class CardController extends Controller
{
    protected $send_sum;
    protected $receiver_card_number;

    public function actionTransaction()
    {
        $model = new UserCard();
        $session = new Session;
        $session->open();
        $_csrf = \Yii::$app->request->post('_csrf');
        if ($session->isActive) {
            echo '___';
            if ($session['_csrf'] == $_csrf) {
                return $this->goHome();
            }
        }
        $session['_csrf'] = \Yii::$app->request->post('_csrf');


        $model->load(\Yii::$app->request->post());
        $this->send_sum = \Yii::$app->request->post('sum');
        $this->receiver_card_number = \Yii::$app->request->post('receiver_card_number');
        if ($model->validate()) {
            $connection = \Yii::$app->db;
            $isolationLevel = Transaction::READ_COMMITTED;
            $transaction = $connection->beginTransaction($isolationLevel);

            try {
                $sender_data = $this->checkUserCardData($model->card_number);
                if (!$sender_data ||
                    $sender_data->expiration_date != \Yii::$app->formatter->asTimestamp($model->expiration_date) ||
                    $sender_data->cv2 != \Yii::$app->formatter->asInteger($model->cv2)) {
                    throw new Exception('Wrong card data.');
                }
                if ($sender_data->card_amount < $this->send_sum) {
                    throw new Exception('Insufficient funds.');
                }
                $receiver_data = $this->checkUserCardData($this->receiver_card_number);
                if (!$receiver_data) {
                    throw new Exception('Wrong receiver data!');
                }
                $receiver_data->card_amount = $receiver_data->card_amount + $this->send_sum;
                $sender_data->card_amount = $sender_data->card_amount - $this->send_sum;
                if (!$receiver_data->save() || !$sender_data->save()) {
                    throw new Exception('Transaction fail!');
                }
                $user_transaction = new UserTransaction();
                $user_transaction->sender_id            = $sender_data->user_id;
                $user_transaction->receiver_id          = $receiver_data->user_id;
                $user_transaction->card_number_sender   = $sender_data->card_number;
                $user_transaction->card_number_receiver = $receiver_data->card_number;
                $user_transaction->sum                  = $this->send_sum;
                if (!$user_transaction->save()) {
                    throw new Exception('Can\'t save transaction history!');
                }
                $transaction->commit();
                $user_transactions = $user_transaction->find()->where(['sender_id' => $sender_data->id])->all();
//                var_dump($user_transactions);die;
                return $this->render('transactionSuccess', [
                    'user_transactions' => $user_transactions
                ]);
            } catch (Exception $e) {
                echo $e;
            }
        }
    }

    protected function checkUserCardData($card_number)
    {
        $card_data = UserCard::find()->where(['card_number' => $card_number])->one();
        if (!$card_data) {
            return false;
        }
        return $card_data;
    }
}