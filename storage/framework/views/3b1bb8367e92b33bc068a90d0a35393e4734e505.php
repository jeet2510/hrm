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

<form action="<?php echo e(route('tax.update', $tax->id)); ?>" method="post">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="modal-body" style="margin-bottom: 10px">
        <!-- Tax Type -->
        <div class="form-group">
            <label class="form-label"><?php echo e(__('Tax Type')); ?></label>
            <div class="form-icon-user">
                <select name="tax_type" class="form-control tax-type" id="tax_type">
                    <option value="normal" <?php echo e($tax->tax_type == 'normal' ? 'selected' : ''); ?>><?php echo e(__('Normal')); ?></option>
                    <option value="slab" <?php echo e($tax->tax_type == 'slab' ? 'selected' : ''); ?>><?php echo e(__('Slab')); ?></option>
                </select>
            </div>
        </div>

        <!-- Tax Name -->
        <div class="form-group">
            <label for="tax_name" class="form-label"><?php echo e(__('Tax Name')); ?></label>
            <div class="form-icon-user">
                <input type="text" name="tax_name" class="form-control" placeholder="<?php echo e(__('Enter Tax Name')); ?>" value="<?php echo e($tax->name); ?>">
            </div>
        </div>

        <!-- Percentage -->
        <?php if($tax->percentage): ?>
        <div class="form-group" id="percentage">
            <label for="percentage" class="form-label"><?php echo e(__('Percentage')); ?></label>
            <div class="form-icon-user">
                <input type="number" name="percentage" class="form-control" placeholder="<?php echo e(__('Enter Percentage')); ?>" value="<?php echo e($tax->percentage); ?>">
            </div>
        </div>
        <?php endif; ?>
        <!-- Allowances -->
        <div class="form-group allowances-wrapper">
            <?php echo e(Form::label('Allowances', __('Allowances'), ['class' => 'form-label'])); ?>

            <div class="form-icon-user">
                <?php echo e(Form::select('allowances[]', $allowances->pluck('name', 'id'), is_array($tax->allowance_ids) ? $tax->allowance_ids : json_decode($tax->allowance_ids), ['class' => 'form-control select2', 'id' => 'allowances-choices-multiple', 'name' => 'allowances-choices-multiple[]', 'multiple' => ''])); ?>

            </div>
        </div>

        <!-- Slab Data -->
        <?php if($tax->tax_type == 'slab'): ?>
            <div class="slab-wrapper">
                <div class="form-group allowances-wrapper" style="" id="deduction_of_taxes">
                    <?php echo e(Form::label('deduction_of_taxes', __('Deduction of Tax'), ['class' => 'form-label'])); ?>

                    <div class="form-icon-user">
                        <?php echo e(Form::select('deduction_of_taxes[]', $taxes->pluck('name', 'id'), (is_array($tax->deduction_of_taxes) && !empty($tax->deduction_of_taxes)) ? $tax->deduction_of_taxes : json_decode($tax->deduction_of_taxes), ['class' => 'form-control select2', 'id' => 'deduction-choices-multiple', 'name' => 'deduction-choices-multiple[]', 'multiple' => '', 'required' => 'required'])); ?>


                    </div>
                </div>
                <!-- Slab data fields -->
                <table class="slab-tax" style="width: 100%">
                    <thead>
                        <tr>
                            <th><?php echo e(__('Salary From')); ?></th>
                            <th><?php echo e(__('Salary To')); ?></th>
                            <th><?php echo e(__('Percentage')); ?></th>
                            <th><?php echo e(__('Fixed Tax Amount')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i < $data['count']; $i++): ?>
                            <tr class="slab-item">
                                <td>
                                    <input type="number" name="slab_from[]" class="form-control" value="<?php echo e(isset($data['slab_from'][$i]) ? $data['slab_from'][$i] : ''); ?>">
                                </td>
                                <td>
                                    <input type="number" name="slab_to[]" class="form-control" value="<?php echo e(isset($data['slab_to'][$i]) ? $data['slab_to'][$i] : ''); ?>">
                                </td>
                                <td>
                                    <input type="number" name="slab_percentage[]" class="form-control" value="<?php echo e(isset($data['slab_percentage'][$i]) ? $data['slab_percentage'][$i] : ''); ?>">
                                </td>
                                <td>
                                    <input type="number" name="slab_fixed_deduction[]" class="form-control" value="<?php echo e(isset($data['slab_fixed_deduction'][$i]) ? $data['slab_fixed_deduction'][$i] : ''); ?>">
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary add-slab" style="display: block;"><?php echo e(__('Add Slab')); ?></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
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
                '<td><div class="form-group-table"><input type="number" name="slab_from[]" class="form-control" placeholder="<?php echo e(__('From')); ?>"></div></td>' +
                '<td><div class="form-group-table"><input type="number" name="slab_to[]" class="form-control" placeholder="<?php echo e(__('To')); ?>"></div></td>' +
                '<td><div class="form-group-table"><input type="number" name="slab_percentage[]" class="form-control" placeholder="<?php echo e(__('Enter Percentage')); ?>"></div></td>' +
                '<td><div class="form-group-table"><input type="number" name="slab_fixed_deduction[]" class="form-control" value="0"></div></td>' +
                '</tr>';
            $('.slab-tax tbody').append(newRow);
        });
    });

    $(document).ready(function() {
        $('denis-allowances').select2();
    });
</script>
<?php /**PATH /Users/jeetpandya/Desktop/workspace/MySmartSolution/hrm/resources/views/taxes/edit.blade.php ENDPATH**/ ?>