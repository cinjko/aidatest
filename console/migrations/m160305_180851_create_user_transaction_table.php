<?php

use yii\db\Migration;
use yii\db\Schema;

class m160305_180851_create_user_transaction_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_transaction', [
            'id'                   => Schema::TYPE_PK,
            'sender_id'            => Schema::TYPE_INTEGER . '(20) NOT NULL',
            'receiver_id'          => Schema::TYPE_INTEGER . '(20) NOT NULL',
            'card_number_sender'   => Schema::TYPE_STRING . '(100) NOT NULL',
            'card_number_receiver' => Schema::TYPE_STRING . '(100) NOT NULL',
            'sum'                  => Schema::TYPE_FLOAT . ' NOT NULL',
            'datetime'             => Schema::TYPE_TIMESTAMP . ' NOT NULL'
        ]);

        $this->addForeignKey('sender_id_user_id', 'user_transaction', 'sender_id', 'user', 'id');
        $this->createIndex('card_number_sender_i', 'user_transaction', 'card_number_sender');
        $this->addForeignKey('receiver_id_user_id', 'user_transaction', 'receiver_id', 'user', 'id');
        $this->createIndex('card_number_receiver_i', 'user_transaction', 'card_number_receiver');
    }

    public function safeDown()
    {
        $this->dropTable('user_transaction');
        $this->dropForeignKey('sender_id_user_id', 'user_transaction');
        $this->dropIndex('card_number_sender_i', 'user_transaction');
        $this->dropForeignKey('receiver_id_user_id', 'user_transaction');
        $this->dropIndex('card_number_receiver_i', 'user_transaction');
    }
}
