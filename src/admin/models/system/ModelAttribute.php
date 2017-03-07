<?php

namespace admin\models\system;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\system\ModelAttribute as ModelAttributeModel;

/**
 * ModelAttribute represents the model behind the search form about `common\models\system\ModelAttribute`.
 */
class ModelAttribute extends ModelAttributeModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'status', 'sort', 'length', 'is_key', 'required', 'created_at', 'updated_at'], 'integer'],
            [['name', 'label', 'data_type', 'input_type', 'default_value', 'extra', 'description'], 'safe'],
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
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ModelAttributeModel::find();

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
            'model_id' => $this->model_id,
            'status' => $this->status,
            'sort' => $this->sort,
            'length' => $this->length,
            'is_key' => $this->is_key,
            'required' => $this->required,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'data_type', $this->data_type])
            ->andFilterWhere(['like', 'input_type', $this->input_type])
            ->andFilterWhere(['like', 'default_value', $this->default_value])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
