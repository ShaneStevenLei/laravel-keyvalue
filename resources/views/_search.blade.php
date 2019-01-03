<div class="search m-t-10">
    {!! Form::open(['method' => 'GET', 'class' => 'form-inline']) !!}

    <div class="col-xs-12">
        <div class="form-group">
            {{ Form::text('kv_key', $searchModel->kv_key, [
                'class' => 'form-control search-input',
                'maxlength' => '45',
                'placeholder' => __('keyvalue.attributes.kv_key')
            ]) }}
        </div>
        <div class="form-group">
            {{ Form::text('kv_value', $searchModel->kv_value, [
                'class' => 'form-control search-input',
                'maxlength' => '45',
                'placeholder' =>  __('keyvalue.attributes.kv_value')
            ]) }}
        </div>
        <div class="form-group">
            {{ Form::select('kv_status', StevenLei\LaravelKeyValue\Models\KeyValue::status(), $searchModel->kv_status, [
                'class' => 'form-control search-select',
                'placeholder' => __('keyvalue.attributes.kv_status')
            ]) }}
        </div>
    </div>

    <div class="col-xs-12">
        <div class="form-group">
            {{ Form::button(__('keyvalue.btn.search'), ['class' => 'btn btn-primary search-btn', 'type' => 'submit']) }}
            {{ Form::button(__('keyvalue.btn.reset'), ['class' => 'btn btn-secondary search-btn clear-form']) }}
            <a href="{{ route('keyvalue.create') }}">{{ Form::button(__('keyvalue.btn.create'), ['class' => 'btn btn-success search-btn']) }}</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
