<?php
namespace StevenLei\LaravelKeyValue\Models;

/**
 * Trait ModelTrait
 *
 * @package StevenLei\LaravelKeyValue\Models
 *
 * @mixin \Eloquent
 * @method static mixed filterWhere($query, $column, $value = null, $operator = '=')
 * @method static mixed filterLike($query, $column, $value = null, $fuzzyMatch = false)
 */
trait ModelTrait
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $column
     * @param mixed                                 $value
     * @param string                                $operator
     *
     * @return mixed
     */
    public function scopeFilterWhere($query, $column, $value = null, $operator = '=')
    {
        if (!in_array($column, $this->fillable)) {
            return $query;
        }

        if (is_null($value) || mb_strlen(trim($value)) == 0) {
            return $query;
        }

        $query->where($column, $operator, $value);

        return $query;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $column
     * @param mixed                                 $value
     * @param bool                                  $fuzzyMatch
     *
     * @return mixed
     */
    public function scopeFilterLike($query, $column, $value = null, $fuzzyMatch = false)
    {
        if (!in_array($column, $this->fillable)) {
            return $query;
        }

        if (is_null($value) || mb_strlen(trim($value)) == 0) {
            return $query;
        }

        $query->where($column, 'like', $fuzzyMatch ? $value . '%' : $value);

        return $query;
    }
}
