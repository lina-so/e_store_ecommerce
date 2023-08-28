<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];

    public function sections(){
        $getSections = Section::where('status', 1)->get();
        
        return $getSections;
    }

    public function categories(){

        return $this->hasMany(Category::class, 'section_id')->where(['parent_id' => 0, 'status' => 1])->with('subcategories');
    }

    public function parentCategory(){

        return $this->belongsTo(Category::class, 'parent_id')->select('id', 'category_name');
    }

    public function subcategories(){

        return $this->hasMany(Category::class, 'parent_id')->select('status');
    }
}
