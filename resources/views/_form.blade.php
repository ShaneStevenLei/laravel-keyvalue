{!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="card card-pills">
    <div class="card-header">
        <div class="card-title">{{ $title }}</div>
        <a href="{{ route('keyvalue.index') }}">
            {{ Form::button(__('keyvalue.btn.back'), ['class' => 'btn btn-sm btn-secondary btn-outline-secondary btn-flat m-r-10 float-right']) }}
        </a>
    </div>
    <div class="card-body">
        <div class="form-group">
            {{ Form::label('kv_key', __('keyvalue.attributes.kv_key'), ['class' => 'control-label']) }}
            {{ Form::text('kv_key', $model->kv_key, [
                'class' => 'form-control',
                'maxlength' => '45',
                'placeholder' => __('keyvalue.attributes.kv_key')
            ]) }}
        </div>
        <div class="form-group">
            {{ Form::label('kv_status', __('keyvalue.attributes.kv_status'), ['class' => 'control-label']) }}
            {{ Form::select(
                'kv_status',
                StevenLei\LaravelKeyValue\Models\KeyValue::status(),
                $model->kv_status, ['class' => 'form-control']
            ) }}
        </div>
        <div class="form-group">
            {{ Form::label('kv_value', __('keyvalue.attributes.kv_value'), ['class' => 'control-label']) }}
            {{ Form::textarea('kv_value', $model->kv_value, [
                'class' => 'form-control',
                'style' => 'resize:none;',
                'rows' => 20,
                'placeholder' => __('keyvalue.attributes.kv_value'),
                'id' => 'source'
            ]) }}
            <pre id="result" class="fail" style="display: none; color: red;"></pre>
        </div>
        <div class="form-group">
            {{ Form::label('kv_memo', __('keyvalue.attributes.kv_memo'), ['class' => 'control-label']) }}
            {{ Form::textarea('kv_memo', $model->kv_memo, [
                'class' => 'form-control',
                'placeholder' => __('keyvalue.attributes.kv_memo'),
                'maxlength' => '100',
                'style' => 'resize:none;',
                'rows' => 4
            ]) }}
        </div>
    </div>
    <div class="card-footer bg-light">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            {{ Form::submit(__('keyvalue.btn.save'), ['class' => 'btn btn-success btn-flat']) }}
        </div>
    </div>
</div>
{!! Form::close() !!}

<div id="template">
    <div id="template-content" style="display: none" class="btn-group btn-group-toggle" data-toggle="buttons">
        <label id="text-content" onclick="sourceFormat(1)" class="btn btn-sm btn-secondary btn-flat active">
            <input type="radio" name="options" autocomplete="off" checked>Text
        </label>
        <label id="json-content" onclick="sourceFormat(2)" class="btn btn-sm btn-secondary btn-flat">
            <input type="radio" name="options" autocomplete="off">JSON
        </label>
    </div>
</div>

@section('js')
    <script src="/vendor/laravel-keyvalue/auto-line-number.js"></script>
    <script src="/vendor/laravel-keyvalue/jsonsh.js"></script>
    <script src="/vendor/laravel-keyvalue/clipboard.js"></script>
    <script>
        $(document).ready(function () {
            $('#source').setTextareaCount().after($('#template').html());
            jsonsh.is_pretty = false;
            $('#template-content').show();
        });
        var sourceFormat = function (type) {
            if (type === 1) {
                $('#result').html('').hide();
                jsonsh.is_pretty = false;
                return false;
            }
            $('#source').focus();
            jsonsh.make_pretty();
        };
    </script>
@endsection
