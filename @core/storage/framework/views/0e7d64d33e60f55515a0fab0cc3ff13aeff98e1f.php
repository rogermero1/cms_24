<?php $__env->startSection('site-title'); ?>
    <?php echo e(__('All Widgets')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/jquery-ui.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/dropzone.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/media-uploader.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/summernote-bs4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/backend/css/nice-select.css')); ?>">
    <style>
        .nice-select .option {
            min-height: 30px;
            padding: 0px 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .nice-select .option:hover, .nice-select .option.focus, .nice-select .option.selected.focus {
            font-weight: 700;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <?php echo $__env->make('backend/partials/message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('backend/partials/error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="col-lg-6 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"><?php echo e(__('All Widgets')); ?></h4>
                        <ul id="sortable_02" class="available-form-field all-widgets sortable_02">
                            <?php echo \App\WidgetsBuilder\WidgetBuilderSetup::get_admin_panel_widgets(); ?>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-5">
                <div class="sidebar-list-wrap">
                    <?php echo \App\WidgetsBuilder\WidgetBuilderSetup::get_admin_widget_sidebar_list(); ?>

                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('backend.partials.media-upload.media-upload-markup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/backend/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/summernote-bs4.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/backend/js/jquery.nice-select.min.js')); ?>"></script>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(".sortable").sortable({
                    handle: "h4.top-part",
                    axis: "y",
                    placeholder: "sortable-placeholder",
                    receive : function(event,ui){
                        resetOrder(this.id);
                    },
                    stop: function( event, ui ){
                        resetOrder(this.id);
                    }
                });//.disableSelection();

                $(".sortable_02").sortable({
                    connectWith: '.sortable_widget_location',
                    handle: "h4.top-part",
                    helper: "clone",
                    remove: function (e, li) {
                        var widgetName = li.item.attr('data-name');
                        var markup = '';
                        $.ajax({
                            'url' : "<?php echo e(route('admin.widgets.markup')); ?>",
                            'type' : "POST",
                            'data' : {
                                '_token' : "<?php echo csrf_token(); ?>",
                                'widget_name' : widgetName,
                            },
                            async: false,
                            success: function (data) {
                                markup = data;
                            }
                        });
                        li.item.clone()
                            .html(markup)
                            .insertAfter(li.item);
                        $(this).sortable('cancel');
                        return markup;
                    }
                });//.disableSelection();

                $('body').on('click', '.remove-widget', function (e) {
                    $(this).parent().remove();
                    $( ".sortable_02" ).sortable( "refreshPositions" );
                    var parent =  $(this).parent();
                    var widgetType = parent.find('input[name="widget_type"]').val();
                    resetOrder();

                    if(widgetType == 'update'){
                        var widget_id = parent.find('input[name="id"]').val();
                        $.ajax({
                            'url' : "<?php echo e(route('admin.widgets.delete')); ?>",
                            'type' : "POST",
                            'data' : {
                                '_token' : "<?php echo csrf_token(); ?>",
                                'id' : widget_id
                            },
                            success: function (data) {
                            }
                        });
                    }
                });
                $('body').on('click', '.expand', function (e) {
                    $(this).parent().find('.content-part').toggleClass('show');
                    var expand = $(this).children('i');
                    var classname = $(this).parent().data('name');
                    if(expand.hasClass('ti-angle-down')){
                        expand.attr('class', 'ti-angle-up');
                        $('body .nice-select').niceSelect();
                        $('.note-editable').trigger('focus');
                        var summerNote = $('li[data-name="'+classname+'"] .summernote');

                        summerNote.summernote({
                            disableDragAndDrop: true,
                            height: 200,   //set editable area's height
                            codeviewFilter: true,
                            codeviewIframeFilter: true,
                            toolbar: [
                                // [groupName, [list of button]]
                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                ['font', ['strikethrough', 'superscript', 'subscript']],
                                ['fontsize', ['fontsize']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['height', ['height']],
                                ['Insert', ['link','table','video','picture']],
                            ],
                            styleTags: [
                                'p',
                                { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
                                'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                            ],
                            codemirror: { // codemirror options
                                theme: 'monokai'
                            },
                            callbacks: {
                                onPaste: function (e) {
                                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                                    e.preventDefault();
                                    document.execCommand('insertText', false, bufferText);
                                }
                            }
                        });
                    }else{
                        expand.attr('class', 'ti-angle-down');
                        $('body .nice-select').niceSelect('destroy');
                        $('li[data-name="'+classname+'"] .summernote').summernote('destroy');
                    }
                });

                $('body').on('click', '.widget_save_change_button', function (e) {
                    e.preventDefault();
                    var parent = $(this).parent().find('.widget_save_change_button');
                    parent.text('<?php echo e(__('Saving...')); ?>').attr('disabled',true);
                    var formClass =  $(this).parent();
                    var formData = formClass.serializeArray();
                    var widgetType = $(this).parent().find('input[name="widget_type"]').val();
                    var formAction = $(this).parent().attr('action');
                    var udpateId = '';
                    var formContainer = $(this).parent();

                    $.ajax({
                        type: "POST",
                        url:  formAction,
                        data: formClass.serializeArray() ,
                        success:function (data) {
                            udpateId = data.id;
                            if(widgetType == 'new'){
                                formContainer.attr('action',"<?php echo e(route('admin.widgets.update')); ?>")
                                formContainer.find('input[name="widget_type"]').val('update');
                                formContainer.prepend('<input type="hidden" name="id" value="'+udpateId+'">');
                            }
                        }
                    });
                    parent.text('saved..');
                    setTimeout(function () {
                        parent.text('<?php echo e(__('Save Changes')); ?>').attr('disabled',false);
                    },1000);
                });

                /**
                 * reset order function
                 * */
                function resetOrder(dropedOn) {
                    var allItems = $('#'+dropedOn+' li');
                    $.each(allItems,function (index,value) {
                        $(this).find('input[name="widget_order"]').val(index+1);
                        $(this).find('input[name="widget_location"]').val(dropedOn);
                        var id = $(this).find('input[name="id"]').val();
                        var widget_order = index+1;
                        if(typeof id != 'undefined'){
                            reset_db_order(id,widget_order);
                        }
                    });
                }

                /**
                 * reorder funciton
                 * */
                function reset_db_order(id,widget_order){
                    $.ajax({
                        type: "POST",
                        url:  "<?php echo e(route('admin.widgets.update.order')); ?>",
                        data: {
                            _token: "<?php echo e(csrf_token()); ?>",
                            id : id,
                            widget_order: widget_order
                        },
                        success:function (data) {
                            //response ok if it saved success
                        }
                    });
                }
            });
            $(document).on('click','.widget-area-expand',function (e) {
                e.preventDefault();
                var widgetbody = $(this).parent().parent().find('.widget-area-body');
                widgetbody.toggleClass('hide');
                var expand = $(this).children('i');
                if(expand.hasClass('ti-angle-down')){
                    expand.attr('class', 'ti-angle-up');
                }else{
                    expand.attr('class', 'ti-angle-down');
                    var allWidgets =  $(this).parent().parent().find('.widget-area-body ul li');
                    $.each(allWidgets,function (value){
                        $(this).find('.content-part').removeClass('show');
                    });
                }
            });
        }(jQuery));
    </script>
    <script src="<?php echo e(asset('assets/backend/js/dropzone.js')); ?>"></script>
    <?php echo $__env->make('backend.partials.media-upload.media-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/backend/widgets/widget-index.blade.php ENDPATH**/ ?>