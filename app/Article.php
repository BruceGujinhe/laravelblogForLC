<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Article extends Model
{
    protected $dates = ['published_at'];

    protected $fillable = [
        'title', 'content_raw','content',  'published_at','content_html',
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
    }

    /**
     * Return the date portion of published_at
     */
    public function getPublishDateAttribute($value)
    {
        return $this->published_at->format('M-j-Y');
    }

    /**
     * Return the time portion of published_at
     */
    public function getPublishTimeAttribute($value)
    {
        return $this->published_at->format('g:i A');
    }

    /**
     * Alias for content_raw
     */
    public function getContentRawAttribute($value)
    {
        return $this->contentRaw;
    }

    /**
     * Set the HTML content automatically when the raw content is set
     *
     * @param string $value
     */
    public function setContentRawAttribute($value)
    {
        $markdown = new Markdowner();

        $this->attributes['content_raw'] = $value;
        $this->attributes['content_html'] = $markdown->toHTML($value);
    }

    //TODO 与标签关联

    //TODO 与用户关联

    //TODO 与评论关联
}
