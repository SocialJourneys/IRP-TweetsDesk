<?php include('core/init.core.php');?>
<?php include('header.php');?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><small><?php echo 'Analysis ';?></small><br/><?php echo $term_type; echo $term_name;?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">

        <ol class="breadcrumb">
          <li class="active">Analysis</li>
      </ol>
</div>

<!-- /.row -->
<div class="row">
    <div class="col-lg-10 col-md-10 col-sm-12">
        <div class="panel panel-info">
            <div class="panel-heading" id="morris-hashtag-chart-panel">
                Top Trends
               
               <div class="form-group-row heading-menu pull-right" id="chart_menu">
                <!--label for="inputType" class="col-lg-2 col-md-2 col-sm-2 control-label"></label-->
                <div class='datetimepicker-input-group date'>
                    <input type='text' data-date-format="YYYY-MM-DD hh:mm:ss" class="datetimepicker-form-control" name='hashtag_chart_datetimepicker_from' id='hashtag_chart_datetimepicker_from' placeholder="From" required/>
                </div>
          

                    <!--label for="inputType" class="col-lg-1 col-md-1 col-sm-1 control-label"></label-->
                    <div class='datetimepicker-input-group date'>
                        <input type='text' data-date-format="YYYY-MM-DD hh:mm:ss" class="datetimepicker-form-control" name='hashtag_chart_datetimepicker_to' id='hashtag_chart_datetimepicker_to' placeholder="To" required/>
                    </div>
               
                    <div class='datetimepicker-input-group date datetimepicker-input-select'>
                        <select class="form-control" name="chart_frequency" id="hashtag_chart_frequency">
                              <option value="hour">Last hour</option>
                              <option value="day" selected="selected">Last day</option>
                              <option value="week">Last week</option>
                              <option value="month">Last month</option>
                          </select>
                </div>
                <div class='datetimepicker-input-group date'>
                    <button type='button' class="btn btn-success datetimepicker-form-control" onclick="add_hashtag_chart_data()">Refresh</button>
                </div>
            </div>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <span class="col-lg-10 col-md-10 col-sm-12" id="morris-hashtag-chart-error-message" style="font-size:20px; width:100%; height:100%; text-align:center;vertical-align:middle;">No tweets found.</span>
        <div id="morris-hashtag-chart"></div>
    </div>
    <!-- /.panel-body -->
</div>
<!-- /.panel -->
</div>
</div> <!-- /.row -->

<?php include('footer.php');?>

<script type="text/javascript" src="http-calls/chart-hashtag-data.js"> </script>

<script type="text/javascript">

//init date pickers
$('#hashtag_chart_datetimepicker_from').datetimepicker();
$('#hashtag_chart_datetimepicker_to').datetimepicker();

//date restriction
/*$("#chart_datetimepicker_from").on("dp.change",function (e) {
  $('#chart_datetimepicker_to').data("DateTimePicker").setMinDate(e.date);
});
$("#chart_datetimepicker_to").on("dp.change",function (e) {
  $('#chart_datetimepicker_from').data("DateTimePicker").setMinDate(e.date);
});*/


//clear date box on selection of dropdown menu
$('#hashtag_chart_frequency').on('change', function() {
    $('#hashtag_chart_datetimepicker_from').val('');
    $('#hashtag_chart_datetimepicker_to').val('');
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
$('#dataTables-tweets').dataTable({
        aaSorting: [[1, 'desc']],
        bPaginate: true,
        bFilter: true,
        bInfo: false,
        bSortable: true,
        bRetrieve: true,
        aoColumnDefs: [
            { "aTargets": [ 0 ], "bSortable": true },
            { "aTargets": [ 1 ], "bSortable": true },
            { "aTargets": [ 2 ], "bSortable": true }
        ],
        "oLanguage": {
            "sInfo": 'Showing _END_ Sources.',
            "sInfoEmpty": 'No tweets found',
            "sEmptyTable": "No tweets found.",
        }
    }); 
</script> 
