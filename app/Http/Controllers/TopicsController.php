<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Auth;
use App\Handlers\ImageUploadHandler;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
		$topics = $topic->withOrder($request->order)->paginate(15);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic, Request $request)
    {
        if( !empty($topic->slug) && $topic->slug != $request->slug){
            return redirect($topic->link(),301);
        }
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
		$topic->fill($request->all());
		$topic->user_id = Auth::id();
		$topic->save();

		return redirect()->to($topic->link())->with('success', '成功创建话题！');
	}

	public function edit(Topic $topic)
	{
        $categories = Category::all();
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除成功！');
	}

	public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        //默认上次失败
        $data = [
            'success'   => false,
            'msg'       => '图片上次失败',
            'file_path' => '',
        ];

        //判断是否有上传图片，并赋值给file
        if($file = $request->upload_file){
            //保存图片到本地
            $result = $uploader->save($request->upload_file, 'Topics', \Auth::id(), 1024);
            //判断图片是否保存成功，并返回json数据
            if($result){
                $data['success']   = true;
                $data['msg']       = '图片上传成功';
                $data['file_path'] = $result['path'];
            }
        }
        return $data;
    }
}