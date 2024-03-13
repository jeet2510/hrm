<?php $__env->startSection('page-title'); ?>
   <?php echo e(__("Manage Tax")); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__("Home")); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__("Tax")); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Tax')): ?>
    <?php endif; ?>
        <a href="#" data-url="<?php echo e(route('tax.create')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Create New Tax')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
        <div class="col-3">
            <?php echo $__env->make('layouts.hrm_setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">

                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Tax')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody >
                            <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($tax->name); ?></td>
                                    <td class="Action">
                                        <span>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Tax')): ?>
                                            <?php endif; ?>
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-url="<?php echo e(URL::to('tax/' . $tax->id . '/edit')); ?>"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                        data-title="<?php echo e(__('Edit Tax')); ?>"
                                                        data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Tax')): ?>
                                            <?php endif; ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['tax.destroy', $tax->id], 'id' => 'delete-form-' . $tax->id]); ?>

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete"><i
                                                            class="ti ti-trash text-white text-white"></i></a>
                                                    </form>
                                                </div>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/jeetpandya/Desktop/workspace/MySmartSolution/hrm/resources/views/taxes/index.blade.php ENDPATH**/ ?>