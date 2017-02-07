<form method="POST" enctype="multipart/form-data" @if( !is_null($route) ) action="{{ $route }}" @endif>
    {{ csrf_field() }}
    <input name="_model" type="hidden" value="{{ get_class($model) }}">

    @foreach($inputs as $input)
        @if( $input->isVisible() )
            {!! $input !!}
        @endif
    @endforeach

    <input class="btn btn-danger" type="submit" value="Create">
</form>