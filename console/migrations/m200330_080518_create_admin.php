<?php
use yii\db\Migration;

/**
 * Class m200330_080518_create_admin
 */
class m200330_080518_create_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%auth_item}}', [
            'name' => 'admin',
            'type' => 1,
            'description' => 'Технический администратор',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $admin = new \dektrium\user\models\User();
        $admin->username = 'admin';
        $admin->email = 'admin@rmdp.test';
        $admin->password = 'admin';

        if (!$admin->create()) {
            throw new \RuntimeException('Can\'t create admin user');
        }

        $this->insert('{{%auth_assignment}}', [
            'item_name' => 'admin',
            'user_id' => $admin->id,
            'created_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200330_080518_create_admin cannot be reverted.\n";
        return false;
    }
}
