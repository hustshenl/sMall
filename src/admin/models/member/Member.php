<?php

namespace admin\models\member;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\member\Member as MemberModel;

/**
 * member represents the model behind the search form about `common\models\member\Member`.
 */
class Member extends MemberModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'postcode', 'scores', 'grade', 'credit', 'vip', 'vip_scores', 'vip_expires', 'role', 'gender', 'register_ip', 'login_at', 'login_ip', 'created_at', 'updated_at'], 'integer'],
            [['username', 'nickname', 'auth_key', 'password_hash', 'password_reset_token', 'access_token', 'identity', 'identity_sn', 'qq', 'email', 'phone', 'weibo', 'address', 'district', 'city', 'province', 'country', 'language', 'avatar', 'signature', 'remark'], 'safe'],
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
        $query = Member::find();

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
            'postcode' => $this->postcode,
            'scores' => $this->scores,
            'grade' => $this->grade,
            'credit' => $this->credit,
            'vip' => $this->vip,
            'vip_scores' => $this->vip_scores,
            'vip_expires' => $this->vip_expires,
            'role' => $this->role,
            'gender' => $this->gender,
            'register_ip' => $this->register_ip,
            'login_at' => $this->login_at,
            'login_ip' => $this->login_ip,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'identity', $this->identity])
            ->andFilterWhere(['like', 'identity_sn', $this->identity_sn])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'weibo', $this->weibo])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'signature', $this->signature])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
