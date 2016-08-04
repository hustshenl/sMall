<?php
namespace common\migrations;

use common\models\base\Category;
use yii\db\Schema;
use yii\db\Migration;

class m160101_000003_init_category extends Migration
{

    public function primaryKey($length = null)
    {
        return 'int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY';
    }
    public function integer($length = null)
    {
        return parent::integer($length)->notNull();
    }
    public function string($length = null)
    {
        return parent::string($length)->notNull();
    }
    public function text()
    {
        return parent::text()->notNull();
    }
    public function up()
    {
        $this->truncateTable('{{%category}}');
        //$this->insert('{{%category}}',[]);
        $schedulers = $this->getCategories();
        foreach($schedulers as $k=>$scheduler){
            $scheduler['status'] = Category::STATUS_APPROVED;
            $scheduler['sort'] = $k*10;
            $scheduler['keywords'] = $scheduler['description'] = '';
            $this->insert('{{%category}}',$scheduler);
        }
    }

    public function down()
    {
        echo "m160101_000003_init_data cannot be reverted.\n";
        return false;
    }

    public function getCategories()
    {
        return [
            ['name'=>'儿童漫画', 'slug'=>'ertong', 'type'=>Category::TYPE_CATEGORY],
            ['name'=>'少年漫画', 'slug'=>'shaonian', 'type'=>Category::TYPE_CATEGORY],
            ['name'=>'少女漫画', 'slug'=>'shaonnv', 'type'=>Category::TYPE_CATEGORY],
            ['name'=>'青年漫画', 'slug'=>'qingnian', 'type'=>Category::TYPE_CATEGORY],
            ['name'=>'2000年前', 'slug'=>'2000nianqian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2001年', 'slug'=>'2001nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2002年', 'slug'=>'2002nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2003年', 'slug'=>'2003nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2004年', 'slug'=>'2004nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2005年', 'slug'=>'2005nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2006年', 'slug'=>'2006nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2007年', 'slug'=>'2007nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2008年', 'slug'=>'2008nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2009年', 'slug'=>'2009nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2010年', 'slug'=>'2010nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2011年', 'slug'=>'2011nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2012年', 'slug'=>'2012nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2013年', 'slug'=>'2013nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2014年', 'slug'=>'2014nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2015年', 'slug'=>'2015nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'2016年', 'slug'=>'2016nian', 'type'=>Category::TYPE_YEAR],
            ['name'=>'12岁以下', 'slug'=>'12suiyixia', 'type'=>Category::TYPE_AGE],
            ['name'=>'12-18岁', 'slug'=>'12_18sui', 'type'=>Category::TYPE_AGE],
            ['name'=>'18-25岁', 'slug'=>'18_25sui', 'type'=>Category::TYPE_AGE],
            ['name'=>'25岁以上', 'slug'=>'25suiyishang', 'type'=>Category::TYPE_AGE],
            ['name'=>'黑白', 'slug'=>'heibai', 'type'=>Category::TYPE_COLOR],
            ['name'=>'彩色', 'slug'=>'caise', 'type'=>Category::TYPE_COLOR],
            ['name'=>'日本', 'slug'=>'riben', 'type'=>Category::TYPE_REGION],
            ['name'=>'大陆', 'slug'=>'dalu', 'type'=>Category::TYPE_REGION],
            ['name'=>'香港', 'slug'=>'hongkong', 'type'=>Category::TYPE_REGION],
            ['name'=>'台湾', 'slug'=>'taiwan', 'type'=>Category::TYPE_REGION],
            ['name'=>'欧美', 'slug'=>'oumei', 'type'=>Category::TYPE_REGION],
            ['name'=>'韩国', 'slug'=>'hanguo', 'type'=>Category::TYPE_REGION],
            ['name'=>'其他', 'slug'=>'qita', 'type'=>Category::TYPE_REGION],
            //['name'=>'其他', 'slug'=>'qita', 'type'=>Category::TYPE_REGION],
        ];
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
