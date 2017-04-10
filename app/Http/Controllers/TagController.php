<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;

/**
 * Class TagController
 * @package App\Http\Controllers
 */
class TagController extends Controller
{
    protected $fields = [
        'tag' => '',
        'title' => '',
        'meta_description' => '',
        'reverse_direction' => 0,
    ];
    public function index()
    {
        $tags = Tag::all();
        return view('user.tag.index')->withTags($tags);
    }

    /**
     * Show form for creating new tag
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

        return view('user.tag.create', $data);
    }

    public function store(TagCreateRequest $request)
    {
        $tag = new Tag();
        foreach (array_keys($this->fields) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();

        return redirect('/user/tag')
            ->withSuccess("The tag '$tag->tag' was created.");
    }
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $data = ['id' => $id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $tag->$field);
        }

        return view('user.tag.edit', $data);
    }
    public function update(TagUpdateRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);

        foreach (array_keys(array_except($this->fields, ['tag'])) as $field) {
            $tag->$field = $request->get($field);
        }
        $tag->save();

        return redirect("/user/tag/$id/edit")
            ->withSuccess("Changes saved.");
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return redirect('/user/tag')
            ->withSuccess("The '$tag->tag' tag has been deleted.");
    }
}
