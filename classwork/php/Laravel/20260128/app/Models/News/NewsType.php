<?php
// app/Models/News/NewsType.php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

class NewsType extends Model
{
    public $timestamps = false;

    protected $table = 'news_type';
    protected $primaryKey = 'id';

    // 只允許寫入 typeName（id 通常不用放進來）
    protected $fillable = ['typeName'];
}
