<div class="form-group">
    <label for="{{ $input->name }}">{{ $input->label }}</label>
    <select class="form-control" id="{{ $input->name }}" name="{{ $input->name }}">
        <option value="" selected disabled>Select {{ $input->label }}</option>
        @foreach( $input->values() as $model )
            <option value="{{ $model->id }}" @if( isset($input->value['id']) && $model->id == $input->value->id) selected @endif>{{ $model->name }}</option>
        @endforeach
    </select>
</div>