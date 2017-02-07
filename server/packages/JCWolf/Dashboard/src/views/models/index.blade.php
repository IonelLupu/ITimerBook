@extends('Dashboard::layouts.dashboard')


@section('assets')
    @include('Dashboard::partials.dataTableAssets')
@endsection

@section('content')

    <section class="content-header">
        <h1>
            Applications Models

            <a href="{{ route('models.create') }}" class="btn btn-primary">
                Add new Model
            </a>
        </h1>
    </section>

    <section class="content">

        <table class="table table-bordered table-hover dataTable">
            <thead>
            <tr>

                <th>#</th>

                <th>Name</th>
                <th>Fields</th>

                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach( $models as $index => $record )
                <tr class="data-row">
                    <td>{{ $index+1 }}</td>

                    {{--@foreach( Autoform::getInputs($record) as $field )--}}

                    <td>{{ $record->name }} </td>
                    <td>{{ implode(', ',array_keys($record->schema)) }} </td>

                    {{--@endforeach--}}

                    <td class="dataTable-actions">

                        {{ link_to_route('models.edit', "Edit" ,
                                  [ 'model' => $record->id ],
                                  ["class" => "btn btn-primary"])
                         }}

                        {{--{{ link_to_route('models.destroy', "Delete" ,--}}
                        {{--[ 'model' => $record->id ],--}}
                        {{--["class" => "btn btn-danger"])--}}
                        {{--}}--}}

                        <form action="{{ route('models.destroy', ["model" => $record->id ] ) }}" method="POST" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field("DELETE") }}
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>


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
@stop