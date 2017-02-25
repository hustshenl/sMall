<?php

namespace common\models\user;

/**
 * This is the ActiveQuery class for [[Seller]].
 *
 * @see Seller
 */
class SellerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Seller[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Seller|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
