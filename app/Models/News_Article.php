<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News_Article extends Model
{
    use HasFactory;
    protected $connection = 'news_articles';
}
