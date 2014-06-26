
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

        <!-- table- -->
        <div class="table">
            <table class="table table-bordered">  
                <thead>
                    <tr>
                        <th class="text-center">Fields</th>
                        <th class="text-center">Filters</th>
                    </tr>
                </thead>
                <tbody>
                   <tr>
                    <td>          
                        <div class="review-form-group form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label label-default="" for="review-field-no-of-records">
                              <input type="checkbox" name="review-checkbox" id="no-of-records">   
                              <strong> Number of Records:</strong>
                          </label>   
                      </div> 
                  </td>
                    <td>
                        <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-no-of-records">
                         <label label-default="" for="review-filter-no-of-records"></label>
                         <input type="text" class="form-control review-control" id="review-filter-no-of-records" placeholder="Count">   
                         </div>
                    </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                            <label label-default="" for="review-field-id">
                            <input type="checkbox" name="review-checkbox" id="id">
                            <strong> ID:</strong>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="review-form-group review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-id">
                            <label label-default="" for="review-filter-id">
                            </label> 
                            <input type="text" class="form-control review-control" id="review-filter-id" placeholder="Identifier">   
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-created-at">
                          <input type="checkbox" name="review-checkbox" id="created-at">
                          <strong>Created At:</strong>
                      </label> 
                    </div>   
                    </td>
                    <td>
                        <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-12 col-lg-12" id="filter-created-at">
                            <label label-default="" for="review-filter-created-at">Date Range: </label>
                            <input type="text" class="form-control review-control" id="review-filter-created-at-to" placeholder="To">   
                            <input type="text" class="form-control review-control" id="review-filter-created-at-from" placeholder="From">   
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-favourites">
                          <input type="checkbox" name="review-checkbox" id="favourites">   
                          <strong>Favourites Count:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-favourites">
                        <label label-default="" for="review-filter-favourites">Count: </label>
                        <select class="form-control review-control" id="review-filter-favourites-condition">
                          <option>=</option>
                          <option>></option>
                          <option><</option>
                      </select>
                      <input type="text" class="form-control review-control" id="review-filter-favourites" placeholder="N/A">   
                    </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<!-- /.table- -->


<form class="form form-inline" role="form" id="tab-surcharge-structure-form">

    <fieldset>
      <legend>Select Fields:</legend>

      <!-- Number of Records-->
      <div class="form-group col-xs-12 col-sm-12 col-lg-12">
        <label label-default="" for="review-field-no-of-records" class="col-xs-10">
          <input type="checkbox" name="review-checkbox" id="no-of-records">   
          <strong>Number of Records:</strong>
      </label>   
  </div> 
  <div class="review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-no-of-records">
    <label label-default="" for="review-filter-no-of-records">Count: </label>
    <input type="text" class="form-control review-control" id="review-filter-no-of-records" placeholder="All Records">   
</div>
<!-- Number of Records-->

<!-- ID-->
<div class="form-group col-xs-12 col-sm-12 col-lg-12">
    <label label-default="" for="review-field-no-records" class="col-xs-10">
      <input type="checkbox" name="review-checkbox" id="id">   
      <strong>ID:</strong>
  </label>   
</div> 
<div class="review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-id">
    <label label-default="" for="review-filter-id">Identifier: </label>
    <input type="text" class="form-control review-control" id="review-filter-id" placeholder="N/A">   
</div>
<!-- ID-->

<!-- Created At--> 
<div class="form-group col-xs-12 col-sm-12 col-lg-12">
    <label label-default="" for="review-field-created-at" class="col-xs-10">
      <input type="checkbox" name="review-checkbox" id="created-at">   
      <strong>Created At:</strong>
  </label> 
</div>   
<div class="review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-created-at">
    <label label-default="" for="review-filter-created-at">Date Range: </label>
    <input type="text" class="form-control review-control" id="review-filter-created-at-to" placeholder="To">   
    <input type="text" class="form-control review-control" id="review-filter-created-at-from" placeholder="From">   
</div>
<!-- Created At--> 

<!-- Favourites--> 
<div class="form-group col-xs-12 col-sm-12 col-lg-12">
    <label label-default="" for="review-field-favourites" class="col-xs-10">
      <input type="checkbox" name="review-checkbox" id="favourites">   
      <strong>Favourites Count:</strong>
  </label>
</div> 
<div class="review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-favourites">
    <label label-default="" for="review-filter-favourites">Count: </label>
    <select class="form-control review-control" id="review-filter-favourites-condition">
      <option>=</option>
      <option>></option>
      <option><</option>
  </select>
  <input type="text" class="form-control review-control" id="review-filter-favourites" placeholder="N/A">   
</div>
<!-- Favourites--> 

<div class="form-group col-xs-12 col-sm-12 col-lg-12">
    <label label-default="" for="review-field-text" class="col-xs-10">
      <input type="checkbox" name="review-checkbox" id="text">   
      <strong>Text:</strong>
  </label>
</div>                                    
<div class="review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-text">
    <label label-default="" for="review-filter-text">Keywords: </label>
    <select class="form-control review-control" id="review-filter-text-condition">
      <option>contains</option>
      <option>exact match</option>
  </select>
  <input type="text" class="form-control review-control" name="eligible-checkbox" id="review-filter-text" placeholder="enter keyword">   
</div>

</fieldset>
</form>
</div>
</div>
<div class="input-group pull-right">
    <button type="button" class="btn btn-success dropdown-toggle header-button"><span class="fa fa-download fa-fw"></span> Export CSV</button>
</div><!-- /input-group -->

</div>

<?php include('footer.php');?>
<script type="text/javascript">




   //show hide surcharge fields depending on selection in passenger eligibility

   $("input[name='review-checkbox']").each( function () {
    var value = $(this).attr('id');
    var passenger_elig_id = 'tab-surcharge-structure-pt-group-'+value;
    if(this.checked)
      $('#'+passenger_elig_id).hide();
  else
      $('#'+passenger_elig_id).show();
});


   $("input[name='review-checkbox']").click(function() {

         // $("#review-field-no-records" ).addClass("review-filters-disabled");

         var field_id = $(this).attr('id');
         var filters_div = 'filter-'+field_id;
         if(this.checked){
          $("#"+filters_div).removeClass("review-filters-disabled");
          $("#"+filters_div+" :input").attr("disabled", false);

      }
      else{
        $("#"+filters_div).addClass("review-filters-disabled");
        $("#"+filters_div+" :input").attr("disabled", true);

    }
});

   </script>
