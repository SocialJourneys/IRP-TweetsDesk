<?php include('core/init.core.php');?>
<?php include('header.php');?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">System Administration</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">

        <ol class="breadcrumb">
          <li class="active">System Admin</li>
      </ol>
</div>

<div class="row">
    <div class="col-lg-10">
        <div class="panel panel-info">
            <div class="panel-heading" id="admin-overview-tabel-panel">
                Overview
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-admin-overview">
                        <thead style="display:none;">
                                <tr>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr class="gradeA">
                                <td class="center" style="font-weight:bold;">Number of tweets</td>
                                <td class="center" style="color:#428bca;" id="no-of-tweets"></td>
                            </tr>
                                <tr class="gradeA">
                                <td class="center" style="font-weight:bold;">Tweets captured per second</td>
                                <td class="center" style="color:#428bca;" id="tweets-per-second"></td>
                            </tr>
                                <tr class="gradeA" >
                                <td class="center" style="font-weight:bold;">Tweets exported</td>
                                <td class="center" style="color:#428bca;"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<!-- /.row -->
<div class="row">
    <div class="col-lg-10 col-md-12 col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading" id="morris-admin-chart-panel">
                Tweets Captured
               
               <div class="form-group-row heading-menu pull-right" id="chart_menu">
                <!--label for="inputType" class="col-lg-2 col-md-2 col-sm-2 control-label"></label-->
                <div class='datetimepicker-input-group date'>
                    <input type='text' data-date-format="YYYY-MM-DD HH:mm:ss" class="datetimepicker-form-control" name='admin_chart_datetimepicker_from' id='admin_chart_datetimepicker_from' placeholder="From" required/>
                </div>
          

                    <!--label for="inputType" class="col-lg-1 col-md-1 col-sm-1 control-label"></label-->
                    <div class='datetimepicker-input-group date'>
                        <input type='text' data-date-format="YYYY-MM-DD HH:mm:ss" class="datetimepicker-form-control" name='admin_chart_datetimepicker_to' id='admin_chart_datetimepicker_to' placeholder="To" required/>
                    </div>
               
                    <div class='datetimepicker-input-group date datetimepicker-input-select'>
                        <select class="form-control" name="chart_frequency" id="admin_chart_frequency">
                              <option value="hour">Last hour</option>
                              <option value="day" selected="selected">Last day</option>
                              <option value="week">Last week</option>
                              <option value="month">Last month</option>
                          </select>
                </div>
                <div class='datetimepicker-input-group date'>
                    <button type='button' class="btn btn-success datetimepicker-form-control" onclick="add_admin_chart_data()">Refresh</button>
                </div>
            </div>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <span class="col-lg-10 col-md-12 col-sm-12" id="morris-admin-chart-error-message" style="font-size:20px; width:100%; height:100%; text-align:center;vertical-align:middle;">No tweets found.</span>
        <div id="morris-admin-chart"></div>
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
</div> <!-- /.row -->

<?php include('footer.php');?>

<script type="text/javascript" src="http-calls/admin1.js"> </script>

<script type="text/javascript">

//init date pickers
$('#admin_chart_datetimepicker_from').datetimepicker();
$('#admin_chart_datetimepicker_to').datetimepicker();

//date restriction
/*$("#chart_datetimepicker_from").on("dp.change",function (e) {
  $('#chart_datetimepicker_to').data("DateTimePicker").setMinDate(e.date);
});
$("#chart_datetimepicker_to").on("dp.change",function (e) {
  $('#chart_datetimepicker_from').data("DateTimePicker").setMinDate(e.date);
});*/


//clear date box on selection of dropdown menu
$('#admin_chart_frequency').on('change', function() {
    $('#admin_chart_datetimepicker_from').val('');
    $('#admin_chart_datetimepicker_to').val('');
});

/*$(function() {
    $("td[colspan=3]").find("p").hide();
    $("dataTables-tracklist").click(function(event) {
        event.stopPropagation();
        var $target = $(event.target);
        if ( $target.closest("td").attr("colspan") > 1 ) {
            $target.slideUp();
        } else {
            $target.closest("tr").next().find("p").slideToggle();
        }                    
    });
});*/

//data table init
$('#dataTables-admin-overview').dataTable({
        bPaginate: false,
        bFilter: false,
        bInfo: false,
        bSortable: false,
        bRetrieve: false,        "oLanguage": {
            "sInfo": 'Showing _END_ Sources.',
            "sInfoEmpty": '',
            "sEmptyTable": ' Nothing'
        }
    }); 
</script> 
