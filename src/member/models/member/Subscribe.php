<?php

namespace member\models\member;


use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\member\Subscribe as SubscribeModel;

/**
 * Subscribe represents the model behind the search form about `\common\models\member\Subscribe`.
 */
class Subscribe extends SubscribeModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'type', 'user_id', 'comic_id', 'read_chapter_id', 'read_at', 'read_page', 'update_chapter_id', 'update_at', 'created_at'], 'integer'],
            [['read_chapter', 'update_chapter'], 'safe'],
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
        $query = SubscribeModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'read_chapter_id' => $this->read_chapter_id,
            'read_at' => $this->read_at,
            'read_page' => $this->read_page,
            'update_chapter_id' => $this->update_chapter_id,
            'update_at' => $this->update_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'read_chapter', $this->read_chapter])
            ->andFilterWhere(['like', 'update_chapter', $this->update_chapter]);

        $query->with('comic');

        return $dataProvider;
    }

}
