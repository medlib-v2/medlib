<?php

namespace Medlib\Models;

use Medlib\Models\Author;
use Medlib\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Book extends Model {

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
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the authors of given book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    /**
     * Return all information this book
     * @param int $book_isbn
     * @return mixed
     */
    public function getInformationBooksByISBN(int $book_isbn) {
        return DB::table('friends')->where('book_isbn', $book_isbn)->first();
    }
}
