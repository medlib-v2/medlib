<?php

namespace Medlib\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    public $table = 'settings';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'key',
        'value',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'    => 'integer',
        'key'   => 'string',
        'value' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [

    ];

    public static function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $arrayKey => $arrayValue) {
                $setting = self::firstOrNew(['key' => $arrayKey]);
                $setting->value = $arrayValue;
                $setting->save();
            }
        } else {
            $setting = self::firstOrNew(['key' => $key]);
            $setting->value = $value;
            $setting->save();
        }

        return true;
    }

    /**
     * @param string $key
     * @param string $default
     * @return mixed|string
     */
    public static function get($key, $default = '')
    {
        $result = '';
        if (Schema::hasTable('settings')) {
            $value = self::where('key', $key)->pluck('value');
            foreach ($value as $val) {
                $result = $val;
            }

            return $value ? $result : $default;
        }

        return $default;
    }

    /**
     * @param string $key
     */
    public static function remove($key)
    {
        $setting = self::where('key', $key);
        $setting->delete();
    }

    /**
     * Serialize the setting value before saving into the database.
     * This makes settings more flexible.
     *
     * @param mixed $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = serialize($value);
    }

    public function getValueAttribute($value)
    {
        return unserialize($value);
    }
}
