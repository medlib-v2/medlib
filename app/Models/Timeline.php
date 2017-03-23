<?php

namespace Medlib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timeline extends Model
{
    use SoftDeletes;
    /**
    * The database table used by the model.
    *
    * @var string
         */
    protected $table = 'timelines';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'username',
        'name',
        'avatar_id',
        'cover_id',
        'cover_position',
        'type',
        'deleted_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
    * The attributes excluded from the model's JSON form.
    * @var array
    */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'             => 'integer',
        'type'           => 'string',
        'username'       => 'string',
        'name'           => 'string',
        'avatar_id'      => 'integer',
        'cover_id'       => 'integer',
        'cover_position' => 'string',
        'deleted_at'     => 'datetime',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();

        $cover_url = $this->cover()->get()->toArray();
        $avatar_url = $this->avatar()->get()->toArray();
        $array['cover_url'] = $cover_url;
        $array['avatar_url'] = $avatar_url;


        if ($this->type == 'user') {
            $array['verified'] = $this->user()->first() ? $this->user()->first()->userAccountIsActive() : false;
        } else {
            $array['verified'] = $this->page()->first() ? $this->page()->first()->verified : false;
        }

        return $array;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar()
    {
        return $this->belongsTo(Media::class, 'avatar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cover()
    {
        return $this->belongsTo(Media::class, 'cover_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function page()
    {
        return $this->hasOne(Page::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function groups()
    {
        return $this->hasOne(Group::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reports()
    {
        return $this->belongsToMany(User::class, 'timeline_reports', 'timeline_id', 'reporter_id')->withPivot('status');
    }
}