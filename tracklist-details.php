
<?php //include('header.php');?>

<?php
    $term_name = $_GET['id'];
//http://dtp-24.sncs.abdn.ac.uk/phpPgAdmin/
        $db = pg_connect('host=localhost port=5432 dbname=tweetdesk user=postgres password=5L1ght1y'); 

        $query = "SELECT * FROM track_list"; 

        $result = pg_query($db,$query); 
        if (!$result) { 
            echo "Problem with query " . $query . "<br/>"; 
            echo pg_last_error(); 
            exit(); 
        } 

        //print_r($result);
        //die();

        while($myrow = pg_fetch_assoc($result)) { 
            print_r($myrow);
           // printf ("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $myrow['id'], htmlspecialchars($myrow['firstname']), htmlspecialchars($myrow['surname']), htmlspecialchars($myrow['emailaddress']));
        } 

        die();
        ?> 

?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tracking: <small><?php echo $term_name;?></small></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
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
                Overview
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-hashtag">
                        <thead>
                            <tr>
                                <th>Date Added</th>
                                <th>Date Used</th>
                                <th>Added By</th>
                            </tr>
                        </thead>
                        <tbody>
                               <tr class="gradeA">
                                <td class="center">30/May/2014</td>
                                <td class="center">02/June/2014</td>
                                <td class="center">Mujtaba</td>
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
    //$('#dataTables-hashtag').dataTable();
});

<!-- changing drop down title -->
$('.dropdown-toggle').dropdown();
$('#dropdown-term-type li').on('click',function(){
    $('#dropdown-title').html($(this).find('a').html());
    
});

</script>


