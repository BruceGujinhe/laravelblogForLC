<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ArticleCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required',
            'publish_date' => 'required',
            'publish_time' => 'required',
        ];
    }
    public function articleFillData()
    {
        $published_at = new Carbon(
            $this->publish_date.' '.$this->publish_time
        );
//        dd($this->get('content'));
        return [
            'title' => $this->title,
            'page_image' => $this->page_image,
            'content' => $this->get('content'),
            'meta_description' => $this->meta_description,
            'is_draft' => (bool)$this->is_draft,
            'published_at' => $published_at,
        ];
    }

}
