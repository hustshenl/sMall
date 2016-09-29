<?php

namespace common\models\member;

/**
 * This is the ActiveQuery class for [[Member]].
 *
 * @see Member
 */
class MemberQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Member[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Member|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
