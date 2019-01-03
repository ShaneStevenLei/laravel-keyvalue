@extends('kv::layout')

@section('content')
    <section class="page-content container-fluid">
        @include('kv::_form', ['model' => $model, 'title' => __('keyvalue.btn.create') . __('keyvalue.name')])
    </section>
@endsection