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

<form action="{{ route('tax.store') }}" method="post">
    @csrf <!-- CSRF protection -->
    <div class="modal-body" style="margin-bottom: 10px">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="form-group">
                    <label class="form-label">{{ __('Tax Type') }}</label>
                    <div class="form-icon-user">
                        <select name="tax_type" class="form-control tax-type" id="tax_type">
                            <option value="normal">{{ __('Normal') }}</option>
                            <option value="slab">{{ __('Slab') }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tax_name" class="form-label">{{ __('Tax Name') }}</label>
                    <div class="form-icon-user">
                        <input type="text" name="tax_name" class="form-control" placeholder="{{ __('Enter Tax Name') }}">
                    </div>
                </div>

                <div class="form-group" id="percentage">
                    <label for="percentage" class="form-label">{{ __('Percentage') }}</label>
                    <div class="form-icon-user">
                        <input type="number" name="percentage" class="form-control" placeholder="{{ __('Enter Percentage') }}">
                    </div>
                </div>

                <div class="form-group allowances-wrapper">
                    {{-- <label class="form-label">{{ __('Allowances') }}</label> --}}
                    {{ Form::label('Allowances', __('Allowances'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::select('allowances[]', $allowances->pluck('name', 'id'), null, ['class' => 'form-control select2', 'id' => 'allowances-choices-multiple', 'name' => 'allowances-choices-multiple[]','multiple' => '']) }}
                    </div>
                </div>



                <div class="slab-wrapper" >


                    <table class="slab-tax" style="display: none; width: 450px;" id="denis">
                        <div class="form-group allowances-wrapper" style="display: none;" id="deduction_of_taxes">
                            {{ Form::label('deduction_of_taxes', __('Deduction of Tax'), ['class' => 'form-label']) }}
                            <div class="form-icon-user">
                                {{ Form::select('deduction_of_taxes[]', $taxes->pluck('name', 'id'), null, ['class' => 'form-control select2', 'id' => 'deduction-choices-multiple', 'name' => 'deduction-choices-multiple[]', 'multiple' => '']) }}
                            </div>
                        </div>
                        <thead>
                            <tr>
                                <th>{{ __('Salary From') }}</th>
                                <th>{{ __('Salary To') }}</th>
                                <th>{{ __('Percentage') }}</th>
                                <th>{{ __('Fix Tax Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="slab-item">
                                <td>
                                    <div class="form-group-table">
                                        <input type="number" name="slab_from[]" class="form-control" placeholder="{{ __('From') }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group-table">
                                        <input type="number" name="slab_to[]" class="form-control" placeholder="{{ __('To') }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group-table">
                                        <input type="number" name="slab_percentage[]" class="form-control" placeholder="{{ __('Enter Percentage') }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group-table">
                                        <input type="number" name="slab_fixed_deduction[]" class="form-control" value="0">
                                    </div>
                                </td>


                            </tr>

                        </tbody>
                        <button type="button" class="btn btn-primary add-slab" id="jeet" style="display: none;">{{ __('Add Slab') }}</button>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
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
