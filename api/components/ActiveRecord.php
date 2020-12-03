<?php


namespace api\components;


use common\behaviors\ModelTimeBehavior;
use common\behaviors\OperatorBehavior;
use common\traits\DatabaseNameTrait;
use common\traits\ModelFieldTypeTrait;
use yii\db\ActiveRecord as BaseActiveRecord;

class ActiveRecord extends BaseActiveRecord
{
    use DatabaseNameTrait, ModelFieldTypeTrait;

    /**
     * 删除标识
     */
    const IS_DEL_YES = 1;

    /**
     * 未删除标识
     */
    const IS_DEL_NO = 0;

    /**
     * 详情场景字段
     */
    const FIELD_SHOW = 'show';

    /**
     * 列表场景字段
     */
    const FIELD_INDEX = 'index';

    /**
     * 新增数据场景
     */
    const SCENARIO_STORE = 'store';

    /**
     * 更新数据场景
     */
    const SCENARIO_UPDATE = 'update';

    /**
     * 删除数据场景
     */
    const SCENARIO_DESTROY = 'destroy';

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            ModelTimeBehavior::class,
            OperatorBehavior::class,
        ]); // TODO: Change the autogenerated stub
    }
}