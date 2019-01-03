<?php

use yii\db\Migration;

/**
 * Handles the creation of table `role`.
 */
class m170804_162026_create_role_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('role', [
            'id' => $this->primaryKey(),
            'name' => $this->string(35)->notNull()->unique(),
        ]);
        
        $this->insert('role', ['name' => 'Administrator']);
        $this->insert('role', ['name' => 'Standard User']);
        
        $this->addForeignKey('fk_role_id', 'user', 'role_id', 'role', 'id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('role');
    }
}
