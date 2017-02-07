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
        $( ".select2" ).select2();

        //Date picker
        $( '.datepicker' ).datetimepicker( {
            format : "YYYY-MM-DD HH:mm:ss"
        } );

    </script>
@endsection

@section('content')

    <section class="content-header">
        <h1>
            {{--<small>range sliders</small>--}}
        </h1>
    </section>

    {!! Autoform::editForm($model) !!}
{{--

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#edit" data-toggle="tab" aria-expanded="true"> Edit</a>
            </li>
            <li class="">
                <a href="#relationships" data-toggle="tab" aria-expanded="false">Relationships</a>
            </li>

            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="edit">

                <section class="content">
                    {!! Autoform::editForm($model) !!}
                </section>
            </div>
            <div class="tab-pane" id="relationships">


                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#books" data-toggle="tab" aria-expanded="true">Books</a>
                        </li>

                        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="books">
                            @if(count($model->books))
                                <table class="table" style="background: #eee">

                                    <thead>
                                    <tr>

                                        <th>#</th>

                                        @foreach( Autoform::getInputs($model->books[0]) as $field )

                                            @if( $field->properties['table']['visible'] )
                                                <th>{!! $field->label !!} </th>

                                            @endif
                                        @endforeach

                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach( $model->books as $index => $record )
                                        <tr class="data-row">
                                            <td>{{ $index+1 }}</td>

                                            @foreach( Autoform::getInputs($record) as $field )
                                                @if( $field->properties['table']['visible'] )
                                                    <td>{!! $field->view() !!} </td>
                                                @endif
                                            @endforeach

                                            <td class="dataTable-actions">

                                                {{ link_to_route('model.edit', "Edit" ,
                                                          [ 'model' => $record->getModelName(true),
                                                            'id' => $record->id ],
                                                          ["class" => "btn btn-primary"])
                                                 }}

                                                {{ link_to_route('model.delete', "Delete" ,
                                                          [ 'model' => $record->getModelName(true),
                                                            'id' => $record->id ],
                                                          ["class" => "btn btn-danger"])
                                                 }}

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            <hr>
                            <h3>Add a new Book</h3>
                            {!! Autoform::addForm($model->books[0] , route('model.add',[ "model" => "book" ]) ) !!}

                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
--}}



@endsection

