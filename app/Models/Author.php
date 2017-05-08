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
     * @param string $firstName
     * @param string $lastName
     * @param string $biography
     * @return Author
     */
    public static function register(string $firstName, string $lastName, string $biography)
    {
        $author = new static([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'biography' => $biography
        ]);

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
