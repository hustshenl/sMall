<?php

use yii\db\Migration;
use yii\db\Exception;

class m160101_000001_init extends Migration
{

    /*protected function getTableOption($comment = false)
    {
        if ($comment) $comment = ' COMMENT="应用表" ';
        return 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ' . $comment . ' ENGINE=InnoDB';
    }*/

    public function primaryKey($length = null)
    {
        //return $this->db->schema->createColumnSchemaBuilder(Schema::TYPE_PK, $length);
        //return 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY';
        return parent::primaryKey($length);
        //return parent::integer($length)->unsigned()->notNull()->;
    }

    /**
     * @param null $length
     * @param int $default
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function integer($length = null, $default=0)
    {
        return parent::integer($length)->notNull()->defaultValue($default);
    }

    /**
     * @param null $length
     * @param string $default
     * @return \yii\db\ColumnSchemaBuilder
     */
    public function string($length = null, $default='')
    {
        return parent::string($length)->notNull()->defaultValue($default);
    }

    public function text()
    {
        return parent::text()->notNull();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        //parent::up();
        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'source' => $this->string(),
            'openid' => $this->string(),
            'status' => $this->integer(null,1),
            'appid' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);

        try{$this->dropTable('{{%config}}');}catch (Exception $e){}
        $this->createTable('{{%config}}', [
            'conf_key' => $this->string(),
            'conf_value' => $this->text(),
            'PRIMARY KEY (conf_key)',
        ], $tableOptions);
        $this->createTable('{{%feedback}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(),
            'type' => $this->integer()->unsigned(),
            'title' => $this->string(),
            'content' => $this->string(1024),
            'user_id' => $this->integer()->unsigned(),
            'username' => $this->string(),
            'contact' => $this->string(),
            'url' => $this->string(),
            'comic_id' => $this->integer()->unsigned(),
            'chapter_id' => $this->integer()->unsigned(),
            'image' => $this->string(),
            'ip' => $this->integer()->unsigned(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);
        $this->createTable('{{%flink}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(null, 0),
            'link' => $this->string(),
            'name' => $this->string(),
            'title' => $this->string(),
            'keywords' => $this->string(),
            'description' => $this->string(1024),
            'logo' => $this->string(),
            'type' => $this->integer()->unsigned(),
            'gid' => $this->integer()->unsigned(),
            'sort' => $this->integer(),
            'admin' => $this->string(),
            'email' => $this->string(),
            'qq' => $this->string(),
            'remark' => $this->string(1024),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%navigation}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(null, 0),
            'name' => $this->string(),
            'title' => $this->string(),
            'icon' => $this->string(),
            'gid' => $this->integer(),
            'link' => $this->string(),
            'sort' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ], $tableOptions);

        try{$this->dropTable('{{%user}}');}catch (Exception $e){}
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(null,1),
            'username' => $this->string(),
            'nickname' => $this->string(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string(64),
            'password_reset_token' => $this->string(128),
            'access_token' => $this->string(128),
            'identity' => $this->string(),
            'identity_sn' => $this->string(),
            'qq' => $this->string(),
            'email' => $this->string(),
            'phone' => $this->string(64),
            'weibo' => $this->string(),
            'address' => $this->string(),
            'postcode' => $this->integer(),
            'scores' => $this->integer(),
            'grade' => $this->integer(),
            'credit' => $this->integer(null, 0),
            'vip' => $this->integer(null, 0),
            'vip_scores' => $this->integer(),
            'vip_expires' => $this->integer(null, 0),
            'role' => $this->integer(null,1),
            'gender' => $this->integer(),
            'district' => $this->string(64),
            'city' => $this->string(64),
            'province' => $this->string(64),
            'country' => $this->string(64),
            'language' => $this->string(64,'zh-CN'),
            'avatar' => $this->string(),
            'signature' => $this->string(2048),
            'remark' => $this->string(2048),
            'register_ip' => $this->integer()->unsigned(),
            'login_at' => $this->integer(null, 0),
            'login_ip' => $this->integer()->unsigned(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        //$this->createIndex('idx-comic', '{{%user}}', 'comic_id');


    }

    public function down()
    {
        echo "m160101_000002_create_db cannot be reverted.\n";
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

