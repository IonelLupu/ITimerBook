
<div class="form-group">
    <label for="{{ $input->name }}">{{ $input->label }}</label>
    <select name="{{ $input->name }}[]" id="{{ $input->name }}" class="form-control select2" multiple="multiple" data-placeholder="Select {{ $input->name }}" style="width: 100%;">
        @foreach( $input->values() as $value )
            <option value="{{ $value->id }}" @if($input->isSelected($value)) selected @endif>
                {{ $input->getOptionLabel($value) }}
            </option>
        @endforeach
    </select>
</div>