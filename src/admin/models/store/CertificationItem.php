<?php

namespace admin\models\store;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\store\CertificationItem as CertificationItemModel;

/**
 * CertificationItem represents the model behind the search form about `common\models\store\CertificationItem`.
 */
class CertificationItem extends CertificationItemModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'certification_id', 'status', 'type', 'required', 'sort'], 'integer'],
            [['name', 'label', 'notice', 'items'], 'safe'],
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
        $query = CertificationItemModel::find();

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
            'certification_id' => $this->certification_id,
            'status' => $this->status,
            'type' => $this->type,
            'required' => $this->required,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'notice', $this->notice])
            ->andFilterWhere(['like', 'items', $this->items]);

        return $dataProvider;
    }
}
