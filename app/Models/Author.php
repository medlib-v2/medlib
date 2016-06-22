<?php

namespace Medlib\Models;

use Medlib\Models\Book;
use Illuminate\Database\Eloquent\Model;

class Author extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'authors';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['frist_name', 'last_name'];
    /**
     * Books owned by Author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_author');
        //return $this->hasMany('Medlib\Models\Book');
    }
}