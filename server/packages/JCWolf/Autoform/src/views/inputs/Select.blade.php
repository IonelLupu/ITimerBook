<div class="form-group">
    <label for="{{ $input->name }}">{{ $input->label }}</label>

    <select class="form-control" id="{{ $input->name }}" name="{{ $input->name }}">
        <option value="" selected disabled>Select {{ $input->label }}</option>
        @foreach( $input->values() as $value )
            <option value="{{ $value }}" @if($value == $input->value) selected @endif>{{ $value }}</option>
        @endforeach
    </select>
</div>