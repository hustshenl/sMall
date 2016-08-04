<?php

namespace member\models\comic;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\comic\Comic as ComicModel;

/**
 * Comic represents the model behind the search form about `common\models\comic\Comic`.
 */
class Comic extends ComicModel
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
            //[['status', 'commend', 'is_vip',  'is_original', 'free_num', 'year', 'age', 'gender', 'region', 'week', 'serialise', 'color', 'edition', 'format', 'user_id', 'editor_id', 'category', 'next_post', 'last_chapter_id', 'post_num', 'weight', 'scores', 'click', 'click_monthly', 'click_weekly', 'click_daily', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        $scenarios = parent::scenarios();
        $scenarios['search_author'] = ['keywords', 'status', 'commend', 'is_original', 'category', 'year', 'age', 'gender', 'region', 'week', 'serialise', 'color', 'edition', 'format','author_id'];

        return $scenarios;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = ComicModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=> isset(Yii::$app->params['pagination'])?Yii::$app->params['pagination']:false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'commend' => $this->commend,
            'is_vip' => $this->is_vip,
            'free_num' => $this->free_num,
            'year' => $this->year,
            'age' => $this->age,
            'gender' => $this->gender,
            'region' => $this->region,
            'week' => $this->week,
            'serialise' => $this->serialise,
            'color' => $this->color,
            'edition' => $this->edition,
            'format' => $this->format,
            'author_id' => $this->author_id,
            'user_id' => $this->user_id,
            'editor_id' => $this->editor_id,
            'category' => $this->category,
            'next_post' => $this->next_post,
            'last_chapter_id' => $this->last_chapter_id,
            'post_num' => $this->post_num,
            'weight' => $this->weight,
            'scores' => $this->scores,
            'click' => $this->click,
            'click_monthly' => $this->click_monthly,
            'click_weekly' => $this->click_weekly,
            'click_daily' => $this->click_daily,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'original_name', $this->original_name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'letter', $this->letter])
            ->andFilterWhere(['like', 'mark', $this->mark])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'next_chapter', $this->next_chapter])
            ->andFilterWhere(['like', 'last_chapter_name', $this->last_chapter_name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'search_word', $this->keywords])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
