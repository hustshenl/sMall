<?php

namespace member\models\member;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\member\Feedback as FeedbackModel;

/**
 * Feedback represents the model behind the search form about `\common\models\member\Feedback`.
 */
class Feedback extends FeedbackModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'type', 'user_id', 'comic_id', 'chapter_id', 'ip', 'created_at', 'updated_at'], 'integer'],
            [['title', 'content', 'username', 'contact', 'url', 'image'], 'safe'],
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
        $query = FeedbackModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'type' => $this->type,
            'user_id' => $this->user_id,
            'comic_id' => $this->comic_id,
            'chapter_id' => $this->chapter_id,
            'ip' => $this->ip,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
