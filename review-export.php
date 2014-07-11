<?php include('core/init.core.php');?>
<?php include('header.php');?>
<?php include('export_csv.php');?>
?>
<?php

$db_count = db_count();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

      $query = 'SELECT ';
      $where = '';
      $fields= '';
      $table = 'tweet';

      $comb_criteria = ' '.$_POST['filters_criteria'].' '; //AND or OR

      foreach($_POST['review-checkbox'] as $checkbox) {

          //$checkbox is the table field and $_POST[$checkbox] is the value

        
        //get all the field names
        /*if($checkbox==='limit' && (!empty($_POST['limit'])))
              $limit = ' LIMIT '.$_POST[$checkbox];
        elseif($checkbox!='limit')*/
          {
        //handling first comma
           if($fields) 
                $fields = $fields.', '.$checkbox;
           else
              $fields = $checkbox;
          }

          //build the where clause
           switch ($checkbox) {
            case 'id':{
              if(trim($_POST[$checkbox])!=""){
                
                if($where)
                  $where = $where . $comb_criteria;

                $where = $where.' '.$checkbox. ' = '.trim($_POST[$checkbox]);
              }
               break;
             }
             case 'created_at':{
             if(trim($_POST[$checkbox.'_from'])!="" || trim($_POST[$checkbox.'_to'])!=""){

              // add AND if where already exists, otherwise its a new where clause
              if($where)
                $where = $where . ' AND ';

              //being Where
              $where = $where.' (';
                
              //$_POST[$checkbox.'_from'] = DateTime::createFromFormat('d/m/Y h:i A', $_POST[$checkbox.'_from'])->format('Y-m-d');

                //from date
              if(trim($_POST[$checkbox.'_from'])!=""){
                //add commas to string
                //$_POST[$checkbox.'_from'] = "'".trim($_POST[$checkbox.'_from'])."'";
                $from = "'".trim($_POST[$checkbox.'_from'])."'";
                //create where clause
                $where = $where.$checkbox.' >= '.$from;
              }
              //to date
              if(trim($_POST[$checkbox.'_to'])!=""){
                //if from date set, create AND clause
                if(trim($_POST[$checkbox.'_from'])!="")
                     $where = $where . ' AND ';

                //add commas to string
                //$_POST[$checkbox.'_to'] = "'".trim($_POST[$checkbox.'_to'])."'";
                $to = "'".trim($_POST[$checkbox.'_to'])."'";
                //create where clause
                $where = $where.$checkbox.' <= '.$to;
              }

              //close Where
                $where = $where.' )';
              }
               # code...
               break;
             }

             case 'time_stamp':{
             if(trim($_POST[$checkbox.'_from'])!="" || trim($_POST[$checkbox.'_to'])!=""){

              if($where)
                $where = $where . ' AND ';

              $where = $where.' (';
                
              //$_POST[$checkbox.'_from'] = DateTime::createFromFormat('d/m/Y h:i A', $_POST[$checkbox.'_from'])->format('Y-m-d');

              if(trim($_POST[$checkbox.'_from'])!=""){
//                $_POST[$checkbox.'_from'] = "'".trim($_POST[$checkbox.'_from'])."'";
                $from = "'".trim($_POST[$checkbox.'_from'])."'";
                $where = $where.$checkbox.'>='.$from;
              }
              if(trim($_POST[$checkbox.'_to'])!=""){
                if(trim($_POST[$checkbox.'_from'])!="")
                     $where = $where . ' AND ';

                //$_POST[$checkbox.'_to'] = "'".trim($_POST[$checkbox.'_to'])."'";
                $to = "'".trim($_POST[$checkbox.'_to'])."'";
                $where = $where.$checkbox.'<='.$to;
              }

                $where = $where.' )';
              }
               # code...
               break;
             }

             case 'favourite_count':{
              if(trim($_POST[$checkbox])!=""){
               // die();
                if($where)
                  $where = $where . $comb_criteria;

                $where = $where.' '.$checkbox. $_POST[$checkbox.'_condition'].trim($_POST[$checkbox]);
              }
               break;
             }

             case 're_tweeet_count':{
              if(trim($_POST[$checkbox])!=""){
                
                if($where)
                  $where = $where . $comb_criteria;

                $where = $where.' '.$checkbox. $_POST[$checkbox.'_condition'].trim($_POST[$checkbox]);
              }
               break;
             }

             case 'text':{
              $keywords = get_form_data_kv('textKeyword_condition_','text_');
              $text_comb_criteria = ' '.$_POST['textFilters_criteria'].' '; //AND or OR                

              if(trim($_POST[$checkbox])!="" || sizeof($keywords)>0){
                
                if($where)
                  $where = $where . $comb_criteria;

                $where = $where.' (';

                if(trim($_POST[$checkbox])!=""){
                    if($_POST[$checkbox.'Keyword_condition']==='LIKE')
                  //    $_POST[$checkbox] = "'%".trim($_POST[$checkbox])."%'";
                        $text = "'%".trim($_POST[$checkbox])."%'"; 

                    $where = $where.' LOWER('.$checkbox.') '.$_POST[$checkbox.'Keyword_condition'].' LOWER('.$text.')';
                }

                //loop through dynamic boxes
                foreach ($keywords as $key => $value) {
                  if($value!=""){
                    //extract the condition from key :e.g k1_LIKE
                    $condition = explode("_", $key);
                    $condition = $condition[1];
                    if(trim($text)!="")
                      $where = $where.$text_comb_criteria;

                    if($condition==='LIKE')
                        $text = "'%".trim($value)."%'"; 

                    $where = $where.' LOWER('.$checkbox.') '.$condition.' '.'LOWER('.$text.')';
                  }
                       // echo( 'condition: ' . $key.', value:'.$value.'<br/>' );
                    //    echo sizeof($keywords);
                }

                $where = $where.' )';

              //  die();
              }
               break;
             }

             default:{
              if(trim($_POST[$checkbox])!=""){
                
                $inpval = trim($_POST[$checkbox]);
                $condition = " = ";

                if($checkbox==='in_reply_to_screen_name' || $checkbox==='iso_language_code' || $checkbox==='source' || $checkbox==='author'){
                  //$_POST[$checkbox] = "'".trim($_POST[$checkbox])."'";
                    $inpval = "'%".$inpval."%'";
                    $condition = " LIKE ";
                  }
                
                if($where)
                  $where = $where . $comb_criteria;

                $where = $where.' LOWER('.$checkbox.')'.$condition.'LOWER('.$inpval.')';
              }
               break;
             }
           }

        } // for loop

        //echo $fields;
        //echo "<br/>";
        //echo $where;
        if(empty($fields))
          $fields = '*';
        if(!empty($where))
          $where = ' WHERE '.$where;
        
        if(trim($_POST['split'])!="")
            $split = trim(($_POST['split']));
        else
            $split = 1;
        
        if(!empty($_POST['limit']))
          $limit = ' LIMIT '.trim($_POST['limit']);

        $query = $query .$fields.' from '. $table.$where.$limit;


        $returnArray = dbExport($query,intval($split));               
        $zipname = $returnArray[0];
        $records = $returnArray[1];

        //echo 'records: '.$records;
        //$csv_filename = 'TMI_db_export'.'_'.date('Y-m-d').'.csv';

  //      header('Content-Type: application/zip');
//header('Content-disposition: attachment; filename=filename.zip');
//header('Content-Length: ' . filesize($zipname));
//readfile($zipname);
  }
//value represents database field name
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
      
    <div class="panel-heading">Review
      <span class="pull-right" style="padding-bottom:10px;"><strong>Available records: <span style="color:green;"><?php echo $db_count?></span></strong></span>
  </div>
   
    <div class="panel-body">
        <!-- table- -->
        <form class="myform" role ="form" method="post" action="">
            <table class="table table-bordered">  
                <thead> 
               <p> <span style="color:Red;">*</span> fields are required.
 </p> 

                    </td>
                </tr><!-- required text Split-->
                    <tr>
                        <th class="text-center"><h4>Fields</h4><button type="button" class="btn btn-xs btn-info" onClick="selectAll()">Select All</button><button type="button" style="margin-left:5px;" class="btn btn-xs btn-warning" onClick="uncheckAll()">Uncheck All</button></th>
                        <th class="text-center"><h4>Filters</h4>

                          <label class="control-label" style="font-size:14px; font-weight:normal; margin-bottom: 0; margin-top: 0;"><strong>Criteria:</strong></label>
                          <label class="radio" style="display:inline-block; font-size:14px; font-weight:normal; margin-bottom: 0; margin-top: 0; min-height: 20px; padding-left: 25px;">
                            <input type="radio" name="filters_criteria" id="filters_criteria_all" value="AND" checked>All of these
                          </label>
                          <label class="radio" style="display:inline-block; font-size:14px; font-weight:normal; margin-bottom: 0; margin-top: 0; min-height: 20px; padding-left: 25px;">
                            <input type="radio" name="filters_criteria" id="filters_criteria_any" value="OR">Any of these</label>
                      </th>
                    </tr>
                </thead>
                <tbody>
                   <tr><!-- Number of Records-->
                    <td>          
                        <div class="review-form-group form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label label-default="" for="review-field-no-of-records">
                              <!--input type="checkbox" name="review-checkbox[]" value="limit" id="no-of-records" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("limit", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> -->   
                              <strong> Number of Records<span style="color:Red;">*</span>:</strong>
                          </label>   
                      </div> 
                  </td>
                    <td>
                        <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-10" id="filter-no-of-records">
                         <label label-default="" for="review-filter-no-of-records"></label>
                         <input type="number" class="form-control review-control" name="limit" id="review-filter-no-of-records" placeholder="Count" value="<?php echo isset($_POST['limit'])?$_POST['limit'] :'1000'?>" required/>   
                    
                        <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Overall records you want to fetch. e.g: 0,10,1000. This field is required.">
                            <i class="fa fa-info"></i>
                        </button>
                    </div>
                    </td>
                    </tr><!-- Number of Records-->
                    

                    <tr> <!-- ID-->
                        <td>
                            <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                            <label label-default="" for="review-field-id">
                            <input type="checkbox" name="review-checkbox[]" value="id" id="db-id" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("id", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >
                            <strong> ID:</strong>
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="review-form-group review-filters form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-db-id">
                            <label label-default="" for="review-filter-db-id">
                            </label> 
                            <input type="number" class="form-control review-control" name="id" id="review-filter-db-id" placeholder="Identifier" value="<?php echo isset($_POST['id'])?$_POST['id'] :''?>" /> 
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
                          <input type="checkbox" name="review-checkbox[]" value="time_stamp" id="captured-at" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("time_stamp", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >
                          <strong>Captured At:</strong>
                      </label> 
                    </div>   
                    </td>
                    <td>
                        <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-12 col-lg-12" id="filter-captured-at">
                            <label label-default="" for="review-filter-captured-at" style="display:block;">Date Range: </label>
                            <input type='text' class="form-control review-control" name="time_stamp_from" id="review-filter-captured-at-from" data-date-format="YYYY-MM-DD HH:mm:ss" placeholder="From" value="<?php echo isset($_POST['time_stamp_from'])?$_POST['time_stamp_from'] :''?>"/>
                            <input type='text' class="form-control review-control" name="time_stamp_to" id="review-filter-captured-at-to" data-date-format="YYYY-MM-DD HH:mm:ss" placeholder="To" value="<?php echo isset($_POST['time_stamp_to'])?$_POST['time_stamp_to'] :''?>"/>
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
                          <input type="checkbox" name="review-checkbox[]" value="created_at" id="tweeted-at" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("created_at", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >
                          <strong>Tweeted At:</strong>
                      </label> 
                    </div>   
                    </td>
                    <td>
                        <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-12 col-lg-12" id="filter-tweeted-at">
                            <label label-default="" for="review-filter-tweeted-at" style="display:block;">Date Range: </label>
                             <input type='text' class="form-control review-control" name="created_at_from" id="review-filter-tweeted-at-from" data-date-format="YYYY-MM-DD HH:mm:ss" placeholder="From" value="<?php echo isset($_POST['created_at_from'])?$_POST['created_at_from'] :''?>"/>
                            <input type='text' class="form-control review-control" name="created_at_to" id="review-filter-tweeted-at-to" data-date-format="YYYY-MM-DD HH:mm:ss" placeholder="To" value="<?php echo isset($_POST['created_at_to'])?$_POST['created_at_to'] :''?>"/>
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
                          <input type="checkbox" name="review-checkbox[]" value="author" id="tweet-author" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("author", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >   
                          <strong>Author:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-tweet-author">
                        <label label-default="" for="review-filter-tweet-author"></label>
                      <input type="text" class="form-control review-control" name="author" placeholder="@handle" id="review-filter-tweet-author" value="<?php echo isset($_POST['author'])?$_POST['author'] :''?>"/>
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
                          <input type="checkbox" name="review-checkbox[]" value="favourite_count" id="favourites" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("favourite_count", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >     
                          <strong>Favourites Count:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-favourites">
                        <label label-default="" for="review-filter-favourites" style="display:block;">Count: </label>
                        <select class="form-control review-control" name="favourite_count_condition" id="review-filter-favourites-condition"/>
                          <option value="=" <?php if($_POST['favourite_count_condition'] == "=") echo "selected";?> >=</option>
                          <option value=">" <?php if($_POST['favourite_count_condition'] == ">") echo "selected";?> >></option>
                          <option value="<" <?php if($_POST['favourite_count_condition'] == "<") echo "selected";?> ><</option>
                      </select>
                      <input type="number" class="form-control review-control" name="favourite_count" placeholder="N/A" id="review-filter-favourites" value="<?php echo isset($_POST['favourite_count'])?$_POST['favourite_count'] :''?>"/> 
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
                          <input type="checkbox" name="review-checkbox[]" value="re_tweeet_count" id="retweets" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("re_tweeet_count", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >        
                          <strong>Retweets Count:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-retweets">
                        <label label-default="" for="review-filter-retweets" style="display:block;">Count: </label>
                        <select class="form-control review-control" name="re_tweeet_count_condition" id="review-filter-retweets-condition">
                          <option value="=" <?php if($_POST['re_tweeet_count_condition'] == "=") echo "selected";?> >=</option>
                          <option value=">" <?php if($_POST['re_tweeet_count_condition'] == ">") echo "selected";?> >></option>
                          <option value="<" <?php if($_POST['re_tweeet_count_condition'] == "<") echo "selected";?> ><</option>
                      </select>
                      <input type="number" class="form-control review-control" name="re_tweeet_count" placeholder="N/A" id="review-filter-retweets" value="<?php echo isset($_POST['re_tweeet_count'])?$_POST['re_tweeet_count'] :''?>"/>   
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
                          <input type="checkbox" name="review-checkbox[]" value="text" id="tweet-content" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("text", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >          
                          <strong>Tweet Content:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-12 col-lg-12" id="filter-tweet-content">
                        <label label-default="" for="review-filter-tweet-content" style="display:block;">Keywords: 
                        <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Enter a keyword to filter tweet content. e.g rain, office, football">
                       <i class="fa fa-info"></i>
                    </button> 
                          <label class="radio" style="display:inline-block; font-size:14px; font-weight:normal; margin-bottom: 0; margin-top: 0; min-height: 20px; padding-left: 25px;">
                            <input type="radio" name="textFilters_criteria" id="textFilters_criteria_any" value="OR" checked>Any of these
                          </label>
                          <label class="radio" style="display:inline-block; font-size:14px; font-weight:normal; margin-bottom: 0; margin-top: 0; min-height: 20px; padding-left: 25px;">
                            <input type="radio" name="textFilters_criteria" id="textFilters_criteria_all" value="AND">All of these
                              </label>
                        </label>

                        <select class="form-control review-control" name="textKeyword_condition" id="review-filter-tweet-content-condition">
                          <option value="LIKE" <?php if($_POST['textKeyword_condition'] == "LIKE") echo "selected";?> >contains</option>
                          <option value="=" <?php if($_POST['textKeyword_condition'] == "=") echo "selected";?> >exact match</option>
                      </select>
                      <input type="text" class="form-control review-control" name="text" id="review-filter-tweet-content" placeholder="enter keyword" value="<?php echo isset($_POST['text'])?$_POST['text'] :''?>"/>    


                      <button type="button" class="btn btn-xs btn-primary" id="add-keyword" style="margin-bottom: 5px;">Add Keyword</button>

                      <div class="multiple-keywords">
                        <?php
                          $keywords = get_form_data_kv('textKeyword_condition_','text_');
                          $fieldCount = 1;
                          foreach ($keywords as $key => $value) {
                                  $condition = explode("_", $key);
                                  $condition = $condition[1];
                                        echo'<div class="form-group-keyword"><select class="form-control review-control" name="textKeyword_condition_'.$fieldCount.'"id="textKeyword_condition_'.$fieldCount.'"><option value="LIKE" '; if($condition==='LIKE')echo "selected"; echo'>contains</option><option value="=" ';if($condition==='=') echo "selected"; echo '>exact match</option></select><input type="text" class="form-control review-control" name="text_'.$fieldCount.'"id="text_'.$fieldCount.'" placeholder="enter keyword" '; echo 'value='.$value; echo '> <a href="#" class="removeclass5">&times;</a></div>';
                                        $fieldCount++;
                          }?>
                      </div>
                    </div>
                    </td>
                </tr><!-- Text-->

                <tr><!-- Original Tweet ID-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-original-tweet-id">
                          <input type="checkbox" name="review-checkbox[]" value="original_tweet_id" id="original-tweet-id" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("original_tweet_id", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >           
                          <strong>Original Tweet ID:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-original-tweet-id">
                        <label label-default="" for="review-filter-original-tweet-id"></label>
                      <input type="number" class="form-control review-control" name="original_tweet_id" id="review-filter-original-tweet-id" placeholder="Enter Tweet ID" value="<?php echo isset($_POST['original_tweet_id'])?$_POST['original_tweet_id'] :''?>"/>      
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
                          <input type="checkbox" name="review-checkbox[]" value="in_reply_to_screen_name" id="reply-username" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("in_reply_to_screen_name", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >  
                          <strong>In Reply to Username:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-reply-username">
                        <label label-default="" for="review-filter-reply-username"></label>
                      <input type="text" class="form-control review-control" name="in_reply_to_screen_name" id="review-filter-reply-username" placeholder="@handle" value="<?php echo isset($_POST['in_reply_to_screen_name'])?$_POST['in_reply_to_screen_name'] :''?>"/>   
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
                          <input type="checkbox" name="review-checkbox[]" value="in_reply_to_status_id" id="reply-status-id" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("in_reply_to_status_id", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >  
                          <strong>In Reply to Status ID:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-reply-status-id">
                        <label label-default="" for="review-filter-reply-status-id"></label>
                      <input type="number" class="form-control review-control" name="in_reply_to_status_id" id="review-filter-reply-status-id" placeholder="Enter Status ID" value="<?php echo isset($_POST['in_reply_to_status_id'])?$_POST['in_reply_to_status_id'] :''?>"/> 
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
                          <input type="checkbox" name="review-checkbox[]" value="in_reply_to_user_id" id="reply-user-id" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("in_reply_to_user_id", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >
                          <strong>In Reply to User ID:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-reply-user-id">
                        <label label-default="" for="review-filter-reply-user-id"></label>
                      <input type="number" class="form-control review-control" name="in_reply_to_user_id" id="review-filter-reply-user-id" placeholder="Enter User ID" value="<?php echo isset($_POST['in_reply_to_user_id'])?$_POST['in_reply_to_user_id'] :''?>"/>    
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
                          <input type="checkbox" name="review-checkbox[]" value="iso_language_code" id="language-code" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("iso_language_code", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >  
                          <strong>Language Code:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-language-code">
                        <label label-default="" for="review-filter-language-code"></label>
                      <input type="text" class="form-control review-control" name="iso_language_code" id="review-filter-language-code" placeholder="Enter Language Code" value="<?php echo isset($_POST['iso_language_code'])?$_POST['iso_language_code'] :''?>"/>   
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
                          <input type="checkbox" name="review-checkbox[]" value="source" id="twitter-source" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("source", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >   
                          <strong>Twitter Source:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-twitter-source">
                        <label label-default="" for="review-filter-twitter-source"></label>
                      <input type="text" class="form-control review-control" name="source" id="review-filter-twitter-source" placeholder="Enter Twitter Source" value="<?php echo isset($_POST['source'])?$_POST['source'] :''?>"/>      
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
                          <input type="checkbox" name="review-checkbox[]" value="user_id" id="user-id" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("user_id", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >   
                          <strong>Twitter User ID:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-user-id">
                        <label label-default="" for="review-filter-user-id"></label>
                      <input type="number" class="form-control review-control" name="user_id" id="review-filter-user-id" placeholder="Enter Numeric User ID" value="<?php echo isset($_POST['user_id'])?$_POST['user_id'] :''?>"/>  
                         <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Twitter user ID for this author of tweet in numeric form.">
                       <i class="fa fa-info"></i>
                    </button>                       
                    </div>
                    </td>
                </tr><!-- User Numeric ID-->

                <tr><!-- Conversation ID-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-coversation-id">
                          <input type="checkbox" name="review-checkbox[]" value="conversation_id" id="conversation-id" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("conversation_id", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >   
                          <strong>Conversation ID:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-conversation-id">
                        <label label-default="" for="review-filter-conversation-id"></label>
                      <input type="number" class="form-control review-control" name="conversation_id" id="review-filter-conversation-id" placeholder="Enter Numeric Conversation ID" value="<?php echo isset($_POST['conversation_id'])?$_POST['conversation_id'] :''?>"/>     
                         <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Conversation ID for this tweet in numeric form.">
                       <i class="fa fa-info"></i>
                    </button>                       
                    </div>
                    </td>
                </tr><!-- Conversation ID-->

                <tr><!-- Stakeholder-->
                    <td>
                    <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-stakeholder">
                          <input type="checkbox" name="review-checkbox[]" value="stake_holder" id="stakeholder" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("stake_holder", $_POST['review-checkbox'])) echo "checked";}else echo "checked";?> >   
                          <strong>Stakeholder:</strong>
                      </label>
                    </div>   
                    </td>
                    <td>
                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-12 col-md-10 col-lg-8" id="filter-stakeholder">
                        <select class="form-control review-control" name="stake_holder" id="review-filter-stakeholder">
                          <option value="" <?php if($_POST['stake_holder'] == "") echo "selected";?> ></option>
                          <option value="True" <?php if($_POST['stake_holder'] == "True") echo "selected";?> >True</option>
                          <option value="False" <?php if($_POST['stake_holder'] == "False") echo "selected";?> >False</option>
                      </select>
                    </div>
                    </td>
                </tr><!-- Stakeholder-->

                <tr><!-- required text Split-->
                    <td style="border:0px;">
 
               <!--p> <span style="color:Red;">*</span> fields are required.
 </p--> 

                    </td>
                </tr><!-- required text Split-->

            </tbody>


        </table>
        <!--export button-->
        <div class="input-group">

                              <div class="review-form-group form-group col-xs-12 col-sm-12 col-lg-12">
                        <label label-default="" for="review-field-split">
                          <input type="checkbox" name="split-checkbox[]" id="split" value= "split" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){ if (in_array("split", $_POST['split-checkbox'])) echo "checked";}else echo "";?> >     
                          <strong>Split output file:</strong>
                            <button type="button" class="btn btn-default btn-xs review-info-btn" data-placement="top" data-toggle="tooltip" data-placement="top" title="Enter number of records per file. e.g 10000, 25000">
                       <i class="fa fa-info"></i>
                    </button>  
                      </label>
                    </div>  

                    <div class="review-form-group form-inline form-group col-xs-6 col-sm-5 col-md-4 col-lg-4" id="filter-split">
                    <input type="number" class="form-control review-control" name="split" id="review-filter-split" placeholder="Enter value" value="<?php echo isset($_POST['split'])?$_POST['split'] :''?>"/>       
 
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

$('#review-filter-captured-at-to').datetimepicker();
$('#review-filter-captured-at-from').datetimepicker();

$("#review-filter-captured-at-from").on("dp.change",function (e) {
  $('#review-filter-captured-at-to').data("DateTimePicker").setMinDate(e.date);
});
$("#review-filter-captured-at-to").on("dp.change",function (e) {
   $('#review-filter-captured-at-from').data("DateTimePicker").setMaxDate(e.date);
});


$('#review-filter-tweeted-at-to').datetimepicker({
  //pickTime: false
});

$('#review-filter-tweeted-at-from').datetimepicker({
  //pickTime: false
});

$("#review-filter-tweeted-at-from").on("dp.change",function (e) {
  $('#review-filter-tweeted-at-to').data("DateTimePicker").setMinDate(e.date);
});
$("#review-filter-tweeted-at-to").on("dp.change",function (e) {
   $('#review-filter-tweeted-at-from').data("DateTimePicker").setMaxDate(e.date);
});

//show hide surcharge fields depending on selection in passenger eligibility

//check all
function selectAll(){
$("input[name='review-checkbox[]']").each( function () {
        $(this).prop('checked', true);
        var field_id = $(this).attr('id');
         var filters_div = 'filter-'+field_id;
         $("#"+filters_div).removeClass("review-filters-disabled");
         $("#"+filters_div+" :input").attr("disabled", false);
    });
}

function uncheckAll(){
$("input[name='review-checkbox[]']").each( function () {
        $(this).prop('checked', false);
         var field_id = $(this).attr('id');
         var filters_div = 'filter-'+field_id;
         $("#"+filters_div).addClass("review-filters-disabled");
         $("#"+filters_div+" :input").attr("disabled", true);
    });
}

//loop through each checkbox and disable, enable divs
   $("input[name='review-checkbox[]']").each( function () {
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

   $("input[name='review-checkbox[]']").click(function() {

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


   //check for split checkbox status

   $("input[name='split-checkbox[]']").each( function () {
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


        //disable enable split checkbox and input
      $("input[name='split-checkbox[]']").click(function() {
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
<?php if($zipname){
    if($zipname!=-1){
        $message = '<h2>Your exported file is ready.</h2><br/>';
        $message.='<p>Total number of records: <strong>'. $records .'</strong></p>';
//       $message.="<strong>Click <a href='".$zipname."'>here</a> to download.</strong>";
        //$message.="<button id='hidden-btn' href='".$zipname."'></button>";
    }
    else{
        $message = '<h2>There was an error.</h2><br/>';
        $message.='<strong>Please try again.</strong>';
    }
  ?>
<script>
var check = "<?php echo $zipname; ?>";

var some_html = "<?php echo $message; ?>";
var link = "<?php echo $zipname; ?>";
var box = bootbox.alert(some_html);
//box.find(".btn-primary").(attr("href",$("#hidden-btn").attr('href')));
if(check!=1){
    box.find(".btn-primary").remove();
    box.find(".modal-footer").append("<a href='"+link+"' class='btn btn-primary' type='button' id='file-download-btn'>Download</a>");
}
//box.find("#file-download-btn").attr("data-bb-handler","ok");
</script>
  <?php
}?>