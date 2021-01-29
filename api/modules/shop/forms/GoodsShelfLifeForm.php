<?php


namespace api\modules\shop\forms;


use api\modules\shop\models\GoodsShelfLife;
use common\traits\FormModelValidate;

class GoodsShelfLifeForm extends GoodsShelfLife
{
    use FormModelValidate;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id', 'title', 'shop_id'], 'required'],
            [['title'], 'uniqNotDel'],
        ];
    }

    /**
     * @return array|array[]
     */
    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_STORE => ['shop_id', 'title'],
            self::SCENARIO_UPDATE => ['id', 'title'],
            self::SCENARIO_DESTROY => ['id'],
        ]); // TODO: Change the autogenerated stub
    }
}