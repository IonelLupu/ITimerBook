

<style>

    .tab-content .tab-pane table.table{
        background-color : #eee;
    }

</style>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#edit" data-toggle="tab" aria-expanded="true">Edit</a>
        </li>
        <li class="">
            <a href="#relationships" data-toggle="tab" aria-expanded="false">Relationships</a>
        </li>

        {{-- Settings Icon --}}
        {{--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>--}}
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="edit">

            <section class="content">
                {!! Autoform::updateForm($model,$route) !!}
            </section>
        </div>
        <div class="tab-pane" id="relationships">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">

                    @foreach( Autoform::getRelationships($model) as $index => $relationship )

                        <li @if( $index == 0 )class="active" @endif>
                            <a href="#{{ $relationship->name }}" data-toggle="tab" aria-expanded="true">
                                {{$relationship->name }}
                            </a>
                        </li>

                    @endforeach

                </ul>
                <div class="tab-content">

                    @foreach( Autoform::getRelationships($model) as $index => $relationship )


                        <div class="tab-pane active" id="{{$relationship->name }}">
                            @if(count($relationship->values()))

                                {!! Autoform::listModel( $relationship->getRelatedModel(), $relationship->values() ) !!}

                                <hr>
                            @endif

                                <h3>Add a new {{$relationship->name }}</h3>

                                {!! Autoform::createForm($relationship->getRelatedModel() , route('model.add',[ "model" => str_singular($relationship->name) ]) ) !!}

                        </div>
                    @endforeach

                </div>
            </div>


        </div>
    </div>
</div>

