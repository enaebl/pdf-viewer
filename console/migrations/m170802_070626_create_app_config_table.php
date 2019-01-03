<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service`.
 */
class m170802_070626_create_app_config_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('app_config', [
            'id' => $this->primaryKey(),
            'app_title' => $this->string(50)->notNull(),
            'about' => $this->string(350)->notNull(),
            'address' => $this->string(250),
            'email' => $this->string(50),
            'fax' => $this->string(75),
            'phone' => $this->string(50),
            'facebook' => $this->string(150),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('app_config');
    }
}
