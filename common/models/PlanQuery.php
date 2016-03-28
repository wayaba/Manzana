<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Plan]].
 *
 * @see Plan
 */
class PlanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Plan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Plan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
