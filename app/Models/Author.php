<?php

namespace Medlib\Models;

use Medlib\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{

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
    protected $fillable = ['first_name', 'last_name', 'biography'];

    /**
     * Books owned by Author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_author');
        //return $this->hasMany(Medlib\Models\Book::class);
    }

    /**
     * Register a new Author.
     *
     * @param $first_name
     * @param $last_name
     * @param $biography
     * @return static
     */
    public static function register($first_name, $last_name, $biography)
    {
        $author = new static(compact('first_name', 'last_name', 'biography'));

        return $author;
    }

    /**
     * Return the name of this current user
     * @return null|string
     */
    public function getName()
    {
        if ($this->first_name && $this->last_name) {
            return Str::ucfirst($this->first_name)." ".Str::upper($this->last_name);
        }

        if ($this->first_name) {
            return Str::ucfirst($this->first_name);
        }

        return null;
    }

    /**
     * Getter for biography
     *
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }
}
