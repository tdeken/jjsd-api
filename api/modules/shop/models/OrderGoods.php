<?php

namespace api\modules\shop\models;

use api\components\ActiveRecord;
use api\modules\shop\models\query\OrderGoodsQuery;
use common\helpers\BaseHelper;
use Yii;

/**
 * This is the model class for table "sd_order_goods".
 *
 * @property int $id
 * @property int $shop_id 商家ID
 * @property int $order_id 订单ID
 * @property int $goods_id 商品ID
 * @property string $name 商品全称
 * @property string $number 商品编号
 * @property string $unit 单位
 * @property string $format 单位
 * @property int $purchase_price 进货价(单位：分)（快照）
 * @property int $price 单价(单位：分)
 * @property float $book_num 下订数量
 * @property string $product_date 生产日期
 * @property string $shelf_life 保质日期
 * @property string $remark 备注
 * @property int $is_del 是否删除（0-否，1-是）
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 */
class OrderGoods extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sd_order_goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shop_id', 'order_id', 'goods_id', 'purchase_price', 'price', 'is_del', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['book_num'], 'number'],
            [['number', 'remark'], 'string', 'max' => 255],
            [['unit', 'format', 'product_date', 'shelf_life'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => '商家ID',
            'order_id' => '订单ID',
            'goods_id' => '商品ID',
            'name' => '商品全称',
            'number' => '商品编号',
            'unit' => '单位',
            'format' => '规格',
            'purchase_price' => '进货价(单位：分)（快照）',
            'price' => '单价(单位：分)',
            'book_num' => '下订数量',
            'product_date' => '生产日期',
            'shelf_life' => '保质日期',
            'remark' => '备注',
            'is_del' => '是否删除（0-否，1-是）',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return OrderGoodsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderGoodsQuery(get_called_class());
    }

    /**
     * @return float|int
     */
    public function totalPriceYuan()
    {
        return number_format(bcmul($this->price, $this->book_num, 2), 2);
    }
}
