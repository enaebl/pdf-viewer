<?php

use yii\db\Migration;

class m170802_070726_populate_schema extends Migration
{
    public function safeUp()
    {
        
        $this->insert('user', ['username' => 'admin', 'auth_key' => '#4z$28$gLdZ5gr$rws$TYs2DFa34Lk8g', 'password_hash' => '$2y$13$4YYNoolrkG4bOMp3xKJFeOiUtMWfJHcJD20MJZoqj2jT1rWiMfPx2'/*a*/, 'email' => 'admin@server.com', 'role_id' => 1]);

        $this->insert('app_config', [
            'app_title' => 'PDFViewer',
            'about' => 'Online PDF Viewer and Annotator.',
            'address' => 'Bla bla',
            'email' => 'pdf@viewer.com',
            'fax' => '+53 7 123 4567',
            'phone' => '+53 5 123 4567',
            'facebook' => 'http://www.pdf.makeitreadable.co.uk']);
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
