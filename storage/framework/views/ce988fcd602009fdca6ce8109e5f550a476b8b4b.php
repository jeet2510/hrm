<?php echo e(Form::model($employee, ['route' => ['employee.salary.update', $employee->id], 'method' => 'POST'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group">
            <?php echo e(Form::label('month', __('Month'), ['class' => 'col-form-label'])); ?>

            <input type="month" id="month" name="month" class="form-control" value="<?php echo date('Y-m', strtotime('+1 month')); ?>" required>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('salary', __('Advance Amount'), ['class' => 'col-form-label'])); ?>

            <br>

            <span style="color: gray;">
                <italic>Current Basic Pay of employee is <?php echo e($employee->salary); ?></italic>
            </span>
            <br>
            <?php echo e(Form::number('salary', null, ['id' => 'salary', 'class' => 'form-control', 'required' => 'required'])); ?>

            <span id="salary-error" style="color: red; display: none;">Entered amount cannot be more than salary</span>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <button type="submit" id="submitBtn" class="btn btn-primary"><?php echo e(__('Save')); ?></button>
</div>
<?php echo e(Form::close()); ?>


<script>
    document.getElementById('salary').addEventListener('input', function() {
        var salaryInput = parseFloat(this.value);
        var employeeSalary = parseFloat(<?php echo e($employee->salary); ?>);
        if (salaryInput > employeeSalary) {
            document.getElementById('salary-error').style.display = 'block';
            document.getElementById('submitBtn').disabled = true;
        } else {
            document.getElementById('salary-error').style.display = 'none';
            document.getElementById('submitBtn').disabled = false;
        }
    });
</script>
<?php /**PATH /Users/jeetpandya/Desktop/workspace/MySmartSolution/hrm/resources/views/setsalary/advance_salary.blade.php ENDPATH**/ ?>