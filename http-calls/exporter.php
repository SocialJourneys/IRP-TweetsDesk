<?php include('../core/init.core.php');?>
<?php
header("Content-Type: application/json");
$_SESSION['progressBarValue'] =0;

//prepare the SQL query from form
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
          
        //handling first comma
           if($fields) 
                $fields = $fields.', '.$checkbox;
           else
              $fields = $checkbox;
          

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

		$_SESSION['progressBarValue'] =0;

        $returnArray = dbExport($query,intval($split),'../db_exports');               
        
		if(!empty($returnArray)){
			http_response_code(200);
			echo json_encode($returnArray);
		}
		else
			echo json_encode(array("errors"=>"Export error"));

  } //if post
?>