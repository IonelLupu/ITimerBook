<div class="form-group">
    <label for="{{ $input->name }}">{{ $input->label }}</label>

    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control datepicker" id="{{ $input->name }}" value="{{ $input->value }}" name="{{ $input->name }}">
    </div>
</div>