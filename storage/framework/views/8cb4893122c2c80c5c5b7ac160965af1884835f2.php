<?php
    $plan = Utility::getChatGPTSettings();
?>

<?php echo e(Form::model($ticket, ['route' => ['ticket.update', $ticket->id], 'method' => 'PUT'])); ?>

<div class="modal-body">

    <?php if($plan->enable_chatgpt == 'on'): ?>
    <div class="text-end">
        <a href="#" class="btn btn-sm btn-primary" data-size="medium" data-ajax-popup-over="true" data-url="<?php echo e(route('generate', ['ticket'])); ?>"
            data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>"
            data-title="<?php echo e(__('Generate Content With AI')); ?>">
            <i class="fas fa-robot"></i><?php echo e(__(' Generate With AI')); ?>

        </a>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="form-group">
            <?php echo e(Form::label('title', __('Subject'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Ticket Subject')])); ?>

        </div>
        <?php if(\Auth::user()->type != 'employee'): ?>
            <div class="form-group">
                <?php echo e(Form::label('employee_id', __('Ticket for Employee'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::select('employee_id', $employees, null, ['class' => 'form-control select2'])); ?>

            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
                <div class="form-group">
                    <?php echo e(Form::label('priority', __('Priority'), ['class' => 'col-form-label'])); ?>

                    <select name="priority" class="form-control select2" id="choices-multiple">
                        <option value="low" <?php if($ticket->priority == 'low'): ?> selected <?php endif; ?>><?php echo e(__('Low')); ?>

                        </option>
                        <option value="medium" <?php if($ticket->priority == 'medium'): ?> selected <?php endif; ?>><?php echo e(__('Medium')); ?>

                        </option>
                        <option value="high" <?php if($ticket->priority == 'high'): ?> selected <?php endif; ?>><?php echo e(__('High')); ?>

                        </option>
                        <option value="critical" <?php if($ticket->priority == 'critical'): ?> selected <?php endif; ?>>
                            <?php echo e(__('critical')); ?>

                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
                <div class="form-group">
                    <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'col-form-label'])); ?>

                    <?php echo e(Form::text('end_date', null, ['class' => 'form-control d_week','autocomplete'=>'off'])); ?>

                </div>
            </div>
        </div>


        <div class="form-group">
            <?php echo e(Form::label('description', __('Description'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Ticket Description'),'rows'=>'3'])); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('status', __('Status'), ['class' => 'col-form-label'])); ?>

            <select name="status"  class="form-control  select2" id="status">
                <option value="close" <?php if($ticket->status == 'close'): ?> selected <?php endif; ?>><?php echo e(__('Close')); ?></option>
                <option value="open" <?php if($ticket->status == 'open'): ?> selected <?php endif; ?>><?php echo e(__('Open')); ?></option>
                <option value="onhold" <?php if($ticket->status == 'onhold'): ?> selected <?php endif; ?>><?php echo e(__('On Hold')); ?></option>
            </select>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH /Users/jeetpandya/Desktop/workspace/MySmartSolution/hrm/resources/views/ticket/edit.blade.php ENDPATH**/ ?>