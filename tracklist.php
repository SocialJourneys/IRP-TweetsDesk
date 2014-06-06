
<?php include('header.php');?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tracklist</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">

        <div id="add-word" style="margin-top:50px;" class="mainbox col-md-6">                    
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title">Add Track Item</div>
                </div>     

                <div style="padding-top:30px" class="panel-body" >
                    <div style="display:none" id="add-alert" class="alert alert-danger col-sm-12"></div>
                    <form id="add-word-form" class="form-horizontal" role="form">

                <div class="row">
                  <div class="col-lg-10">
                    <div class="input-group">
                      <span class="input-group-addon" id="dropdown-symbol">@</span>
                      <input type="text" class="form-control">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" id="dropdown-title">Select Type <span class="caret"></span></button>
                        <ul class="dropdown-menu pull-right" id="dropdown-term-type">
                          <li><a href="#" value="hashtag">Hashtag</a></li>
                          <li><a href="#" value="handle">Handle</a></li>
                          <li><a href="#" value="search-term">Search Term</a></li>
                      </ul>
                  </div><!-- /btn-group -->
              </div><!-- /input-group -->
          </div><!-- /.col-lg-6 -->

      </div><!-- /.row -->

      <div style="margin-top:10px" class="form-group">
        <!-- Button -->

        <div class="col-sm-12 controls">
          <a id="btn-add" href="#" class="btn btn-primary pull-right">Add</a>

      </div>
  </div>
</form>     



</div>                     
</div>  
</div>
</div>

<?php 
$rawData = '{
    "0":{"id":10,"term":"Aberdeen","type":"hashtag"},
    "1":{"id":11,"term":"Glasgow","type":"search-term"},
    "2":{"id":12,"term":"FirstAberdeen","type":"handle"},
    "3":{"id":13,"term":"road block","type":"search-term"},
    "4":{"id":14,"term":"Edinburgh","type":"hashtag"},
    "5":{"id":15,"term":"Bus","type":"search-term"},
    "6":{"id":16,"term":"Waiting for bus","type":"search-term"},
    "7":{"id":17,"term":"StageCoach","type":"handle"},
    "8":{"id":18,"term":"UniOfStAndrews","type":"handle"},
    "9":{"id":19,"term":"Union Street","type":"search-term"},
    "10":{"id":20,"term":"KingStreet","type":"hashtag"},
    "11":{"id":21,"term":"MacRobert Building","type":"search-term"},
    "12":{"id":22,"term":"DotRural","type":"handle"},
    "13":{"id":23,"term":"raining","type":"hashtag"},
    "14":{"id":24,"term":"UniOfAberdeen","type":"handle"},
    "15":{"id":25,"term":"walking home","type":"search-term"},
    "16":{"id":26,"term":"walking in rain","type":"search-term"},
    "16":{"id":27,"term":"EarlyMorning","type":"hashtag"},
    "17":{"id":28,"term":"KingsCollege","type":"handle"},
    "18":{"id":29,"term":"SocialJourneys","type":"handle"},
    "19":{"id":30,"term":"Where is my bus?","type":"search-term"},
    "20":{"id":31,"term":"Dogs","type":"hashtag"}
}';

//echo $dataArray;
$dataArray = json_decode($rawData, true);

//print_r($dataArray);


?>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-info">
            <div class="panel-heading">
                Current Track Items
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-hashtag">
                        <thead>
                            <tr>
                                <th>Term</th>
                                <th>Type</th>
                                <th>    </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataArray as $key => $value) {
                                echo '<tr class="gradeA">';
                                echo '<td class="center"><a href="tracklist-details.php?id='.$value["term"].'">'.$value['term'].'</a></td>';
                                echo '<td class="center">'.$value['type'].'</td>';
                                echo"<td class='center'><a href=\"#\" class=\"btn btn-danger btn-sm active\" role=\"button\">Delete</a></td>";
                                echo '</tr>';
                            }?>
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



<?php include('footer.php');?>

<!-- Core Scripts - Include with every page -->
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

<!-- Page-Level Plugin Scripts - Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

<!-- JS Scripts - Include with every page -->
<script src="js/sb-admin.js"></script>

<!-- Data table init -->
<script>
$(document).ready(function() {
    $('#dataTables-hashtag').dataTable();
});

<!-- changing drop down title -->
$('.dropdown-toggle').dropdown();
$('#dropdown-term-type li').on('click',function(){
    $('#dropdown-title').text($(this).find('a').text());
    $('#dropdown-title').append(' '+"<span class='caret'></span>");
});

</script>


