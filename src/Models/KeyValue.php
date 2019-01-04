<?php
/*
 * This file is part of the stevenlei/laravel-keyvalue.
 *
 * (c) stevnelei <shanestevenlei@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace StevenLei\LaravelKeyValue\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KeyValue
 *
 * @package StevenLei\LaravelKeyValue\Models
 *
 * @property int                 $kv_id
 * @property string              $kv_key
 * @property string              $kv_value
 * @property string              $kv_memo
 * @property string              $kv_status
 * @property int                 $kv_deleted
 * @property int                 $kv_created_user_id
 * @property string              $kv_created_user
 * @property int                 $kv_updated_user_id
 * @property string              $kv_updated_user
 * @property int                 $kv_deleted_user_id
 * @property string              $kv_deleted_user
 * @property \Carbon\Carbon|null $kv_created_at
 * @property \Carbon\Carbon|null $kv_deleted_at
 * @property \Carbon\Carbon|null $kv_updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|KeyValue whereKvKey($key)
 * @method static KeyValue search(array $params)
 * @method static KeyValue|null findId($id)
 * @method static KeyValue|null findKey($key)
 * @mixin \Eloquent
 */
class KeyValue extends Model
{
    use ModelTrait;

    public $timestamps = false;

    protected $table = 'key_value';

    protected $primaryKey = 'kv_id';

    protected $dates = [
        'kv_created_at',
        'kv_deleted_at',
        'kv_updated_at',
    ];

    protected $fillable = [
        'kv_key',
        'kv_value',
        'kv_memo',
        'kv_status',
        'kv_deleted',
        'kv_created_user_id',
        'kv_created_user',
        'kv_updated_user_id',
        'kv_updated_user',
        'kv_deleted_user_id',
        'kv_deleted_user',
        'kv_created_at',
        'kv_deleted_at',
    ];

    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';

    const FLAG_IS_DELETED     = 1;
    const FLAG_IS_NOT_DELETED = 0;

    public function delete()
    {
        $this->kv_deleted    = self::FLAG_IS_DELETED;
        $this->kv_deleted_at = Carbon::now();

        return $this->save();
    }

    /**
     * @param self  $query
     * @param array $params
     *
     * @return mixed
     */
    public function scopeSearch($query, $params)
    {
        $this->fill($params);

        return $query->where('kv_deleted', '!=', self::FLAG_IS_DELETED)
            ->filterLike('kv_key', $this->kv_key, true)
            ->filterLike('kv_value', $this->kv_value, true)
            ->filterWhere('kv_status', $this->kv_status)
            ->paginate(20);
    }

    /**
     * @param self $query
     * @param int  $id
     *
     * @return mixed
     */
    public function scopeFindId($query, $id)
    {
        return $query->whereKey($id)->where('kv_deleted', self::FLAG_IS_NOT_DELETED)->first();
    }

    /**
     * @param self   $query
     * @param string $key
     *
     * @return mixed
     */
    public function scopeFindKey($query, $key)
    {
        return $query->whereKvKey($key)
            ->where('kv_status', self::STATUS_ACTIVE)
            ->where('kv_deleted', self::FLAG_IS_NOT_DELETED)
            ->first();
    }

    /**
     * @return array
     */
    public static function status()
    {
        return [
            self::STATUS_ACTIVE   => __('keyvalue.status.active'),
            self::STATUS_INACTIVE => __('keyvalue.status.inactive'),
        ];
    }
}
