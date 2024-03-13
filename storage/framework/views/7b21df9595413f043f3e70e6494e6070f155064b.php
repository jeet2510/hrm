<?php echo e(Form::model($paysliptype, ['route' => ['paysliptype.update', $paysliptype->id], 'method' => 'PUT'])); ?>

<div class="modal-body">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Payslip Type Name')])); ?>

                </div>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-name" role="alert">
                        <strong class="text-danger"><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    
                <div class="form-group allowances-wrapper" style="" id="deduction_of_taxes">
                    <?php echo e(Form::label('deduction_of_taxes', __('Deduction of Tax'), ['class' => 'form-label'])); ?>

                    <div class="form-icon-user">
                        <?php echo e(Form::select('deduction_of_taxes[]', $taxes->pluck('name', 'id')->prepend('None', ''), is_array($paysliptype->is_taxes_applicable) ? $paysliptype->is_taxes_applicable : json_decode($paysliptype->is_taxes_applicable), ['class' => 'form-control select2', 'id' => 'deduction-choices-multiple', 'name' => 'deduction-choices-multiple[]'])); ?>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /Users/jeetpandya/Desktop/workspace/MySmartSolution/hrm/resources/views/paysliptype/edit.blade.php ENDPATH**/ ?>