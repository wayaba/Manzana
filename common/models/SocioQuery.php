<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Socio]].
 *
 * @see Socio
 */
class SocioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Socio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Socio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
