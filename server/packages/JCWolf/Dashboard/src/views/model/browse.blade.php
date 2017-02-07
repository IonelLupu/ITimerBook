@extends('Dashboard::layouts.dashboard')

@section('assets')
    @include('Dashboard::partials.dataTableAssets')

    <style>
        
        .content > table.table{
            background-color : #fff;
        }
    </style>
@endsection

@section('content')

    <section class="content-header">
        <h1>
            {{ str_plural($model->getModelName()) }}

            <a href="{{ route('model.new',[
                                'model' => $model->getModelName(true)
                            ])
                      }}" class="btn btn-primary">
                Add {{ $model->getModelName(true) }}
            </a>
        </h1>
    </section>

    <section class="content">

        {!! Autoform::listModel($model) !!}
        {{--<table class="table table-bordered table-hover dataTable">--}}
            {{--<thead>--}}
            {{--<tr>--}}

                {{--<th>#</th>--}}

                {{--@foreach( Autoform::getInputs($model) as $field )--}}

                    {{--@if( $field->properties['table']['visible'] )--}}
                        {{--<th>{!! $field->label !!} </th>--}}

                    {{--@endif--}}
                {{--@endforeach--}}

                {{--<th></th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}

            {{--@foreach( $model->all() as $index => $record )--}}
                {{--<tr class="data-row">--}}
                    {{--<td>{{ $index+1 }}</td>--}}

                    {{--@foreach( Autoform::getInputs($record) as $field )--}}
                        {{--@if( $field->properties['table']['visible'] )--}}
                            {{--<td>{!! $field->view() !!} </td>--}}
                        {{--@endif--}}
                    {{--@endforeach--}}

                    {{--<td class="dataTable-actions">--}}

                        {{--{{ link_to_route('model.edit', "Edit" ,--}}
                                  {{--[ 'model' => $record->getModelName(true),--}}
                                    {{--'id' => $record->id ],--}}
                                  {{--["class" => "btn btn-primary"])--}}
                         {{--}}--}}

                        {{--{{ link_to_route('model.delete', "Delete" ,--}}
                                  {{--[ 'model' => $record->getModelName(true),--}}
                                    {{--'id' => $record->id ],--}}
                                  {{--["class" => "btn btn-danger"])--}}
                         {{--}}--}}

                    {{--</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}

            {{--</tbody>--}}
        {{--</table>--}}
    </section>

    <script>
        $( function () {
            $( '.dataTable' ).DataTable( {
                "paging"       : true,
                "lengthChange" : false, // how many items per page
                "searching"    : true,
                "ordering"     : true,
                "info"         : true,
                "autoWidth"    : true
            } );
        } );
    </script>
@endsection

