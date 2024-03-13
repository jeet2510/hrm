<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><?php echo e(__('Edit Advance Salary')); ?></div>
                    
                    <div class="card-body">
                        <form method="POST" action="<?php echo e(route('advancesalary.update', $advanceSalary->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="form-group">
                                <label for="name"><?php echo e(__('Name')); ?></label>
                                <input type="name" id="name" name="name" class="form-control"
                                    value="<?php echo e($advanceSalary->employee->name); ?>" required disabled>
                            </div>
                            <div class="form-group">
                                <label for="month"><?php echo e(__('Salary Month')); ?></label>
                                <input type="text" id="month" name="month" class="form-control"
                                    value="<?php echo e(date('Y-m', strtotime($advanceSalary->advance_salary_month))); ?>" required
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="asked_date"><?php echo e(__('Asked_date')); ?></label>
                                <input type="date" id="asked_date" name="asked_date" class="form-control"
                                    value="<?php echo e($advanceSalary->ask_date); ?>" required disabled>
                            </div>

                            <div class="form-group">
                                <label for="status"><?php echo e(__('Status')); ?></label>
                                <select id="status" name="status" class="form-control">
                                    <option value="0" <?php echo e($advanceSalary->status == 0 ? 'selected' : ''); ?>>Pending
                                    </option>
                                    <option value="1" <?php echo e($advanceSalary->status == 1 ? 'selected' : ''); ?>>Approved
                                    </option>
                                    <option value="2" <?php echo e($advanceSalary->status == 2 ? 'selected' : ''); ?>>Rejected
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="ask_amount"><?php echo e(__('Asked Amount')); ?></label>
                                <input type="number" id="ask_amount" name="ask_amount" class="form-control"
                                    value="<?php echo e($advanceSalary->ask_amount); ?>" required disabled>
                            </div>

                            <div class="form-group">
                                <label for="approved_amount"><?php echo e(__('Approved Amount')); ?></label>
                                <input type="number" id="approved_amount" name="approved_amount" class="form-control"
                                    value="<?php echo e($advanceSalary->approved_amount); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="approved_date"><?php echo e(__('Approved Date')); ?></label>
                                <input type="date" id="approved_date" name="approved_date" class="form-control"
                                    value="<?php echo e($advanceSalary->approved_date); ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo e(__('Update')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/jeetpandya/Desktop/workspace/MySmartSolution/hrm/resources/views/advanceSalary/edit.blade.php ENDPATH**/ ?>