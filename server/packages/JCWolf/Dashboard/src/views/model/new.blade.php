@extends('Dashboard::layouts.dashboard')


@section('topAssets')
    <link rel="stylesheet" href="/dashboard/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="/dashboard/plugins/datetimepicker/bootstrap-datetimepicker.min.css">
@endsection

@section('assets')
    <script src="/dashboard/plugins/select2/select2.full.min.js"></script>
    {{--<script src="https://momentjs.com/downloads/moment.js"></script>--}}

    <script src="/dashboard/plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script>

    <script>
        $( ".select2" ).select2( {
            tags      : true,
            createTag : function ( params ) {
                return {
                    id     : params.term,
                    text   : params.term,
                    newTag : true // add additional parameters
                }
            }
        } );

        //Date picker
        $( '.datepicker' ).datetimepicker( {
            format : "YYYY-MM-DD HH:mm:ss"
        } );

    </script>
@endsection

@section('content')

    <section class="content-header">
        <h1>
            Add new {{ $model->getModelName() }}
            {{--<small>range sliders</small>--}}
        </h1>
    </section>


    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1" data-toggle="tab" aria-expanded="true">Tab 1</a>
            </li>
            <li class="">
                <a href="#tab_2" data-toggle="tab" aria-expanded="false">Tab 2</a>
            </li>
            <li class="">
                <a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a>
            </li>

            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">

                <section class="content">
                    {!! Autoform::addForm($model) !!}
                </section>
            </div>
            <div class="tab-pane" id="tab_2">
                sdf
            </div>
            <div class="tab-pane" id="tab_3">
                sdf
            </div>
        </div>
    </div>


@endsection

