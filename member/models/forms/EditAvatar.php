<?php
namespace member\models\forms;

use common\models\access\User;
use yii\base\Model;
use yii;

/**
 * EditAvatar form
 */
class EditAvatar extends Model
{
    public $id;
    public $avatar;
    public $avatar_crop;
    public $isNewRecord = false;

    /**
     * @param array $config
     * @param bool $items
     */
    public function __construct($config = [], $items = false)
    {

        parent::__construct($config);

        if (is_array($items)) {
            //$this->load($items,'');
            $this->attributes = $items;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            [['avatar'], 'string'],
            [['avatar_crop'], 'safe'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'avatar' => Yii::t('common', 'Avatar'),
        ];
    }

    /**
     * Signs user up.
     * @param bool|false $useOldPassword
     * @return User|false the saved model or null if saving fails
     */

    public function update($validatePassword = true)
    {
        if ($this->validate()) {
            $user = User::findOne($this->id);
            $user->avatar = $this->avatar;

            if ($user->save()) {
                return $user;
            }
        }

        return false;
    }
}
