<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    //
    public function show(Category $category, Topic $topic, Request $request)
    {
        //读取分类ID关联话题，并按15分页
        $topics = $topic->where('category_id',$category->id)
                        ->withOrder($request->order)
                        ->paginate(15);
        return view('topics.index',compact('topics', 'category'));
    }
}
