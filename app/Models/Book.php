<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'books';

    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn',
        'title',
        'issn',
        'pages',
        'language',
        'edition',
        'publication',
        'notes',
        'author_id',
        'publisher_id',
        'category_id'
    ];

    /**
     * Get the category of given book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Medlib\Models\Category');
    }

    /**
     * Get the authors of given book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors()
    {
        return $this->belongsToMany('Medlib\Models\Author', 'book_author');
    }
}
