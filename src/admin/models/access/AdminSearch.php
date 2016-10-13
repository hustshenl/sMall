<?php

namespace admin\models\access;

use admin\models\access\Admin;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\validators\EmailValidator;
use yii\validators\NumberValidator;

/**
 * User represents the model behind the search form about `mdm\admin\models\User`.
 */
class AdminSearch extends Admin
{
    public $keyword;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username','keyword','nickname','phone', 'email'], 'string'],
            [['username','keyword','nickname','phone', 'email'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @param string $formName
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Admin::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);
        Yii::trace($this->keyword);
        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }



        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'role' => Admin::ROLE_ADMIN,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email]);
        if(!empty($this->keyword))
            $query->andFilterWhere([
                'or',
                ['like','username',$this->keyword],
                ['like','phone',$this->keyword],
                ['like','email',$this->keyword],
            ]);

        return $dataProvider;
    }
}
