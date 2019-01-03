@extends('layouts.main', ['title' => __('keyvalue.title') ])

<style>
    .no-padding {
        padding: 0 !important;
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #f9f9f9 !important;
    }

    .table th, .table td {
        word-break: keep-all !important;
    }

    .btn-flat {
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
    }

    .control-label {
        font-weight: bold !important;
    }

    .form-inline .form-group {
        display: inline-block !important;
        margin-bottom: 15px !important;
        vertical-align: middle;
    }

    .col-xs-12 {
        width: 100% !important;
    }

    .search .search-btn {
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
        border-width: 1px !important;
    }

    .search .search-btn, .search .search-input, .search .search-select {
        width: 200px !important;
        height: 35px !important;
        border-radius: 0;
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        -khtml-border-radius: 0;
        -webkit-appearance: button;
    }

    .search .search-input {
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
        border: 1px solid #d2d6de;
    }

    .m-r-10 {
        margin-right: 10px !important;
    }

    .card.card-pills .card-header {
        padding: 15px 20px;
    }

    .card.card-pills .card-header .card-title {
        position: absolute;
        left: 20px;
        top: 20px;
        margin: 0;
    }
</style>

@section('content')

    @yield('content')

@endsection

@section('javascript')
    <script>
        $(".clear-form").click(function () {
            $(this).closest("form").find(":input").val("");
            $(this).closest("form").find(":checkbox").prop("checked", false);
            $(this).closest("form").find(":radio").prop("checked", false);
        });
        var postDelete = function (obj) {
            var method = obj.attr('data-method').toUpperCase();
            var confirmMessage = obj.attr('data-confirm');
            var url = obj.attr('data-href');
            var data = obj.attr('data-data');
            if (method === 'POST') {
                if (window.confirm(confirmMessage)) {
                    obj.attr('disabled', 'true');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: method,
                        dataType: 'json',
                        url: url,
                        data: data,
                        success: function (response) {
                            alert(response.message);
                            if (response.code === 0) {
                                window.location.href = obj.attr('data-redirect-href');
                            }
                            obj.removeAttr('disabled');
                        },
                        error: function (response) {
                            obj.removeAttr('disabled');
                        }
                    });
                }
            }
        }
    </script>

    @yield('js')
@endsection