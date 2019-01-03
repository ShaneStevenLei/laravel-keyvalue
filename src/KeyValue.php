<?php
/*
 * This file is part of the stevenlei/laravel-keyvalue.
 *
 * (c) stevnelei <shanestevenlei@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace StevenLei\LaravelKeyValue;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use StevenLei\LaravelKeyValue\Exceptions\KeyValueErrorTypeException;
use StevenLei\LaravelKeyValue\Exceptions\KeyValueNotFoundException;
use StevenLei\LaravelKeyValue\Models\KeyValue as KeyValueModel;

/**
 * Class KeyValue
 *
 * @package StevenLei\LaravelKeyValue
 */
class KeyValue
{
    /**
     * @param string $key
     * @param bool   $throwException
     *
     * @return mixed|null|string
     * @throws KeyValueNotFoundException
     */
    public function getValue($key, $throwException = false)
    {
        $value = null;

        $value = $this->getCacheValue($key);
        if (is_null($value)) {
            $model = KeyValueModel::findKey($key);

            if ($model) {
                $value = trim($model->kv_value);

                $this->setCacheValue($key, $value);
            }
        }

        if (is_null($value)) {
            throw new KeyValueNotFoundException(__('keyvalue.message.resource.not_found'));
        }

        return $value;
    }

    /**
     * @param string $key
     * @param bool   $throwException
     *
     * @return array|mixed|null
     * @throws KeyValueErrorTypeException
     */
    public function getArrayValue($key, $throwException = false)
    {
        $value      = $this->getValue($key, $throwException);
        $arrayValue = json_decode($value, true);

        if ($throwException === true && !is_array($arrayValue)) {
            throw new KeyValueErrorTypeException(__('keyvalue.message.value.type.error', [
                'key'  => $key,
                'type' => 'array',
            ]));
        }

        return is_array($arrayValue) ? $arrayValue : null;
    }

    /**
     * @param string $key
     * @param bool   $throwException
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function getCollectionValue($key, $throwException = false)
    {
        $arrayValue = $this->getArrayValue($key, $throwException);

        return !is_null($arrayValue) ? collect($arrayValue) : null;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getCacheValue($key)
    {
        return Cache::get($key);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $userId
     * @param string                   $userName
     *
     * @return \StevenLei\LaravelKeyValue\Models\KeyValue
     */
    public function setValue(Request $request, $userId, $userName)
    {
        $model = new KeyValueModel();
        $model->fill(array_merge($request->all(), [
            'kv_created_user_id' => $userId,
            'kv_created_user'    => $userName,
            'kv_updated_user_id' => $userId,
            'kv_updated_user'    => $userName,
        ]));

        if ($model->save()) {
            $this->setCacheValue($model->kv_key, $model->kv_value);
        }

        return $model;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @param int                      $userId
     * @param string                   $userName
     */
    public function updateValue(Request $request, $id, $userId, $userName)
    {
        $model = $this->findModel($id);
        $model->fill(array_merge($request->all(), [
            'kv_updated_user_id' => $userId,
            'kv_updated_user'    => $userName,
        ]));

        if ($model->save()) {
            $this->updateCacheValue($model->kv_key, $model->kv_value);
        }
    }

    /**
     * @param $id
     * @param $userId
     * @param $userName
     *
     * @return bool|null
     */
    public function deleteValue($id, $userId, $userName)
    {
        $model = $this->findModel($id);

        kv_delete_cache($model->kv_key);

        $model->kv_deleted_user_id = $userId;
        $model->kv_deleted_user    = $userName;

        return $model->delete();
    }

    /**
     * @param $id
     *
     * @return null|\StevenLei\LaravelKeyValue\Models\KeyValue
     * @throws \StevenLei\LaravelKeyValue\Exceptions\KeyValueNotFoundException
     */
    public function findModel($id)
    {
        if (($model = KeyValueModel::findId($id)) == null) {
            throw new KeyValueNotFoundException(__('keyvalue.message.resource.not_found'));
        }

        return $model;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setCacheValue($key, $value)
    {
        Cache::put($key, $value, config('keyvalue.ttl'));
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function deleteCacheValue($key)
    {
        return Cache::forget($key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function updateCacheValue($key, $value)
    {
        $this->deleteCacheValue($key) && $this->setCacheValue($key, $value);
    }
}
