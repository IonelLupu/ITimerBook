
<div class="form-group">
    <div class="row">
        <div class="col-xs-6">
            <label for="{{ $input->name }}">{{ $input->label }}</label>
            <input type="file" id="{{ $input->name }}" name="{{ $input->name }}" class="form-control-file">
        </div>
        <div class="col-xs-6">
            <img src="{{ asset('storage/'.$input->value) }}" alt="{{ $input->label }}" style="max-width: 100%;">
        </div>
    </div>
</div>