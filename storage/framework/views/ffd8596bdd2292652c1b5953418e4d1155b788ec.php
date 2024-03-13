<script>
    var selectedSalary;

    function setSalary() {
        var selectElement = document.getElementById('employee_id');
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        selectedSalary = parseFloat(selectedOption.getAttribute(
            'data-salary'));
        document.getElementById('employee-salary').innerText = selectedSalary;
        document.getElementById('ask_salary').value = selectedSalary;

    }

    function changeSalary() {
        var salaryInput = parseFloat(document.getElementById('ask_salary').value);
        if (salaryInput > selectedSalary) {
            document.getElementById('salary-error').style.display = 'block';
            document.getElementById('submitBtn').disabled = true;
        } else {
            document.getElementById('salary-error').style.display = 'none';
            document.getElementById('submitBtn').disabled = false;
        }
    }
</script>



<?php $__env->startSection('content'); ?>
    <?php echo e(Form::open(['route' => 'advancesalary.store', 'method' => 'POST'])); ?>

    <div class="modal-body">
        <div class="row">
            <div class="form-group">
                <?php echo e(Form::label('employee_id', __('Employee'), ['class' => 'col-form-label'])); ?>

                <select id="employee_id" name="employee_id" class="form-control" onchange="setSalary()" required>
                    <option value=""> Select </option>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($employee->id); ?>" data-salary="<?php echo e($employee->salary); ?>">
                            <?php echo e($employee->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <?php echo e(Form::label('month', __('Month'), ['class' => 'col-form-label'])); ?>

                <input type="month" id="month" name="month" class="form-control"
                    value="<?php echo e(date('Y-m', strtotime('+1 month'))); ?>" required>
            </div>
            <div class="form-group">
                <?php echo e(Form::label('ask_date', __('Ask Date'), ['class' => 'col-form-label'])); ?>

                <input type="date" id="ask_date" name="ask_date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>"
                    required>
            </div>
            <div class="form-group">
                <?php echo e(Form::label('reason', __('Reason'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('reason', null, ['id' => 'reason', 'class' => 'form-control', 'required' => 'required', 'onChange' => 'changeReason()'])); ?>

            </div>
            <div class="form-group">
                <?php echo e(Form::label('salary', __('Advance Amount'), ['class' => 'col-form-label'])); ?>

                <br>
                <span style="color: gray;">
                    <italic><?php echo e(__('Current Basic Pay of employee is')); ?> <span id="employee-salary"></span></italic>
                </span>
                <br>
                <?php echo e(Form::number('salary', 0, ['id' => 'ask_salary', 'class' => 'form-control', 'required' => 'required', 'step' => '0.01', 'onChange' => 'changeSalary()'])); ?>


                <span id="salary-error"
                    style="color: red; display: none;"><?php echo e(__('Entered amount cannot be more than salary')); ?></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
        <button type="submit" id="submitBtn" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/jeetpandya/Desktop/workspace/MySmartSolution/hrm/resources/views/advanceSalary/create.blade.php ENDPATH**/ ?>