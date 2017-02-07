@extends('Dashboard::layouts.dashboard')


@section('topAssets')
    <link rel="stylesheet" href="/lib/select2/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.js"></script>
@endsection

@section('assets')
    <script src="/lib/select2/select2.full.min.js"></script>

    <script>

        $( function () {
            $( ".sortable" ).sortable( {
                "handle" : ".handle"
            } );
            $( ".select2" ).select2();

        } )

    </script>

    <style>
        .select2 {
            width : 250px !important;
        }
    </style>

@endsection

@section('content')

    <section class="content-header">
        <h1>
            Edit {{ $model->name }} Model
        </h1>
    </section>

    <section class="content">

        @include('Dashboard::models.modelForm',[
            "method" => "PATCH",
            "route" => [
                "name" => "models.update",
                "params" => ['model' => $model->id]
            ],
            "schema" => $model->schema,
            "button" => "Update"
        ])

    </section>

@stop