{{ Form::model($employee, ['route' => ['employee.salary.update', $employee->id], 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  ">
            {{ Form::label('salary_type', __('Payslip Type askb *'), ['class' => 'col-form-label']) }}
            {{ Form::select('salary_type', $payslip_type, null, ['class' => 'form-control select2', 'required' => 'required']) }}
        </div>
        <div class="form-group  ">
            {{ Form::label('salary', __('Advance Amount'), ['class' => 'col-form-label']) }}
            {{ Form::number('salary', null, ['class' => 'form-control ', 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <button type="submit" class="btn  btn-primary">{{ __('Save') }}</button>
</div>
{{ Form::close() }}
