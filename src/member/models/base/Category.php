<?php

namespace member\models\base;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\base\Category as CategoryModel;

/**
 * Category represents the model behind the search form about `common\models\base\Category`.
 */
class Category extends CategoryModel
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
            [['id', 'status', 'pid', 'level', 'sort', 'count'], 'integer'],
            [['name', 'slug', 'keywords', 'description'], 'safe'],
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
        $query = CategoryModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=> isset(Yii::$app->params['pagination'])?Yii::$app->params['pagination']:false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //$query->orderBy(['sort'=>SORT_ASC]);
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'pid' => $this->pid,
            'level' => $this->level,
            'sort' => $this->sort,
            'count' => $this->count,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
