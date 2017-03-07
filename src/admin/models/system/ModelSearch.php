<?php

namespace admin\models\system;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\system\Model as ModelModel;

/**
 * FormModel represents the model behind the search form about `common\models\system\FormModel`.
 */
class ModelSearch extends ModelModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'type', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['name', 'table', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return parent::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ModelModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'type' => $this->type,
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'table', $this->table])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
