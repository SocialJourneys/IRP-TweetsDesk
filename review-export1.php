
<?php //include('core/init.core.php');?>
<?php include('header.php');?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      //echo "<br/><br/><br/><br/><br/><br/>";
      $query = 'SELECT';
      $table = 'tweet';

      if(isset($_POST['no-of-records']))
        $num_of_records = trim($_POST['no-of-records']);
      if(isset($_POST['id']))
        $id = trim($_POST['id']);
      if(isset($_POST['captured-at-from']))
        $captured_at_from = trim($_POST['captured-at-from']);
      if(isset($_POST['captured-at-to']))
        $captured_at_to = trim($_POST['captured-at-to']);
      if(isset($_POST['tweeted-at-from']))
        $tweeted_at_from = trim($_POST['tweeted-at-from']);
      if(isset($_POST['tweeted-at-from']))
        $tweeted_at_to = trim($_POST['tweeted-at-to']);
      if(isset($_POST['author']))
        $author = trim($_POST['author']);
      if(isset($_POST['favourites']))
        $favourites = trim($_POST['favourites']);
      if(isset($_POST['favourites-condition']))
        $favourites_condition = trim($_POST['favourites-condition']);
      if(isset($_POST['retweets']))
        $retweets = trim($_POST['retweets']);
      if(isset($_POST['retweets-condition']))
        $retweets_condition = trim($_POST['retweets-condition']);
      if(isset($_POST['text']))
        $text = trim($_POST['text']);
      if(isset($_POST['original-tweet-id']))
        $original_tweet_id = trim($_POST['original-tweet-id']);
      if(isset($_POST['reply-username']))
        $reply_username = trim($_POST['reply-username']);   
      if(isset($_POST['reply-status-id']))
        $reply_status_id = trim($_POST['reply-status-id']);  
      if(isset($_POST['reply-tweet-id']))
        $reply_tweet_id = trim($_POST['reply-tweet-id']);  
      if(isset($_POST['language-code']))
        $language_code = trim($_POST['language-code']);                                  
      //id
      //captured-at-from,captured-at-to
      //tweeted-at-from,tweeted-at-to
      //author 
      //favourites, favourites-condition
      //retweets,retweets-condition
      //text
      //original-tweet-id
      //reply-username
      //reply-status-id
      //reply-tweet-id
      //language-code
      //twitter-source
      //reply-user-id
      //stakeholder

      //if(isset($_POST['no-of-records']))
      //print_r('this is'.$_POST['no-of-records']);
      //exit();
  }

//http://dtp-24.sncs.abdn.ac.uk/phpPgAdmin/
$db = pg_connect('host=localhost port=5432 dbname=tweetdesk user=postgres password=5L1ght1y'); 

$query = "SELECT * FROM tweet"; 

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
        <form class="myform" role ="form" method="post" action="review-export1.php">
            <table class="table table-bordered">  
                <thead>
                    <tr>
                        <th class="text-center"><h4>Fields</h4></th>
                        <th class="text-center"><h4>Filters</h4></th>
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
                         <input type="number" class="form-control review-control" id="review-filter-no-of-records" name="no-of-records" placeholder="Count">   
                    
                        <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Overall records you want to fetch. e.g: 0,10,1000">
                            <i class="fa fa-info"></i>
                        </button>
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
                            <input type="number" class="form-control review-control" id="review-filter-id" name="id" placeholder="Identifier"> 
                            <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Database ID for this record. e.g: 0,10,1000">
                                 <i class="fa fa-info"></i>
                            </button>
                      
                        </div>
                    </td>
                </tr><!-- ID-->


                <tr><!-- Captured At-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-captured-at">
                          <input type="checkbox" name="review-checkbox" id="captured-at">
                          <strong>Captured At:</strong>
                      </label> 
                    </div>   
                    </td>
                    <td>
                        <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-12 col-lg-12" id="filter-captured-at">
                            <label label-default="" for="review-filter-captured-at">Date Range: </label>
                            <input type='text' readonly="readonly" class="form-control review-control" id="review-filter-captured-at-from-datetimepicker" name="captured-at-from" placeholder="From"/>
                            <input type='text' readonly="readonly" class="form-control review-control" id="review-filter-captured-at-to-datetimepicker" name="captured-at-to" placeholder="To"/>
                            <!--input type="text" class="form-control review-control" id="review-filter-captured-at-to" placeholder="To"-->   
                            <!--input type="text" class="form-control review-control" id="review-filter-captured-at-from" placeholder="From"-->  
                            <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Date this tweet was captured in our system.">
                                <i class="fa fa-info"></i>
                            </button> 
                        </div>
                    </td>
                </tr><!-- Captured At-->


                <tr><!-- Tweeted At-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-tweeted-at">
                          <input type="checkbox" name="review-checkbox" id="tweeted-at">
                          <strong>Tweeted At:</strong>
                      </label> 
                    </div>   
                    </td>
                    <td>
                        <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-12 col-lg-12" id="filter-tweeted-at">
                            <label label-default="" for="review-filter-tweeted-at">Date Range: </label>
                             <input type='text' readonly="readonly" class="form-control review-control" id="review-filter-tweeted-at-from-datetimepicker" name="tweeted-at-from" placeholder="From"/>
                            <input type='text' readonly="readonly" class="form-control review-control" id="review-filter-tweeted-at-to-datetimepicker" name="tweeted-at-to" placeholder="To"/>
                            <!--input type="text" class="form-control review-control" id="review-filter-tweeted-at-to" placeholder="To"-->
                            <!--input type="text" class="form-control review-control" id="review-filter-tweeted-at-from" placeholder="From"-->
                            <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Date this tweet was tweeted by the author on twitter.">
                            <i class="fa fa-info"></i>
                        </button> 
                        </div>
                    </td>
                </tr><!-- Tweeted At-->


                <tr><!-- Tweet Author-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-author">
                          <input type="checkbox" name="review-checkbox" id="author">   
                          <strong>Author:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-author">
                        <label label-default="" for="review-filter-author"></label>
                      <input type="text" class="form-control review-control" id="review-filter-author" placeholder="@handle" name="author"> 
                      <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Twitter handle of the author. e.g @FirstAberdeen">
                       <i class="fa fa-info"></i>
                    </button>   
                    </div>
                    </td>
                </tr><!-- Tweet Author-->

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
                        <select class="form-control review-control" id="review-filter-favourites-condition" name="favourites-condition">
                          <option>=</option>
                          <option>></option>
                          <option><</option>
                      </select>
                      <input type="number" class="form-control review-control" id="review-filter-favourites" placeholder="N/A" name="favourites">   
                    <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Count of Favourites.">
                       <i class="fa fa-info"></i>
                    </button>   
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
                        <select class="form-control review-control" id="review-filter-retweets-condition" name="retweets-condition">
                          <option>=</option>
                          <option>></option>
                          <option><</option>
                      </select>
                      <input type="number" class="form-control review-control" id="review-filter-retweets" placeholder="N/A" name="retweets">   
                      <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Count of Retweets.">
                       <i class="fa fa-info"></i>
                    </button>   
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
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-12" id="filter-text">
                        <label label-default="" for="review-filter-text">Keywords: </label>
                        <select class="form-control review-control" id="review-filter-text-condition" name="text-condition">
                          <option>contains</option>
                          <option>exact match</option>
                      </select>
                      <input type="text" class="form-control review-control" id="review-filter-text" name="text" placeholder="enter keyword">   
                       <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Enter a keyword to filter tweet content. e.g rain, office, football">
                       <i class="fa fa-info"></i>
                    </button>   
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
                      <input type="number" class="form-control review-control" id="review-filter-original-tweet-id" name="original-tweet-id" placeholder="Enter Tweet ID">   
                         <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="The origianl tweet ID from twitter in numeric form.">
                       <i class="fa fa-info"></i>
                    </button>   
                    </div>
                    </td>
                </tr><!-- Original Tweet ID-->

                <tr><!-- In Reply to Username-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-reply-username">
                          <input type="checkbox" name="review-checkbox" id="reply-username">   
                          <strong>In Reply to Username:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-reply-username">
                        <label label-default="" for="review-filter-reply-username"></label>
                      <input type="text" class="form-control review-control" id="review-filter-reply-username" name="reply-username" placeholder="@handle">   
                         <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Twitter handle of the user this tweet is mentioned. e.g @ScotRail">
                       <i class="fa fa-info"></i>
                    </button>   
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
                      <input type="number" class="form-control review-control" id="review-filter-reply-status-id" name="reply-status-id" placeholder="Enter Status ID">   
                         <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Twitter tweet ID for status in numeric form.">
                       <i class="fa fa-info"></i>
                    </button>   
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
                      <input type="number" class="form-control review-control" id="review-filter-reply-user-id" name="reply-user-id" placeholder="Enter User ID">   
                         <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Twitter user ID in numeric form for the user this tweet is mentioned.">
                       <i class="fa fa-info"></i>
                    </button>   
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
                      <input type="text" class="form-control review-control" id="review-filter-language-code" name="language-code" placeholder="Enter Language Code">   
                         <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="ISO language code. e.g: en, de">
                       <i class="fa fa-info"></i>
                    </button>   
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
                      <input type="text" class="form-control review-control" id="review-filter-twitter-source" name="twitter-source" placeholder="Enter Twitter Source">   
                         <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="The source client used for the tweet. e.g: Twitter for iPhone">
                       <i class="fa fa-info"></i>
                    </button>   
                    </div>
                    </td>
                </tr><!-- Twitter Source-->

                <tr><!-- User Numeric ID-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-user-id">
                          <input type="checkbox" name="review-checkbox" id="user-id">   
                          <strong>Twitter User ID:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-user-id">
                        <label label-default="" for="review-filter-user-id"></label>
                      <input type="number" class="form-control review-control" id="review-filter-user-id" name="user-id" placeholder="Enter Numeric User ID">   
                         <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Twitter user ID for this author of tweet in numeric form.">
                       <i class="fa fa-info"></i>
                    </button>                       
                    </div>
                    </td>
                </tr><!-- User Numeric ID-->

                <tr><!-- Stakeholder-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-stakeholder">
                          <input type="checkbox" name="review-checkbox" id="stakeholder">   
                          <strong>Stakeholder:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-stakeholder">
                        <select class="form-control review-control" id="review-filter-stakeholder" name="stakeholder">
                          <option>Select</option>
                          <option>True</option>
                          <option>False</option>
                      </select>
                    </div>
                    </td>
                </tr><!-- Stakeholder-->

                <tr><!-- Filt Split-->
                    <td>
 
                    </td>
                    <td>

                    </td>
                </tr><!-- Stakeholder-->

            </tbody>

        </table>
        <!--export button-->
        <div class="input-group">

                              <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-split">
                          <input type="checkbox" name="review-checkbox" id="split">   
                          <strong>Split output file:</strong>
                                              <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Enter number of records per file. e.g 10000, 25000">
                       <i class="fa fa-info"></i>
                    </button>  
                      </label>
                    </div>  

                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-5 col-md-4 col-lg-4" id="filter-split">
                    <input type="text" class="form-control review-control" id="review-filter-split" placeholder="Enter value">   
 
                    </div>
            
            <div class="review-form-group col-xs-12 col-sm-12 col-lg-12" style="padding-top:10px;">
              <button type="submit" class="btn btn-success"><span class="fa fa-download fa-fw"></span> Export CSV</button>
            </div>
        </div><!--export button-->
      </form>

</div>      <!--div class="panel-body"-->

</div>     <!--div class="panel panel-info"-->

</div> <!--<div class="row col-xs-12 col-sm-12 col-lg-10 col-md-12"-->

<?php include('footer.php');?>


<script type="text/javascript">

$('#review-filter-captured-at-to-datetimepicker').datetimepicker();
$('#review-filter-captured-at-from-datetimepicker').datetimepicker();

$('#review-filter-tweeted-at-to-datetimepicker').datetimepicker();
$('#review-filter-tweeted-at-from-datetimepicker').datetimepicker();

//show hide surcharge fields depending on selection in passenger eligibility

$("input[name='review-checkbox']").each( function () {
        $(this).prop('checked', true);
    });

   /*$("input[name='review-checkbox']").each( function () {
    var value = $(this).attr('id');
    var passenger_elig_id = 'tab-surcharge-structure-pt-group-'+value;
    if(this.checked)
      $('#'+passenger_elig_id).hide();
  else
      $('#'+passenger_elig_id).show();
    });*/


   $("input[name='review-checkbox']").click(function() {

         // $("#review-field-no-records" ).addClass("review-filters-disabled");

         var field_id = $(this).attr('id');
         var filters_div = 'filter-'+field_id;
         if(this.checked){

            //grey out
                $("#"+filters_div).removeClass("review-filters-disabled");

                //disable inputs inside parent div
                $("#"+filters_div+" :input").attr("disabled", false);
            }
            else{
                $("#"+filters_div).addClass("review-filters-disabled");
                $("#"+filters_div+" :input").attr("disabled", true);
            }
        });

//info button tooltip initializer        
$('[data-toggle="tooltip"]').tooltip();

   </script>
