<?php

use yii\db\Migration;

class m170814_134352_add_annotations_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('annotation', [
            'id' => $this->primaryKey(),
            'value' => $this->text(),
            'item_id' => $this->string()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_annotations_doc_id', 'annotation', 'item_id', 'item', 'generic_file_name', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        echo "m170814_134352_add_annotations_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170814_134352_add_annotations_table cannot be reverted.\n";

        return false;
    }
    */
}
