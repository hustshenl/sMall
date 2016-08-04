<?php

namespace member\models\access\searchs;

use common\models\access\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii;

/**
 * AssignmentSearch represents the model behind the search form about Assignment.
 * 
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Assignment extends Model
{
    public $id;
    public $username;
    public $nickname;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'username', 'nickname', 'email'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('rbac-member', 'ID'),
            'username' => Yii::t('rbac-member', 'Username'),
            'nickname' => Yii::t('rbac-member', 'Nickname'),
            'email' => Yii::t('rbac-member', 'Email'),
            'name' => Yii::t('rbac-member', 'Name'),
        ];
    }

    /**
     * Create data provider for Assignment model.
     * @param $params
     * @param null $formName
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=> isset(Yii::$app->params['pagination'])?Yii::$app->params['pagination']:false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $query->andWhere(['role'=>User::ROLE_ADMIN]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
