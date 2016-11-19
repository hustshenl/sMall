<?php

namespace admin\models\system;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\system\Application as ApplicationModel;

/**
 * Application represents the model behind the search form about `common\models\system\Application`.
 */
class Application extends ApplicationModel
{
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
            [['id', 'status', 'type', 'expires', 'encrypt', 'created_at', 'updated_at'], 'integer'],
            [['name', 'identifier', 'description', 'host', 'ip', 'secret', 'token', 'access_token', 'aes_key', 'sso', 'remark'], 'safe'],
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
        $query = ApplicationModel::find();

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
            'expires' => $this->expires,
            'encrypt' => $this->encrypt,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'identifier', $this->identifier])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'host', $this->host])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'secret', $this->secret])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'aes_key', $this->aes_key])
            ->andFilterWhere(['like', 'sso', $this->sso])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
