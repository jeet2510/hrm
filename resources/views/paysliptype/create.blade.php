{{ Form::open(['url' => 'paysliptype', 'method' => 'post']) }}
<div class="modal-body">
    {{-- {{dd($taxes)}} --}}
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
                    @if($taxes->count() > 0)

                <div class="form-group allowances-wrapper" style="" id="deduction_of_taxes">
                    {{ Form::label('deduction_of_taxes', __('Deduction of Tax'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::select('deduction_of_taxes[]', ['None'] + $taxes->pluck('name', 'id')->toArray(), null, ['class' => 'form-control select2', 'id' => 'deduction-choices-multiple', 'name' => 'deduction-choices-multiple[]']) }}
                        {{-- {{ Form::select('deduction_of_taxes[]', ['None'] + $taxes->pluck('name', 'id')->toArray(), null, ['class' => 'form-control select2', 'id' => 'deduction-choices-multiple', 'name' => 'deduction-choices-multiple[]', 'multiple' => '']) }} --}}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

