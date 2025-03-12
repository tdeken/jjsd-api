<?php


namespace api\modules\shop\resources;


use api\modules\shop\models\OrderGoods;

class OrderGoodsResource extends OrderGoods
{
    public function fieldIndex()
    {
        return [
            'id' => function () {
                return $this->id;
            },
            'name' => function () {
                return $this->name;
            },
            'unit' => function () {
                return $this->unit;
            },
            'format' => function () {
                return $this->format;
            },
            'price' => function () {
                return $this->price;
            },
            'total' => function () {
                return $this->totalPriceYuan();
            },
            'book_num' => function () {
                return sprintf("%g", $this->book_num);
            },
            'number' => function () {
                return $this->number;
            },
            'product_date' => function () {
                return $this->product_date;
            },
            'shelf_life' => function () {
                return $this->shelf_life;
            },
            'remark' => function () {
                return $this->remark;
            }
        ];
    }
}
