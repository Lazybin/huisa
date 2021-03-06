<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    protected $appends = ['goods'];

    public function getGoodsAttribute()
    {
        $goods=Goods::find($this->goods_id);
        if($goods == null) {
            return '';
        }
        return $goods->toArray();
    }

    public function goods()
    {
        return $this->hasOne('App\Model\Goods','id','goods_id');
    }
}
