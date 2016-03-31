<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Vencimiento]].
 *
 * @see Vencimiento
 */
class VencimientoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Vencimiento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Vencimiento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
