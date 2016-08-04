<?php

namespace member\models\base;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\Region as RegionModel;

/**
 * Region represents the model behind the search form about `common\models\base\Region`.
 */
class Region extends RegionModel
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'lvl'], 'integer'],
            [['name', 'sn', 'letter', 'slug', 'search_word'], 'safe'],
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
        $query = RegionModel::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=> isset(Yii::$app->params['pagination'])?Yii::$app->params['pagination']:false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'pid' => $this->pid,
            'lvl' => $this->lvl,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sn', $this->sn])
            ->andFilterWhere(['like', 'letter', $this->letter])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'search_word', $this->search_word]);

        return $dataProvider;
    }
}
