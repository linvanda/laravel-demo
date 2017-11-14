<?php $__env->startSection('page_title', __('voyager.generic.viewing').' '.$dataType->display_name_plural); ?>

<?php $__env->startSection('page_header'); ?>
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="<?php echo e($dataType->icon); ?>"></i> <?php echo e($dataType->display_name_plural); ?>

        </h1>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add',app($dataType->model_name))): ?>
            <a href="<?php echo e(route('voyager.'.$dataType->slug.'.create')); ?>" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span><?php echo e(__('voyager.generic.add_new')); ?></span>
            </a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete',app($dataType->model_name))): ?>
            <?php echo $__env->make('voyager::partials.bulk-delete', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
        <?php echo $__env->make('voyager::multilingual.language-selector', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content browse container-fluid">
        <?php echo $__env->make('voyager::alerts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <?php if($isServerSide): ?>
                            <form method="get">
                                <div id="search-input">
                                    <select id="search_key" name="key">
                                        <?php $__currentLoopData = $searchable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" <?php if($search->key == $key): ?><?php echo e('selected'); ?><?php endif; ?>><?php echo e(ucwords(str_replace('_', ' ', $key))); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <select id="filter" name="filter">
                                        <option value="contains" <?php if($search->filter == "contains"): ?><?php echo e('selected'); ?><?php endif; ?>>contains</option>
                                        <option value="equals" <?php if($search->filter == "equals"): ?><?php echo e('selected'); ?><?php endif; ?>>=</option>
                                    </select>
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control" placeholder="Search" name="s" value="<?php echo e($search->value); ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="voyager-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <?php $__currentLoopData = $dataType->browseRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th>
                                            <?php if($isServerSide): ?>
                                                <a href="<?php echo e($row->sortByUrl()); ?>">
                                            <?php endif; ?>
                                            <?php echo e($row->display_name); ?>

                                            <?php if($isServerSide): ?>
                                                <?php if($row->isCurrentSortField()): ?>
                                                    <?php if(!isset($_GET['sort_order']) || $_GET['sort_order'] == 'asc'): ?>
                                                        <i class="voyager-angle-up pull-right"></i>
                                                    <?php else: ?>
                                                        <i class="voyager-angle-down pull-right"></i>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                </a>
                                            <?php endif; ?>
                                        </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <th class="actions"><?php echo e(__('voyager.generic.actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $dataTypeContent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="row_id" id="checkbox_<?php echo e($data->id); ?>" value="<?php echo e($data->id); ?>">
                                        </td>
                                        <?php $__currentLoopData = $dataType->browseRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td>
                                                <?php $options = json_decode($row->details); ?>
                                                <?php if($row->type == 'image'): ?>
                                                    <img src="<?php if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)): ?><?php echo e(Voyager::image( $data->{$row->field} )); ?><?php else: ?><?php echo e($data->{$row->field}); ?><?php endif; ?>" style="width:100px">
                                                <?php elseif($row->type == 'relationship'): ?>
                                                    <?php echo $__env->make('voyager::formfields.relationship', ['view' => 'browse'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                <?php elseif($row->type == 'select_multiple'): ?>
                                                    <?php if(property_exists($options, 'relationship')): ?>

                                                        <?php $__currentLoopData = $data->{$row->field}; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($item->{$row->field . '_page_slug'}): ?>
                                                            <a href="<?php echo e($item->{$row->field . '_page_slug'}); ?>"><?php echo e($item->{$row->field}); ?></a><?php if(!$loop->last): ?>, <?php endif; ?>
                                                            <?php else: ?>
                                                            <?php echo e($item->{$row->field}); ?>

                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        
                                                    <?php elseif(property_exists($options, 'options')): ?>
                                                        <?php $__currentLoopData = $data->{$row->field}; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <?php echo e($options->options->{$item} . (!$loop->last ? ', ' : '')); ?>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>

                                                <?php elseif($row->type == 'select_dropdown' && property_exists($options, 'options')): ?>

                                                    <?php if($data->{$row->field . '_page_slug'}): ?>
                                                        <a href="<?php echo e($data->{$row->field . '_page_slug'}); ?>"><?php echo $options->options->{$data->{$row->field}}; ?></a>
                                                    <?php else: ?>
                                                        <?php echo $options->options->{$data->{$row->field}}; ?>

                                                    <?php endif; ?>


                                                <?php elseif($row->type == 'select_dropdown' && $data->{$row->field . '_page_slug'}): ?>
                                                    <a href="<?php echo e($data->{$row->field . '_page_slug'}); ?>"><?php echo e($data->{$row->field}); ?></a>
                                                <?php elseif($row->type == 'date'): ?>
                                                <?php echo e($options && property_exists($options, 'format') ? \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($options->format) : $data->{$row->field}); ?>

                                                <?php elseif($row->type == 'checkbox'): ?>
                                                    <?php if($options && property_exists($options, 'on') && property_exists($options, 'off')): ?>
                                                        <?php if($data->{$row->field}): ?>
                                                        <span class="label label-info"><?php echo e($options->on); ?></span>
                                                        <?php else: ?>
                                                        <span class="label label-primary"><?php echo e($options->off); ?></span>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                    <?php echo e($data->{$row->field}); ?>

                                                    <?php endif; ?>
                                                <?php elseif($row->type == 'color'): ?>
                                                    <span class="badge badge-lg" style="background-color: <?php echo e($data->{$row->field}); ?>"><?php echo e($data->{$row->field}); ?></span>
                                                <?php elseif($row->type == 'text'): ?>
                                                    <?php echo $__env->make('voyager::multilingual.input-hidden-bread-browse', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                    <div class="readmore"><?php echo e(strlen( $data->{$row->field} ) > 200 ? substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field}); ?></div>
                                                <?php elseif($row->type == 'text_area'): ?>
                                                    <?php echo $__env->make('voyager::multilingual.input-hidden-bread-browse', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                    <div class="readmore"><?php echo e(strlen( $data->{$row->field} ) > 200 ? substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field}); ?></div>
                                                <?php elseif($row->type == 'file' && !empty($data->{$row->field}) ): ?>
                                                    <?php echo $__env->make('voyager::multilingual.input-hidden-bread-browse', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                    <?php if(json_decode($data->{$row->field})): ?>
                                                        <?php $__currentLoopData = json_decode($data->{$row->field}); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <a href="<?php echo e(Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: ''); ?>" target="_blank">
                                                                <?php echo e($file->original_name ?: ''); ?>

                                                            </a>
                                                            <br/>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field})); ?>" target="_blank">
                                                            Download
                                                        </a>
                                                    <?php endif; ?>
                                                <?php elseif($row->type == 'rich_text_box'): ?>
                                                    <?php echo $__env->make('voyager::multilingual.input-hidden-bread-browse', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                    <div class="readmore"><?php echo e(strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>')); ?></div>
                                                <?php elseif($row->type == 'coordinates'): ?>
                                                    <?php echo $__env->make('voyager::partials.coordinates-static-image', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                <?php else: ?>
                                                    <?php echo $__env->make('voyager::multilingual.input-hidden-bread-browse', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                    <span><?php echo e($data->{$row->field}); ?></span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td class="no-sort no-click" id="bread-actions">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $data)): ?>
                                                <a href="javascript:;" title="<?php echo e(__('voyager.generic.delete')); ?>" class="btn btn-sm btn-danger pull-right delete" data-id="<?php echo e($data->{$data->getKeyName()}); ?>" id="delete-<?php echo e($data->{$data->getKeyName()}); ?>">
                                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm"><?php echo e(__('voyager.generic.delete')); ?></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit', $data)): ?>
                                                <a href="<?php echo e(route('voyager.'.$dataType->slug.'.edit', $data->{$data->getKeyName()})); ?>" title="<?php echo e(__('voyager.generic.edit')); ?>" class="btn btn-sm btn-primary pull-right edit">
                                                    <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm"><?php echo e(__('voyager.generic.edit')); ?></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('read', $data)): ?>
                                                <a href="<?php echo e(route('voyager.'.$dataType->slug.'.show', $data->{$data->getKeyName()})); ?>" title="<?php echo e(__('voyager.generic.view')); ?>" class="btn btn-sm btn-warning pull-right">
                                                    <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm"><?php echo e(__('voyager.generic.view')); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($isServerSide): ?>
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite"><?php echo e(trans_choice(
                                    'voyager.generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total()
                                    ])); ?></div>
                            </div>
                            <div class="pull-right">
                                <?php echo e($dataTypeContent->appends([
                                    's' => $search,
                                    'order_by' => $orderBy,
                                    'sort_order' => $sortOrder
                                ])->links()); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo e(__('voyager.generic.close')); ?>"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> <?php echo e(__('voyager.generic.delete_question')); ?> <?php echo e(strtolower($dataType->display_name_singular)); ?>?</h4>
                </div>
                <div class="modal-footer">
                    <form action="<?php echo e(route('voyager.'.$dataType->slug.'.index')); ?>" id="delete_form" method="POST">
                        <?php echo e(method_field("DELETE")); ?>

                        <?php echo e(csrf_field()); ?>

                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                 value="<?php echo e(__('voyager.generic.delete_confirm')); ?> <?php echo e(strtolower($dataType->display_name_singular)); ?>">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><?php echo e(__('voyager.generic.cancel')); ?></button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<?php if(!$dataType->server_side && config('dashboard.data_tables.responsive')): ?>
<link rel="stylesheet" href="<?php echo e(voyager_asset('lib/css/responsive.dataTables.min.css')); ?>">
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <!-- DataTables -->
    <?php if(!$dataType->server_side && config('dashboard.data_tables.responsive')): ?>
        <script src="<?php echo e(voyager_asset('lib/js/dataTables.responsive.min.js')); ?>"></script>
    <?php endif; ?>
    <script>
        $(document).ready(function () {
            <?php if(!$dataType->server_side): ?>
                var table = $('#dataTable').DataTable(<?php echo json_encode(
                    array_merge([
                        "order" => [],
                        "language" => __('voyager.datatable'),
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true); ?>);
            <?php else: ?>
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            <?php endif; ?>

            <?php if($isModelTranslatable): ?>
                $('.side-body').multilingual();
            <?php endif; ?>
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) { // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');
            console.log(form.action);

            $('#delete_modal').modal('show');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>