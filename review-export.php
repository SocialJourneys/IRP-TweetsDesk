
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
   // exit(); 
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
  </div>
  <!-- /.row -->
  <div class="row col-xs-12 col-sm-12 col-lg-10 col-md-12">
    <div class="panel panel-info" id="tab-eligibility">
      <div class="panel-heading">
        Review
      </div>
      <div class="panel-body">
       <form class="form form-inline" role="form" id="tab-surcharge-structure-form">

        <fieldset>
          <legend>Select Fields:</legend>

          <div class="form-group col-xs-12 col-sm-12 col-lg-12">
            <label label-default="" for="review-field-no-records" class="col-xs-10">
              <input type="checkbox" name="eligible-checkbox" id="review-field-1" value="1">   
              <strong>Number of Records:</strong>
            </label>   
          </div> 

          <div class="review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="review-field-no-records">
            <label label-default="" for="review-field-1">Count: </label>
            <input type="text" class="form-control review-control" name="eligible-checkbox" id="review-field-no-records" placeholder="All Records">   
          </div>

          <div class="form-group col-xs-12 col-sm-12 col-lg-12">
            <label label-default="" for="review-field-1" class="col-xs-10">
              <input type="checkbox" name="eligible-checkbox" id="review-field-1" value="1">   
              <strong>Tweeted At:</strong>
            </label> 
          </div>   
          <div class="review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8">

            <label label-default="" for="review-field-1">Date Range: </label>
            <input type="text" class="form-control review-control" name="eligible-checkbox" id="review-field-1" placeholder="To">   
            <input type="text" class="form-control review-control" name="eligible-checkbox" id="review-field-1" placeholder="From">   
          </div>

          <div class="form-group col-xs-12 col-sm-12 col-lg-12">
            <label label-default="" for="review-field-1" class="col-xs-10">
              <input type="checkbox" name="eligible-checkbox" id="review-field-1" value="1">   
              <strong>Favourites Count:</strong>
            </label>
          </div> 
          <div class="review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8">
            <label label-default="" for="review-field-1">Count: </label>
            <select class="form-control review-control">
              <option>=</option>
              <option>></option>
              <option><</option>
              </select>
            <input type="text" class="form-control review-control" name="eligible-checkbox" id="review-field-1" placeholder="N/A">   
          </div>

          <div class="form-group col-xs-12 col-sm-12 col-lg-12">
            <label label-default="" for="review-field-1" class="col-xs-10">
              <input type="checkbox" name="eligible-checkbox" id="review-field-1" value="1">   
              <strong>Tweet Content:</strong>
            </label>
         </div>                                    
          <div class="review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8">
            <label label-default="" for="review-field-1">Keywords: </label>
            <select class="form-control review-control">
              <option>contains</option>
              <option>exact match</option>
              </select>
            <input type="text" class="form-control review-control" name="eligible-checkbox" id="review-field-1" placeholder="enter keyword">   
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
<script type="text/javascript">
  $("#review-field-no-records" ).addClass("review-filters-disabled");
  $('#review-field-no-records').attr('disabled', true);
</script>
