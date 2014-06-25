
<?php //include('core/init.core.php');?>
<?php include('header.php');?>
<?php
$term_name = $_GET['term_name'];
$term_type = $_GET['term_type'];
if($term_type==='handle')
    $term_type='@';
if($term_type==='hashtag')
    $term_type='#';
if($term_type==='search-term')
    $term_type='$';

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

  //      while($myrow = pg_fetch_assoc($result)) { 
           // print_r($myrow);
           // printf ("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $myrow['id'], htmlspecialchars($myrow['firstname']), htmlspecialchars($myrow['surname']), htmlspecialchars($myrow['emailaddress']));
    //    } 

       // die();
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Review & Export</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">

        <ol class="breadcrumb">
          <li class="active">Review & Export</li>
      </ol>

      <div class="col-xs-8 col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                Overview
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
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
<div class="row col-lg-10 col-md-12">
<div class="panel panel-info" id="tab-eligibility">
        <div class="panel-heading">
                Review
            </div>
      <div class="panel-body">
         <form class="form form-inline" role="form" id="tab-surcharge-structure-form">

                    <fieldset>
                        <legend>Select Fields:</legend>

                        <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                                <label label-default="" for="tab-eligibility-field-1" class="col-xs-6">
                                    <input type="checkbox" name="eligible-checkbox" id="tab-eligibility-field-1" value="1">   
                                    Under 16 years of age
                                </label>                
                            </div>                                    

                        <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                                <label label-default="" for="tab-eligibility-field-2" class="col-xs-6">
                                    <input type="checkbox" name="eligible-checkbox" id="tab-eligibility-field-2" value="2"> 17 to 21 years of age
                                </label>                                        
                            </div>
                        <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                                <label label-default="" for="tab-eligibility-field-3" class="col-xs-6">
                                    <input type="checkbox" name="eligible-checkbox" id="tab-eligibility-field-3" value="3"> 22 to 54 years of age
                                </label>
                            </div>
                        <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                                <label label-default="" for="tab-eligibility-field-4" class="col-xs-6">
                                    <input type="checkbox" name="eligible-checkbox" id="tab-eligibility-field-4" value="4"> 55 to 59 years of age
                                </label>
                            </div>

                        <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                                <label label-default="" for="tab-eligibility-field-5" class="col-xs-6">
                                    <input type="checkbox" name="eligible-checkbox" id="tab-eligibility-field-5" value="5"> 60 years or above
                                </label>
                            </div>
                    </fieldset>
            </form>
        </div>
    </div>
    </div>
<?php include('footer.php');?>
