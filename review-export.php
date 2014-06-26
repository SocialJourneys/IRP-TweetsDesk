
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
    
    <div class="panel panel-info">
      
    <div class="panel-heading">Review</div>
   
    <div class="panel-body">
        <!-- table- -->
            <table class="table table-bordered">  
                <thead>
                    <tr>
                        <th class="text-center">Fields</th>
                        <th class="text-center">Filters</th>
                    </tr>
                </thead>
                <tbody>
                   <tr><!-- Number of Records-->
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
                    </tr><!-- Number of Records-->
                    

                    <tr> <!-- ID-->
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
                </tr><!-- ID-->


                <tr><!-- Created At-->
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
                </tr><!-- Created At-->


                <tr><!-- Favourites-->
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
                </tr><!-- Favourites-->

                <tr><!-- Retweets-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-retweets">
                          <input type="checkbox" name="review-checkbox" id="retweets">   
                          <strong>Retweets Count:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-retweets">
                        <label label-default="" for="review-filter-retweets">Count: </label>
                        <select class="form-control review-control" id="review-filter-retweets-condition">
                          <option>=</option>
                          <option>></option>
                          <option><</option>
                      </select>
                      <input type="text" class="form-control review-control" id="review-filter-retweets" placeholder="N/A">   
                    </div>
                    </td>
                </tr><!-- Retweets-->

                <tr><!-- Text-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-text">
                          <input type="checkbox" name="review-checkbox" id="text">   
                          <strong>Text:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-text">
                        <label label-default="" for="review-filter-text">Keywords: </label>
                        <select class="form-control review-control" id="review-filter-text-condition">
                          <option>contains</option>
                          <option>exact match</option>
                      </select>
                      <input type="text" class="form-control review-control" id="review-filter-text" placeholder="enter keyword">   
                    </div>
                    </td>
                </tr><!-- Text-->

                <tr><!-- Original Tweet ID-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-original-tweet-id">
                          <input type="checkbox" name="review-checkbox" id="original-tweet-id">   
                          <strong>Original Tweet ID:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-original-tweet-id">
                        <label label-default="" for="review-filter-original-tweet-id"></label>
                      <input type="text" class="form-control review-control" id="review-filter-original-tweet-id" placeholder="Enter Tweet ID">   
                    </div>
                    </td>
                </tr><!-- Original Tweet ID-->

                <tr><!-- In Reply to Username-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-reply-username">
                          <input type="checkbox" name="review-checkbox" id="reply-user">   
                          <strong>In Reply to Username:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-reply-username">
                        <label label-default="" for="review-filter-reply-username"></label>
                      <input type="text" class="form-control review-control" id="review-filter-reply-username" placeholder="@handle">   
                    </div>
                    </td>
                </tr><!-- In Reply to Username-->

                <tr><!-- In Reply to status ID-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-reply-status-id">
                          <input type="checkbox" name="review-checkbox" id="reply-status-id">   
                          <strong>In Reply to Status ID:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-reply-status-id">
                        <label label-default="" for="review-filter-reply-status-id"></label>
                      <input type="text" class="form-control review-control" id="review-filter-reply-status-id" placeholder="Enter Status ID">   
                    </div>
                    </td>
                </tr><!-- In Reply to status ID-->

                <tr><!-- In Reply to User ID-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-reply-user-id">
                          <input type="checkbox" name="review-checkbox" id="reply-user-id">   
                          <strong>In Reply to User ID:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-reply-user-id">
                        <label label-default="" for="review-filter-reply-user-id"></label>
                      <input type="text" class="form-control review-control" id="review-filter-reply-user-id" placeholder="Enter User ID">   
                    </div>
                    </td>
                </tr><!-- In Reply to User ID-->

                <tr><!-- Language Code-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-language-code">
                          <input type="checkbox" name="review-checkbox" id="language-code">   
                          <strong>Language Code:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-language-code">
                        <label label-default="" for="review-filter-language-code"></label>
                      <input type="text" class="form-control review-control" id="review-filter-language-code" placeholder="Enter Language Code">   
                    </div>
                    </td>
                </tr><!-- Language Code-->

                <tr><!-- Twitter Source-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-twitter-source">
                          <input type="checkbox" name="review-checkbox" id="twitter-source">   
                          <strong>Twitter Source:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-twitter-source">
                        <label label-default="" for="review-filter-twitter-source"></label>
                      <input type="text" class="form-control review-control" id="review-filter-twitter-source" placeholder="Enter Twitter Source">   
                    </div>
                    </td>
                </tr><!-- Twitter Source-->

                <tr><!-- User Numeric ID-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-twitter-source">
                          <input type="checkbox" name="review-checkbox" id="twitter-source">   
                          <strong>Twitter Source:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-twitter-source">
                        <label label-default="" for="review-filter-twitter-source"></label>
                      <input type="text" class="form-control review-control" id="review-filter-twitter-source" placeholder="Enter Twitter Source">   
                    </div>
                    </td>
                </tr><!-- User Numeric ID-->

            </tbody>

        </table>
        <!--export button-->
        <div class="input-group pull-right">
            <button type="button" class="btn btn-success dropdown-toggle header-button"><span class="fa fa-download fa-fw"></span> Export CSV</button>
        </div><!--export button-->

</div>      <!--div class="panel-body"-->

</div>     <!--div class="panel panel-info"-->

</div> <!--<div class="row col-xs-12 col-sm-12 col-lg-10 col-md-12"-->

<?php include('footer.php');?>
<script type="text/javascript">


//show hide surcharge fields depending on selection in passenger eligibility

$("input[name='review-checkbox']").each( function () {
        $(this).prop('checked', true);
    });

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
