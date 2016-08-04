<?php
namespace common\migrations;

use common\models\base\Scheduler;
use yii\db\Schema;
use yii\db\Migration;
use yii\helpers\Json;
use common\components\Scheduler as SchedulerService;
use common\components\collect\Task as Collect;

class m160101_000004_init_scheduler extends Migration
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
        $this->truncateTable('{{%scheduler}}');
        $schedulers = $this->getScheduler();
        foreach($schedulers as $k=>$scheduler){
            $scheduler['status'] = Scheduler::STATUS_ACTIVE;
            $scheduler['updated_at'] = $scheduler['created_at'] = time();
            $this->insert('{{%scheduler}}',$scheduler);
        }
    }

    public function down()
    {
        echo "m160101_000003_init_data cannot be reverted.\n";
        return false;
    }

    protected function getScheduler()
    {
        return [
            [
                'name'=>'重置今日统计',
                'description'=>'重置今日点击和人气统计',
                'frequency'=>Scheduler::FREQUENCY_CRON,
                'priority'=>Scheduler::PRIORITY_IMMEDIATE,
                'param'=>Json::encode([
                    'format'=>'Y-m-d',
                    'interval'=>'+1 day',
                    'padding'=>0,
                ]),
                'method'=>Json::encode([
                    'className'=>SchedulerService::className(),
                    'methodName'=>'dailyTask',
                    'param'=>'',
                ]),
            ],
            [
                'name'=>'重置本周统计',
                'description'=>'重置本周点击和人气统计',
                'frequency'=>Scheduler::FREQUENCY_CRON,
                'priority'=>Scheduler::PRIORITY_IMMEDIATE,
                'param'=>Json::encode([
                    'format'=>'Y-m-d',
                    'interval'=>'+1 week monday',
                    'padding'=>0,
                ]),
                'method'=>Json::encode([
                    'className'=>SchedulerService::className(),
                    'methodName'=>'weeklyTask',
                    'param'=>'',
                ]),
            ],
            [
                'name'=>'重置本月统计',
                'description'=>'重置本月点击和人气统计',
                'frequency'=>Scheduler::FREQUENCY_CRON,
                'priority'=>Scheduler::PRIORITY_IMMEDIATE,
                'param'=>Json::encode([
                    'format'=>'Y-m',
                    'interval'=>'+1 month',
                    'padding'=>0,
                ]),
                'method'=>Json::encode([
                    'className'=>SchedulerService::className(),
                    'methodName'=>'monthlyTask',
                    'param'=>'',
                ]),
            ],
            [
                'name'=>'采集列表任务',
                'description'=>'启动采集列表处理任务',
                'frequency'=>Scheduler::FREQUENCY_ALWAYS,
                'priority'=>Scheduler::PRIORITY_LOW,
                'param'=>'',
                'timeout'=>'30',
                'method'=>Json::encode([
                    'className'=> Collect::className(),
                    'methodName'=>'handleLists',
                    'param'=>'',
                ]),
            ],
            [
                'name'=>'采集漫画任务',
                'description'=>'启动采集漫画处理任务',
                'frequency'=>Scheduler::FREQUENCY_ALWAYS,
                'priority'=>Scheduler::PRIORITY_LOW,
                'param'=>'',
                'timeout'=>'30',
                'method'=>Json::encode([
                    'className'=> Collect::className(),
                    'methodName'=>'handleComics',
                    'param'=>'',
                ]),
            ],
            [
                'name'=>'采集章节任务',
                'description'=>'启动采集章节处理任务',
                'frequency'=>Scheduler::FREQUENCY_ALWAYS,
                'priority'=>Scheduler::PRIORITY_LOW,
                'param'=>'',
                'timeout'=>'30',
                'method'=>Json::encode([
                    'className'=> Collect::className(),
                    'methodName'=>'handleChapters',
                    //'param'=>'',
                ]),
            ],
            [
                'name'=>'采集图片任务',
                'description'=>'启动采集图片处理任务',
                'frequency'=>Scheduler::FREQUENCY_ALWAYS,
                'priority'=>Scheduler::PRIORITY_LOW,
                'param'=>'',
                'timeout'=>'30',
                'method'=>Json::encode([
                    'className'=> Collect::className(),
                    'methodName'=>'handleImages',
                    //'param'=>'',
                ]),
            ],
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
