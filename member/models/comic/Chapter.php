<?php

namespace member\models\comic;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\comic\Chapter as ChapterModel;

/**
 * Chapter represents the model behind the search form about `\common\models\comic\Chapter`.
 */
class Chapter extends ChapterModel
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
            [['id', 'comic_id', 'status', 'is_vip', 'user_id', 'editor_id', 'category', 'image_type', 'count', 'zip_status', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['comic_name', 'name', 'link', 'link_name', 'images', 'path', 'zip_file'], 'safe'],
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
        $query = ChapterModel::find();

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'comic_id' => $this->comic_id,
            'status' => $this->status,
            'is_vip' => $this->is_vip,
            'user_id' => $this->user_id,
            'editor_id' => $this->editor_id,
            'category' => $this->category,
            'image_type' => $this->image_type,
            //'count' => $this->count,
            'zip_status' => $this->zip_status,
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'comic_name', $this->comic_name])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'link_name', $this->link_name])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'zip_file', $this->zip_file]);

        return $dataProvider;
    }
}
