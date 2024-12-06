<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shop extends Model
{
    use HasFactory;

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function favorites()
    {
        return $this->hasMany('App\Models\Favorite');
    }

    /**********************************
        お気に入り登録されているかどうか調べる    
    /********************************** */
    public function checkFavorite()
    {
        // ログイン中のユーザーID取得
        $id = Auth::id();
        // 空の配列を用意
        $bookmarkers = array();
        // お気に入り情報をforeachで回してuser_idを用意した配列に追加
        foreach($this->favorites as $favorite) {
            array_push($bookmarkers, $favorite->user_id);
        }
        // 配列の中にログイン中のユーザーIDが存在するか
        if(in_array($id, $bookmarkers)) {
            return true;
        } else {
            return false;
        }

    }

    /**********************************
        Search
    /********************************** */
    public function scopeAreaSearch($query, $area_id)
    {
        if(!empty($area_id)) {
            $query->where('area_id', $area_id);
        }
    }

    public function scopeCategorySearch($query, $category_id)
    {
        if(!empty($category_id)) {
            $query->where('category_id', $category_id);
        }
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if(!empty($keyword)) {
            $query->where('shop_name', 'like', '%' . $keyword . '%');
        }
    }
}
