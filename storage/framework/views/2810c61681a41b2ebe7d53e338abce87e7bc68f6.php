



<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="<?php echo e(asset('bower_components/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>

<script src="<?php echo e(asset('bower_components/morris.js/morris.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/jquery-knob/dist/jquery.knob.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/moment/min/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/fastclick/lib/fastclick.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/PACE/pace.min.js')); ?>"></script>
<script src="<?php echo e(asset('dist/js/adminlte.min.js')); ?>"></script>

<script src="<?php echo e(asset('dist/js/demo.js')); ?>"></script>

<script>

    $(document).ajaxStart(function() { Pace.restart(); });


    $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.

        //bootstrap WYSIHTML5 - text editor
        $('.textarea').wysihtml5()
    })
</script>



<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="<?php echo e(asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.5/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>


<script src="<?php echo e(asset('plugins/Emoji-Picker-jQuery-Emoji-Plugin/js/plugins.js')); ?>"></script>



<script src="<?php echo e(asset('bower_components/select2/dist/js/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/input-mask/jquery.inputmask.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/input-mask/jquery.inputmask.date.extensions.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/input-mask/jquery.inputmask.extensions.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/moment/min/moment.min.js')); ?>"></script>

<script src="<?php echo e(asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/timepicker/bootstrap-timepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/iCheck/icheck.min.js')); ?>"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>







<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

<script src="<?php echo e(asset('jscript/pusherKey.js')); ?>"></script>

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
        //Money Euro
        $('[data-mask]').inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 1, format: 'MM/DD/YYYY h:mm A' });
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges   : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        );

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        });

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass   : 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });

        //Colorpicker
        $('.my-colorpicker1').colorpicker();
        //color picker with addon
        $('.my-colorpicker2').colorpicker();

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false
        })
    })
</script>






<script src="<?php echo e(asset('jscript/suggestion.js?n='.$javs)); ?>"></script>
<script src="<?php echo e(asset('jscript/ci-directory.js?n='.$javs)); ?>"></script>


    
    
        
    


<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>



<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>