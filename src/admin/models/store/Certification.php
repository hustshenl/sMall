<?php

namespace admin\models\store;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\store\Certification as CertificationModel;

/**
 * Certification represents the model behind the search form about `common\models\store\Certification`.
 */
class Certification extends CertificationModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'type', 'price', 'model_id', 'deposit', 'expires_in', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'icon', 'reference'], 'safe'],
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
        $query = CertificationModel::find();

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
            'price' => $this->price,
            'deposit' => $this->deposit,
            'expires_in' => $this->expires_in,
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'reference', $this->reference]);

        return $dataProvider;
    }
}
