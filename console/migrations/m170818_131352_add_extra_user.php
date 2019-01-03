<?php

use yii\db\Migration;

class m170818_131352_add_extra_user extends Migration
{
    public function safeUp()
    {
        $this->insert('user', ['username' => 'user', 'auth_key' => '$4z$78$gLdZ5gr$rwn$TYs2DFa34Lkkg', 'password_hash' => '$2y$13$4YYNoolrkG4bOMp3xKJFeOiUtMWfJHcJD20MJZoqj2jT1rWiMfPx2'/*a*/, 'email' => 'user@server.com', 'role_id' => 2]);
    }

    public function safeDown()
    {
        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
