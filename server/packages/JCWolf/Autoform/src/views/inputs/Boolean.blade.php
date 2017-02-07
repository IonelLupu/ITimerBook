<div class="form-check">
    <label class="form-check-label">
        <input type="checkbox" class="form-check-input" name="{{ $input->name }}" @if($input->value == 1) checked @endif value="1">
        {{ $input->label }}
    </label>
</div>