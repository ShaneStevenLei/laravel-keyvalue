<?php
/*
 * This file is part of the stevenlei/laravel-keyvalue.
 *
 * (c) stevnelei <shanestevenlei@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use StevenLei\LaravelKeyValue\Exceptions\KeyValueErrorTypeException;
use StevenLei\LaravelKeyValue\KeyValue;

if (!function_exists('kv')) {
    /**
     * @return \Illuminate\Foundation\Application|mixed|\StevenLei\LaravelKeyValue\KeyValue
     */
    function kv()
    {
        return app(KeyValue::class);
    }
}

if (!function_exists('kv_model')) {
    /**
     * @param $id
     *
     * @return null|\StevenLei\LaravelKeyValue\Models\KeyValue
     */
    function kv_model($id)
    {
        return app(KeyValue::class)->findModel($id);
    }
}

if (!function_exists('kv_set')) {
    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $userId
     * @param string                   $userName
     *
     * @return \StevenLei\LaravelKeyValue\Models\KeyValue
     */
    function kv_set(\Illuminate\Http\Request $request, $userId, $userName)
    {
        return app(KeyValue::class)->setValue($request, $userId, $userName);
    }
}

if (!function_exists('kv_get')) {
    /**
     * @param string $key
     * @param string $type
     * @param bool   $throwException
     *
     * @return array|\Illuminate\Support\Collection|mixed|null|string
     * @throws \StevenLei\LaravelKeyValue\Exceptions\KeyValueErrorTypeException
     */
    function kv_get($key, $type = KeyValue::TYPE_STRING, $throwException = true)
    {
        switch ($type) {
            case KeyValue::TYPE_STRING:
                return app(KeyValue::class)->getValue($key, $throwException);
            case KeyValue::TYPE_JSON:
                return app(KeyValue::class)->getJsonValue($key, $throwException);
            case KeyValue::TYPE_ARRAY:
                return app(KeyValue::class)->getArrayValue($key, $throwException);
            case KeyValue::TYPE_COLLECTION:
                return app(KeyValue::class)->getCollectionValue($key, $throwException);
            default:
                throw new KeyValueErrorTypeException(__('keyvalue.message.value.type.error', [
                    'key'  => $key,
                    'type' => $type,
                ]));
        }
    }
}

if (!function_exists('kv_delete')) {
    /**
     * @param int    $id
     * @param int    $userId
     * @param string $userName
     *
     * @return bool|null
     */
    function kv_delete($id, $userId, $userName)
    {
        return app(KeyValue::class)->deleteValue($id, $userId, $userName);
    }
}

if (!function_exists('kv_delete_cache')) {
    /**
     * @param $key
     *
     * @return bool|null
     */
    function kv_delete_cache($key)
    {
        return app(KeyValue::class)->deleteCacheValue($key);
    }
}

if (!function_exists('kv_update')) {
    /**
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @param int                      $userId
     * @param string                   $userName
     */
    function kv_update(\Illuminate\Http\Request $request, $id, $userId, $userName)
    {
        return app(KeyValue::class)->updateValue($request, $id, $userId, $userName);
    }
}
