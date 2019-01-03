<?php
/*
 * This file is part of the stevenlei/laravel-keyvalue.
 *
 * (c) stevnelei <shanestevenlei@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace StevenLei\LaravelKeyValue\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use StevenLei\LaravelKeyValue\Models\KeyValue;

class KeyValueController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $searchModel = new KeyValue();
        $models      = $searchModel->search($request->all());

        return view('kv::index', compact('searchModel', 'models'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $model = new KeyValue();
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->validate($request, $this->createRules(), [], $this->attributes());

            $username = config('keyvalue.username');
            $model    = kv_set($request, auth()->id(), auth()->user()->$username);

            if ($model->kv_id) {
                return redirect()->route('keyvalue.view', ['id' => $model->kv_id]);
            }
        }

        return view('kv::create', compact('model'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $this->validate($request, $this->updateRules($id, $request->get('kv_key')), [], $this->attributes());

            $username = config('keyvalue.username');

            kv_update($request, $id, auth()->id(), auth()->user()->$username);

            return redirect()->route('keyvalue.view', ['id' => $id]);
        }
        $model = kv_model($id);

        return view('kv::update', compact('model'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Request $request, $id)
    {
        $model = kv_model($id);

        return view('kv::view', compact('model'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        try {
            $username = config('keyvalue.username');
            kv_delete($id, auth()->id(), auth()->user()->$username);

            return response()->json([
                'code'    => 0,
                'message' => __('keyvalue.message.delete.success'),
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'code'    => -1,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * @return array
     */
    protected function createRules()
    {
        return [
            'kv_key'    => [
                'bail',
                'required',
                Rule::unique('key_value')->where(function ($query) {
                    return $query->where('kv_deleted', '!=', KeyValue::FLAG_IS_DELETED);
                }),
                'max:100',
            ],
            'kv_value'  => 'bail|required',
            'kv_status' => [
                'bail',
                'required',
                Rule::in(array_keys(KeyValue::status())),
            ],
            'kv_memo'   => 'max:255',
        ];
    }

    /**
     * @param $id
     * @param $key
     *
     * @return array
     */
    protected function updateRules($id, $key)
    {
        return [
            'kv_key'    => [
                'bail',
                'required',
                Rule::unique('key_value')->ignore($id, 'kv_id')->where(function ($query) {
                    return $query->where('kv_deleted', '!=', KeyValue::FLAG_IS_DELETED);
                }),
                'max:100',
            ],
            'kv_value'  => 'bail|required',
            'kv_status' => [
                'bail',
                'required',
                Rule::in(array_keys(KeyValue::status())),
            ],
            'kv_memo'   => 'max:255',
        ];
    }

    /**
     * @return array
     */
    protected function attributes()
    {
        return [
            'kv_key'    => __('keyvalue.attributes.kv_key'),
            'kv_value'  => __('keyvalue.attributes.kv_value'),
            'kv_status' => __('keyvalue.attributes.kv_status'),
            'kv_memo'   => __('keyvalue.attributes.kv_memo'),
        ];
    }
}
