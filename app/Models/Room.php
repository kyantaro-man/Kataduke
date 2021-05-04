<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * 状態定義
     */
    const STATUS = [
        1 => ['label' => 'まだ余裕', 'class' => 'label-info'],
        2 => ['label' => '半分以上', 'class' => 'label-warning'],
        3 => ['label' => 'もう限界', 'class' => 'label-danger'],
    ];

    /**
     * 状態のラベル
     * @return string
     */
    public function getStatusLabelAttribute() {
        $status = $this->attributes['status'];

        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['label'];
    }

    /**
     * 状態を表すHTMLクラス
     * @return string
     */
    public function getStatusClassAttribute()
    {
        // 状態値
        $status = $this->attributes['status'];

        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['class'];
    }

    /**
     * アイテムとのリレーション
     */
    public function items() {
        return $this->hasMany('App\Models\Item');
    }
}
