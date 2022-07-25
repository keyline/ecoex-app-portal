<script>
	function opennotifilterNav() {
	  document.getElementById("notifilter").style.width = "300px";
	}

	function closenotifilterNav() {
	  document.getElementById("notifilter").style.width = "0";
	}
</script>
<!-- debojyoti -->
	<!-- General JS Scripts -->
  	<script src="<?php echo site_url('public/assets/newadmin/js/');?>jquery-min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  	<script src="<?php echo site_url('public/assets/newadmin/js/');?>bootstrap.bundle.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  	<script src="<?php echo site_url('public/assets/newadmin/js/');?>stisla.js"></script>
  	<!-- Template JS File -->
  	<script src="<?php echo site_url('public/assets/newadmin/js/');?>scripts.js"></script>
  	<!-- <script src="<?php echo site_url('public/assets/newadmin/js/');?>custom.js"></script> -->
  	<!-- Page Specific JS File -->
  	<!-- <script src="<?php echo site_url('public/assets/newadmin/js/');?>page/index.js"></script> -->
<!-- debojyoti -->
	

<!-- jQuery UI 1.11.4 -->
	<script src="<?php echo site_url('public');?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
  		$.widget.bridge('uibutton', $.ui.button)
	</script>

<!-- plugins -->
	<!-- Select2 -->
	<script src="<?php echo site_url('public');?>/assets/plugins/select2/js/select2.full.min.js"></script>
	<!-- ChartJS -->
	<script src="<?php echo site_url('public');?>/assets/plugins/chart.js/Chart.min.js"></script>
	<!-- Sparkline -->
	<script src="<?php echo site_url('public');?>/assets/plugins/sparklines/sparkline.js"></script>
	<!-- JQVMap -->
	<script src="<?php echo site_url('public');?>/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
	<script src="<?php echo site_url('public');?>/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
	<!-- jQuery Knob Chart -->
	<script src="<?php echo site_url('public');?>/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
	<!-- daterangepicker -->
	<script src="<?php echo site_url('public');?>/assets/plugins/moment/moment.min.js"></script>
	<script src="<?php echo site_url('public');?>/assets/plugins/daterangepicker/daterangepicker.js"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?php echo site_url('public');?>/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
	<!-- Summernote -->
	<script src="<?php echo site_url('public');?>/assets/plugins/summernote/summernote-bs4.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="<?php echo site_url('public');?>/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- Toastr -->
	<script src="<?php echo site_url('public');?>/assets/plugins/toastr/toastr.min.js"></script>
<!-- plugins -->
<!-- progress bar -->
	<script src="<?php echo site_url('public');?>/assets/progress-bar.js"></script>
<!-- progress bar -->	
<?php echo (isset($sessionMsg) ? $sessionMsg : ""); ?>
<script>
$(function () {
	//Initialize Select2 Elements
	$('.select2').select2();
	//Initialize Select2 Elements
	$('.select2bs4').select2({
	  theme: 'bootstrap4'
	})
	//Date range picker
	$('#reservation').daterangepicker()
	//Date range picker with time picker
	$('#reservationtime').daterangepicker({
	  timePicker: true,
	  timePickerIncrement: 30,
	  locale: {
	    format: 'MM/DD/YYYY hh:mm A'
	  }
	})
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
	    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
	  }
	)
	//Timepicker
	$('#timepicker').datetimepicker({
	  format: 'LT'
	})
	$("input[data-bootstrap-switch]").each(function(){
	  $(this).bootstrapSwitch('state', $(this).prop('checked'));
	});
})
<?php
if(isset($jsScript)) {
	for($i=0;$i<count($jsScript);$i++) {
		echo $jsScript[$i];
	}
}
?>
</script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
    	$('#example').DataTable();
	});
</script>
<script type="text/javascript">
  $.fn.extend({
    treed: function (o) {
      
      var openedClass = 'fa fa-minus';
      var closedClass = 'fa fa-plus';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});
//Initialization of treeviews
$('#tree1').treed();
</script>
</body>
</html>
