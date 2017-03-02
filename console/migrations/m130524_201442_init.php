<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        
        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(100)->notNull(),
        ], $tableOptions);
        
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'label' => $this->string(100)->notNull(),
        ], $tableOptions);
        
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'author' => $this->string(100)->notNull(),
            'companyId' => $this->integer(6)->notNull(),
            'message' => $this->text()->notNull(),
            'comment' => $this->text()->defaultValue(NULL),
            'date_get' => $this->dateTime()->notNull(),
            'date_start' => $this->dateTime()->defaultValue(NULL),
            'date_finish' => $this->dateTime()->defaultValue(NULL),
            'statusId' => $this->integer(6)->defaultValue(1),            
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%company}}');
        $this->dropTable('{{%status}}');
        $this->dropTable('{{%tasks}}');
    }
}
