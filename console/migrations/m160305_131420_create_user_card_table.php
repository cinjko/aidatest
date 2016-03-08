<?php

use yii\db\Migration;
use yii\db\Schema;

class m160305_131420_create_user_card_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_card', [
            'id'                 => Schema::TYPE_PK,
            'user_id'            => Schema::TYPE_INTEGER . '(20) NOT NULL',
            'card_number'        => Schema::TYPE_STRING . '(50) NOT NULL',
            'cv2'                => Schema::TYPE_INTEGER . '(5) NOT NULL',
            'expiration_date'    => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'card_holder_number' => Schema::TYPE_STRING . '(50) NOT NULL',
            'card_amount'        => Schema::TYPE_DECIMAL
        ]);

        $this->addForeignKey('user_card_user_id', 'user_card', 'user_id', 'user', 'id');
        $this->createIndex('card_number_cv2', 'user_card', ['card_number', 'cv2']);
        $this->createIndex('user_id_i', 'user_card', 'user_id');
        $this->createIndex('card_holder_number_i', 'user_card', 'card_holder_number');
    }

    public function safeDown()
    {
        $this->dropTable('user_card');
        $this->dropIndex('card_holder_number_i', 'user_card');
        $this->dropForeignKey('user_card_user_id', 'user_card');
        $this->dropIndex('user_id_i', 'user_card');
        $this->dropIndex('card_number_cv2', 'user_card');
    }
}
