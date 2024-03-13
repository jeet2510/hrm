<style>
    .reason {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 5em;
    }

    .reason:hover {
        overflow: visible;
        white-space: normal;
        width: auto;
    }
</style>


<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Advance Salaries')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Advance Salaries')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <a href="<?php echo e(route('advancesalary.create')); ?>" data-title="<?php echo e(__('Create New Advance Salary')); ?>" data-bs-toggle="tooltip"
        title="" class="btn btn-sm btn-primary" data-bs-original-title="<?php echo e(__('Create')); ?>">
        <i class="ti ti-plus"></i> <?php echo e(__('Create')); ?>

    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table" id="advance-salary-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('ID')); ?></th>
                                    <th><?php echo e(__('Employee')); ?></th>
                                    <th><?php echo e(__('Ask Month')); ?></th>
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Ask Amount')); ?></th>
                                    <th><?php echo e(__('Approved Amount')); ?></th>
                                    <th><?php echo e(__('Approved Date')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Reason')); ?></th>
                                    <th><?php echo e(__('Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($advanceSalaries !== null): ?>
                                    <?php $__currentLoopData = $advanceSalaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advanceSalary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            

                                            <td><?php echo e($advanceSalary->id); ?></td>
                                            <td><?php echo e($advanceSalary->employee->name); ?></td>
                                            <td><?php echo e($advanceSalary->advance_salary_month); ?></td>
                                            <td><?php echo e($advanceSalary->ask_date); ?></td>
                                            <td><?php echo e($advanceSalary->ask_amount); ?></td>
                                            <td><?php echo e($advanceSalary->approved_amount); ?></td>
                                            <td><?php echo e($advanceSalary->approved_date); ?></td>
                                            <td>
                                                <span id="status_<?php echo e($advanceSalary->id); ?>">
                                                    <?php if($advanceSalary->status == 0): ?>
                                                        Pending
                                                    <?php elseif($advanceSalary->status == 1): ?>
                                                        Approved
                                                    <?php elseif($advanceSalary->status == 2): ?>
                                                        Rejected
                                                    <?php else: ?>
                                                        Unknown
                                                    <?php endif; ?>
                                                </span>
                                            </td>

                                            <td>
                                                <span id="reason_<?php echo e($advanceSalary->id); ?>" class="reason">
                                                    <?php echo e($advanceSalary->reason); ?>

                                                </span>
                                            </td>
                                            <td>
                                                
                                                <?php if((auth()->check() && auth()->user()->type == 'company') || auth()->user()->type == 'super admin'): ?>
                                                    <a href="<?php echo e(route('advancesalary.edit', $advanceSalary->id)); ?>"
                                                        class="btn btn-primary">
                                                        Edit
                                                    </a>
                                                <?php else: ?>
                                                    Not Allowed
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No data Found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/jeetpandya/Desktop/workspace/MySmartSolution/hrm/resources/views/advanceSalary/index.blade.php ENDPATH**/ ?>