<style>
    .form-group {
        min-width: 1000px;
    }

    .form-group-table {
        min-width: 230px;
        margin: 5px;
    }

    .modal-content {
        width: 1050px;
        left: -200px;
    }
</style>

<form action="{{ route('tax.update', $tax->id) }}" method="post">
    @csrf
    @method('PUT')

    <div class="modal-body" style="margin-bottom: 10px">
        <!-- Tax Type -->
        <div class="form-group">
            <label class="form-label">{{ __('Tax Type') }}</label>
            <div class="form-icon-user">
                <select name="tax_type" class="form-control tax-type" id="tax_type">
                    <option value="normal" {{ $tax->tax_type == 'normal' ? 'selected' : '' }}>{{ __('Normal') }}</option>
                    <option value="slab" {{ $tax->tax_type == 'slab' ? 'selected' : '' }}>{{ __('Slab') }}</option>
                </select>
            </div>
        </div>

        <!-- Tax Name -->
        <div class="form-group">
            <label for="tax_name" class="form-label">{{ __('Tax Name') }}</label>
            <div class="form-icon-user">
                <input type="text" name="tax_name" class="form-control" placeholder="{{ __('Enter Tax Name') }}" value="{{ $tax->name }}">
            </div>
        </div>

        <!-- Percentage -->
        @if($tax->percentage)
        <div class="form-group" id="percentage">
            <label for="percentage" class="form-label">{{ __('Percentage') }}</label>
            <div class="form-icon-user">
                <input type="number" name="percentage" class="form-control" placeholder="{{ __('Enter Percentage') }}" value="{{ $tax->percentage }}">
            </div>
        </div>
        @endif
        <!-- Allowances -->
        <div class="form-group allowances-wrapper">
            {{ Form::label('Allowances', __('Allowances'), ['class' => 'form-label']) }}
            <div class="form-icon-user">
                {{ Form::select('allowances[]', $allowances->pluck('name', 'id'), is_array($tax->allowance_ids) ? $tax->allowance_ids : json_decode($tax->allowance_ids), ['class' => 'form-control select2', 'id' => 'allowances-choices-multiple', 'name' => 'allowances-choices-multiple[]', 'multiple' => '']) }}
            </div>
        </div>

        <!-- Slab Data -->
        @if($tax->tax_type == 'slab')
            <div class="slab-wrapper">
                <div class="form-group allowances-wrapper" style="" id="deduction_of_taxes">
                    {{ Form::label('deduction_of_taxes', __('Deduction of Tax'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::select('deduction_of_taxes[]', $taxes->pluck('name', 'id'), (is_array($tax->deduction_of_taxes) && !empty($tax->deduction_of_taxes)) ? $tax->deduction_of_taxes : json_decode($tax->deduction_of_taxes), ['class' => 'form-control select2', 'id' => 'deduction-choices-multiple', 'name' => 'deduction-choices-multiple[]', 'multiple' => '', 'required' => 'required']) }}

                    </div>
                </div>
                <!-- Slab data fields -->
                <table class="slab-tax" style="width: 100%">
                    <thead>
                        <tr>
                            <th>{{ __('Salary From') }}</th>
                            <th>{{ __('Salary To') }}</th>
                            <th>{{ __('Percentage') }}</th>
                            <th>{{ __('Fixed Tax Amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $data['count']; $i++)
                            <tr class="slab-item">
                                <td>
                                    <input type="number" name="slab_from[]" class="form-control" value="{{ isset($data['slab_from'][$i]) ? $data['slab_from'][$i] : '' }}">
                                </td>
                                <td>
                                    <input type="number" name="slab_to[]" class="form-control" value="{{ isset($data['slab_to'][$i]) ? $data['slab_to'][$i] : '' }}">
                                </td>
                                <td>
                                    <input type="number" name="slab_percentage[]" class="form-control" value="{{ isset($data['slab_percentage'][$i]) ? $data['slab_percentage'][$i] : '' }}">
                                </td>
                                <td>
                                    <input type="number" name="slab_fixed_deduction[]" class="form-control" value="{{ isset($data['slab_fixed_deduction'][$i]) ? $data['slab_fixed_deduction'][$i] : '' }}">
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary add-slab" style="display: block;">{{ __('Add Slab') }}</button>
            </div>
        @endif
    </div>

    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#tax_type').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === "slab") {
                $('#denis').css('display', 'block');
                $('#slab_percentage').css('display', 'block');
                $('#jeet').css('display', 'block');
                $('#deduction_of_taxes').css('display', 'block');

                $('#percentage').css('display', 'none');
            } else {
                $('#denis').css('display', 'none');
                $('#percentage').css('display', 'block');
                $('#jeet').css('display', 'none');
                $('#deduction_of_taxes').css('display', 'none');

            }
        });

        $('.add-slab').click(function() {
            var newRow = '<tr class="slab-item">' +
                '<td><div class="form-group-table"><input type="number" name="slab_from[]" class="form-control" placeholder="{{ __('From') }}"></div></td>' +
                '<td><div class="form-group-table"><input type="number" name="slab_to[]" class="form-control" placeholder="{{ __('To') }}"></div></td>' +
                '<td><div class="form-group-table"><input type="number" name="slab_percentage[]" class="form-control" placeholder="{{ __('Enter Percentage') }}"></div></td>' +
                '<td><div class="form-group-table"><input type="number" name="slab_fixed_deduction[]" class="form-control" value="0"></div></td>' +
                '</tr>';
            $('.slab-tax tbody').append(newRow);
        });
    });

    $(document).ready(function() {
        $('denis-allowances').select2();
    });
</script>
