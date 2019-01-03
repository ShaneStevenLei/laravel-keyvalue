@extends('kv::layout')

@section('content')
    <section class="page-content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{ __('keyvalue.title') }}</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @include('kv::_search', ['searchModel' => $searchModel])

                    {{ Form::open(['method' => 'POST', 'id' => 'data-form']) }}
                    <table class="table table-bordered">
                        <thead style="background-color: #098ddf; color: #ffffff;">
                        <tr>
                            <th>{{ __('keyvalue.attributes.kv_key') }}</th>
                            <th>{{ __('keyvalue.attributes.kv_status') }}</th>
                            <th>{{ __('keyvalue.attributes.kv_value') }}</th>
                            <th>{{ __('keyvalue.attributes.kv_memo') }}</th>
                            <th>{{ __('keyvalue.attributes.kv_created_user') }}</th>
                            <th>{{ __('keyvalue.attributes.kv_created_at') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($models as $model)
                            <tr>
                                <td>{{ $model->kv_key }}</td>
                                <td>{{ StevenLei\LaravelKeyValue\Models\KeyValue::status()[$model->kv_status] }}</td>
                                <td>{{ mb_strlen($model->kv_value) > 20 ? mb_substr($model->kv_value, 0, 20) . '...' :  $model->kv_value}}</td>
                                <td>{{ mb_strlen($model->kv_memo) > 20 ? mb_substr($model->kv_memo, 0, 20) . '...' :  $model->kv_memo}}</td>
                                <td>{{ $model->kv_created_user }}</td>
                                <td>{{ $model->kv_created_at }}</td>
                                <td>
                                    <a href="{{ route('keyvalue.view', ['id' => $model->kv_id]) }}">
                                        {{ Form::button(__('keyvalue.btn.view'), ['class' => 'btn btn-sm btn-secondary btn-flat btn-outline btn-outline-secondary' ]) }}
                                    </a>
                                    <a href="{{ route('keyvalue.update', ['id' => $model->kv_id]) }}">
                                        {{ Form::button(__('keyvalue.btn.update'), ['class' => 'btn btn-sm btn-info btn-outline btn-outline-info btn-flat']) }}
                                    </a>
                                    <a href="javascript:void(0);" onclick="postDelete($(this));"
                                       data-href="{{ route('keyvalue.delete', ['id' => $model->kv_id]) }}"
                                       data-redirect-href="{{ route('keyvalue.index') }}"
                                       data-post-data="{}" data-confirm="{{ __('keyvalue.message.delete.confirm') }}" data-method="post">
                                        {{ Form::button('删除', [
                                            'class' => 'btn btn-sm btn-accent btn-flat m-r-10 btn-outline'
                                        ]) }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="card-footer">
                {!! $models->appends($searchModel->toArray())->links() !!}
            </div>
        </div>
    </section>
@endsection
