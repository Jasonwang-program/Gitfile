<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;

class NewsType extends Model
{
    public $timestamps = false;
    protected $table = "news_type";
    protected $primaryKey = 'id';
    protected $fillable = ["id", "typeName"];
}
