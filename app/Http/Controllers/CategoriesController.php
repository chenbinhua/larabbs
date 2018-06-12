<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    //
    public function show(Category $category)
    {
        //读取分类ID关联话题，并按15分页
        $topics = Topic::with('category','user')->where('category_id',$category->id)->paginate(15);
        return view('topics.index',compact('topics', 'category'));
    }
}
