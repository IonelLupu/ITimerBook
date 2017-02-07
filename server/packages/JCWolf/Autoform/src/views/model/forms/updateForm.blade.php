<form method="POST" enctype="multipart/form-data" @if( !is_null($route) ) action="{{ $route }}" @endif>
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <input name="_model" type="hidden" value="{{ get_class($model) }}">

    @foreach($inputs as $input)
        @if( $input->isVisible() )
            {!! $input !!}
        @endif
    @endforeach

    <input class="btn btn-danger" type="submit" value="Update">
</form>