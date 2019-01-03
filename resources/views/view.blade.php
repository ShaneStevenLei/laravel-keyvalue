@extends('kv::layout')

@section('content')
    <section class="page-content container-fluid">
        <div class="card card-pills">
            <div class="card-header">
                <div class="card-title">{{ __('keyvalue.name') }} - {{ $model->kv_key }}</div>
                <a href="javascript:void(0);" onclick="postDelete($(this));"
                   data-href="{{ route('keyvalue.delete', ['id' => $model->kv_id]) }}"
                   data-redirect-href="{{ route('keyvalue.index') }}"
                   data-post-data="{}" data-confirm="{{ __('keyvalue.message.delete.confirm') }}" data-method="post">
                    {{ Form::button('删除', [
                        'class' => 'btn btn-sm btn-accent btn-flat m-r-10 btn-outline float-right'
                    ]) }}
                </a>
                <a href="{{ route('keyvalue.update', ['id' => $model->kv_id]) }}">
                    {{ Form::button(__('keyvalue.btn.update'), ['class' => 'btn btn-sm btn-info btn-outline btn-flat m-r-10 btn-outline-info float-right' ]) }}
                </a>
                <a href="{{ route('keyvalue.create') }}">
                    {{ Form::button(__('keyvalue.btn.create'), ['class' => 'btn btn-sm btn-success btn-outline btn-flat m-r-10 btn-outline-success float-right']) }}
                </a>
                <a href="{{ route('keyvalue.index') }}">
                    {{ Form::button(__('keyvalue.btn.back'), ['class' => 'btn btn-sm btn-secondary btn-outline btn-flat m-r-10 btn-outline-secondary float-right']) }}
                </a>
            </div>
            <div class="card-body no-padding">
                <table class="table table-striped table-bordered detail-view">
                    <tr>
                        <th style="width: 10%;">{{ __('keyvalue.attributes.kv_key') }}</th>
                        <td>{{ $model->kv_key }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('keyvalue.attributes.kv_status') }}</th>
                        <td>{{ StevenLei\LaravelKeyValue\Models\KeyValue::status()[$model->kv_status] }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('keyvalue.attributes.kv_value') }}</th>
                        <td>
                            <a class="btn btn-link btn-copy" href="javascript:void(0);" data-clipboard-action="copy" data-clipboard-target="#source">{{ __('keyvalue.message.copy.link') }}</a>
                            <div style='word-break: break-all;word-wrap: break-word'>
                                <textarea style='width: 100%;resize:none;' rows='20' readonly
                                          id='source'>{{ $model->kv_value }}</textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ __('keyvalue.attributes.kv_value') }}</th>
                        <td>{{ $model->kv_value }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('keyvalue.attributes.kv_memo') }}</th>
                        <td>{{ $model->kv_memo }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('keyvalue.attributes.kv_created_user') }}</th>
                        <td>{{ $model->kv_created_user }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('keyvalue.attributes.kv_updated_user') }}</th>
                        <td>{{ $model->kv_updated_user }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('keyvalue.attributes.kv_created_at') }}</th>
                        <td>{{ $model->kv_created_at }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('keyvalue.attributes.kv_updated_at') }}</th>
                        <td>{{ $model->kv_updated_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="/vendor/laravel-keyvalue/auto-line-number.js"></script>
    <script src="/vendor/laravel-keyvalue/jsonsh.js"></script>
    <script src="/vendor/laravel-keyvalue/clipboard.js"></script>
    <script>
        var clipboard = new ClipboardJS('.btn-copy');

        clipboard.on('success', function(e) {
            alert("{{__('keyvalue.message.copy.success')}}");
            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            alert("{{__('keyvalue.message.copy.fail')}}");
            e.clearSelection();
        });
    </script>
@endsection
