<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Model(
 * id="newComment",
 * @SWG\Property(name="user_id",type="integer",description="用户id"),
 * @SWG\Property(name="type",type="integer",description="类型，0---》商品 1---》主题"),
 * @SWG\Property(name="item_id",type="integer",description="项id"),
 * @SWG\Property(name="content",type="string",description="评论内容")
 * )
 */
/**
 * @SWG\Model(id="UserComment")
 */
class UserComment extends Model
{
    /**
     * @SWG\Property(name="id",type="integer",description="id")
     * @SWG\Property(name="user_id",type="integer",description="用户id")
     * @SWG\Property(name="type",type="integer",description="类型，0---》商品 1---》主题")
     * @SWG\Property(name="item_id",type="integer",description="项id")
     * @SWG\Property(name="content",type="string",description="评论内容")
     * @SWG\Property(name="nick_name",type="string",description="用户昵称")
     * @SWG\Property(name="head_icon",type="string",description="头像地址")
     * @SWG\Property(name="level",type="string",description="等级")
     * @SWG\Property(name="created_at",type="string",description="评论时间")
     */
    protected $fillable = [
        'user_id','type','item_id','content'
    ];
}
