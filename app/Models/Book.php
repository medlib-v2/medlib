<?php

namespace Medlib\Models;

use Medlib\Models\Author;
use Medlib\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'books';

    //protected $primaryKey = 'book_id';

    protected $guarded = ['book_id'];

    public $incrementing = true;

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
     * @param int $bookIsbn
     * @return mixed
     */
    public function getInformationBooksByISBN(int $bookIsbn)
    {
        return DB::table('friends')->where('book_isbn', $bookIsbn)->first();
    }

    /**
     * Return the title this current book
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Return the isbn this current book
     *
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Return the issn this current book
     *
     * @return mixed
     */
    public function getIssn()
    {
        return $this->issn;
    }
}
