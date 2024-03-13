{{ Form::model($paysliptype, ['route' => ['paysliptype.update', $paysliptype->id], 'method' => 'PUT']) }}
<div class="modal-body">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Payslip Type Name')]) }}
                </div>
                @error('name')
                    <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
                    {{-- {{dd(is_array($paysliptype->is_taxes_applicable))}} --}}
                <div class="form-group allowances-wrapper" style="" id="deduction_of_taxes">
                    {{ Form::label('deduction_of_taxes', __('Deduction of Tax'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::select('deduction_of_taxes[]', $taxes->pluck('name', 'id')->prepend('None', ''), is_array($paysliptype->is_taxes_applicable) ? $paysliptype->is_taxes_applicable : json_decode($paysliptype->is_taxes_applicable), ['class' => 'form-control select2', 'id' => 'deduction-choices-multiple', 'name' => 'deduction-choices-multiple[]']) }}
                        {{-- {{ Form::select('deduction_of_taxes[]', $taxes->pluck('name', 'id')->prepend('None', ''), is_array($paysliptype->is_taxes_applicable) ? $paysliptype->is_taxes_applicable : json_decode($paysliptype->is_taxes_applicable), ['class' => 'form-control select2', 'id' => 'deduction-choices-multiple', 'name' => 'deduction-choices-multiple[]', 'multiple' => '']) }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
