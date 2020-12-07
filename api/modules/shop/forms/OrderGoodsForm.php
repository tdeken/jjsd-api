<?php


namespace api\modules\shop\forms;


use api\modules\shop\models\OrderGoods;

class OrderGoodsForm extends OrderGoods
{
    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['order_id', 'goods_id', 'name', 'number', 'unit', 'purchase_price', 'price', 'book_num', 'format', 'product_date', 'shelf_life'], 'required']
        ];
    }

    /**
     * @return array|array[]
     */
    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_STORE => ['order_id', 'goods_id', 'name', 'number', 'unit', 'purchase_price', 'price', 'book_num', 'format', 'product_date', 'shelf_life']
        ]); // TODO: Change the autogenerated stub
    }
}