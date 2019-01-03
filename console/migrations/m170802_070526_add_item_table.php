<?php

use yii\db\Migration;

class m170802_070526_add_item_table extends Migration {

    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            //http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%item}}', [
            'id' => $this->primaryKey(),
            'generic_file_name' => $this->string()->notNull()->unique(),
            'original_file_name' => $this->string()->notNull(),
            'file_description' => $this->string(512),
            'user_id' => $this->string()->notNull(),
                ], $tableOptions);
    }

    public function safeDown() {
        echo "m170802_070526_add_item_table cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m170802_070526_add_item_table cannot be reverted.\n";

      return false;
      }
     */
}
