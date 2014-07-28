<?php include('core/init.core.php');?>
<?php
/*$url = APIURL.'/tracklist';
$headers = array('Content-Type: application/json',"Authorization: ".$_SESSION['account']['apiKey']);
//$headers = array('Content-Type: application/json');
//REST response:
$response =  rest_get($url,$headers);
$dataArray = json_decode($response);

 //Get the status of the user (active/innactive):
$status = $dataArray->{'statusCode'};

//Check if the session has expired
if($status && $status!=201){
    $errors[] = $dataArray->{'errors'}[0];
    $errors[] = $dataArray->{'moreInfo'};

    header("Location: logout.php");
    die();  
}*/

//print_r($response);
//die();

$dataArray = db_fetch('SELECT * FROM track_list');

//$dataArray = $dataArray->{'trackLists'};

?>
<?php include('header.php');?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tracklist</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

<ol class="breadcrumb">
  <li class="active">Tracklist</li>
</ol>

<?php if($_SESSION['account']['userRole']=='Admin'||$_SESSION['account']['userRole']=='Super Admin'){?>
<div class="col-lg-9">
    <div class="panel panel-info" >
        <div class="panel-heading">
            <div class="panel-title">Add Track Item</div>
        </div>     

        <div style="padding-top:30px" class="panel-body" >
            <form id="add-word-form" class="form-horizontal" role="form">
                <div class="row">
                  <div class="col-md-6 col-lg-9">
                    <div class="input-group">
                      <span class="input-group-addon" id="dropdown-symbol"> </span>
                      <input type="text" class="form-control" id="add-term-input">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" id="dropdown-title" value='0'>Select Type <span class="caret"></span></button>
                        <ul class="dropdown-menu pull-right" id="dropdown-term-type">
                          <li data-type='hashtag'><a>Hashtag</a></li>
                          <li data-type='handle'><a>Handle</a></li>
                          <li data-type='search-term'><a>Search Term</a></li>
                        </ul>
                      </div><!-- /btn-group -->
                    </div><!-- /input-group -->
                 </div><!-- /.col-lg-6 -->
                 </div><!-- /.row -->
            <br/>
             <div class="well">
                <p>Write the term and select type. </p>
                 <p>You can also write comma separated terms to add multiple items. e.g Aberdeen, WaitingForBus, Office.</p>
             </div>
            <div style="margin-top:10px" class="form-group">
             <!-- Button -->
                <div class="col-sm-12 controls">
                     <a id="btn-add-term" class="btn btn-primary pull-right" onClick="addTerm(<?php echo "'".$_SESSION['account']['userRole']."'";?>)">Add</a>
                </div>
            </div>
            </form>  
</div>
</div>
</div>
<?php
}
?>
<div class="row" id="term-list">
    <div class="col-lg-10">
        <div class="panel panel-info">
            <div class="panel-heading">
                Current Track Items
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-tracklist">
                        <thead>
                            <tr>
                                <th>Term</th>
                                <th>Type</th>
                                <th>    </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //foreach ($dataArray as $key => $value) {
                                while($row = pg_fetch_array($dataArray)){
                                //$name = $value->{'name'};
                                //$id = $value->{'id'};
                                //$type = $value->{'type'};
                                $name = $row['name'];
                                $id = $row['id'];
                                $type = $row['type'];
                                    
                                echo '<tr class="gradeA" id="dataTables-tracklist-'.$id.'">';
                                echo '<td class="center"><a href="tracklist-details.php?term_name='.$name .'&term_type='.$type.'">'.$name.'</a></td>';
                                echo '<td class="center">'.$type.'</td>';
 //                               echo "<td class=\"center\"><a href=\"#\" class=\"btn btn-danger btn-sm active\" role=\"button\" onClick=\"deleteTerm($id,'$name')\">Delete</a></td>";
                                echo "<td class=\"center\">";
                                    if($_SESSION['account']['userRole']=='Admin'||$_SESSION['account']['userRole']=='Super Admin')
                                        echo "<a data-href=\"http-calls/delete-term.php\" onClick='deleteBtnClicked(this);'  class=\"btn btn-danger btn-sm active\" role=\"button\" id=\"#delete-btn\" data-id=$id data-type=\"$type\" data-name=\"$name\">Delete</a>";
                                    echo"</td>";
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
</div>
<?php include('footer.php');?>
<script type="text/javascript" src="http-calls/delete-term.js"> </script>
<script type="text/javascript" src="http-calls/add-term.js"> </script>

<!-- Data table init -->
<script>

$('#dataTables-tracklist').dataTable({
            "oLanguage": {
            "sInfo": 'Showing _END_ Sources.',
            "sEmptyTable": "No tracklist items found.",
        }
});


<!-- changing drop down title -->
$('.dropdown-toggle').dropdown();
$('#dropdown-term-type li').on('click',function(){
    
    var type = $(this).data('type');
    //var name = $(this).val();
    //var type = $(this).find('a').text();
    var symbol = '@';

    if (type==='hashtag')
        symbol = '#';
    if (type ==='search-term')
        symbol=' ';


     $('#dropdown-title').text($(this).find('a').text());
    $('#dropdown-title').append(' '+"<span class='caret'></span>");
    $('#dropdown-symbol').text(symbol);
    $('#dropdown-title').val(type); //set hidden value
    //alert($(this).val());
});

//show delete confirmation
/*$('#confirm-delete').on('show.bs.modal', function(e) {
    var term_id = $(e.relatedTarget).data('id');
    var term_type = $(e.relatedTarget).data('type');
    $(this).find('.danger').attr('href', $(e.relatedTarget).data('href')+'?term_id='+term_id);
    $('.debug-record').html('Delete '+term_type+': <strong>' + $(e.relatedTarget).data('name') + '</strong>');
});*/


function deleteBtnClicked(event){
    var term_id = $(event).data('id');
    var term_type = $(event).data('type');
    var term_name = $(event).data('name');

bootbox.dialog({
  message: 'Are you sure want to delete the '+ term_type +':<strong>'+ term_name+'</strong>',
  title: "Confirmation",
  buttons: {
    cancel: {
      label: "Cancel",
      className: "btn-primary",
      callback: function() {
        //do nothing
      }
    },
    danger: {
      label: "Delete!",
      className: "btn-danger",
      callback: function() {
        deleteTerm(term_id,term_name);
        //Example.show("uh oh, look out!");
      }
    }
  }
});
}
</script>