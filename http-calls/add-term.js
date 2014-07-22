/*$(document).ready(function() {
  $("#btn-add-term").click(function(){
           //addTerm("#testDialog");
               alert($(this).attr('data-user'));
        });
}); */

function addTerm(userRole){  

	var term_name = $('#add-term-input').val();
	var term_type = $('#dropdown-title').val();
	
	if(!term_name || term_type==0)
		return false;
	//alert(term_type);
	//alert(term_type);

	if(term_type==1)
		term_type='hashtag';
	if(term_type==2)
		term_type='handle';
	if(term_type==3)
		term_type='search-term';
	
	//alert(type);
	//alert('here');
      $.ajax({
        type:"GET",
        url:"http-calls/add-term.php",
        dataType:"json",
        contentType:"application/json",
        data:"term_name="+term_name+"&term_type="+term_type,

        success:function(response){
        if(response.statusCode==400)
            showError(response.moreInfo);
            //showError('')
        else if(response.tracklistArr !=undefined || response.existingTrackList!=undefined) {

        var tracklistArr = response.trackLists; //array
        var values='';
        var existingTracklistArr = response.existingTrackList; //array
        var existingValues='';

       // alert(tracklistArr);
          for(var i = 0; i < tracklistArr.length; i++) {
      		//console.log(response.trackLists[i].name);
      		if(values.length)
      			values=values+','+tracklistArr[i].name;
  	    	else
  	    		values=tracklistArr[i].name;

      		
      		addrow(tracklistArr[i],userRole);

         }

          for(var i = 0; i < existingTracklistArr.length; i++) {
          //console.log(response.trackLists[i].name);
          if(existingValues.length)
            existingValues=existingValues+','+existingTracklistArr[i].name;
          else
            existingValues=existingTracklistArr[i].name;
          }

        message_added='';
        message_existing='';

      if(tracklistArr.length)
        message_added = "Successfully Added: <strong>" + values +"</strong><br/>";
      if(existingTracklistArr.length)
        message_existing = "Unable to add, terms already existed : <strong>" + existingValues +"</strong>";
  
        bootbox.alert(message_added+message_existing);

	 	   }

        //alert (response.photos[0]);
		//	console.log(JSON.stringify(response));
        //bootbox.alert("Successfully Added: " + response.name);

        }, //success


          error: function(response){
          //TODO show error on the UI
			console.log(JSON.stringify(response));
             alert('there was an error!' + JSON.stringify(response));

          },//error

          complete: function(){
              $('#ajax_loader').hide();
          }
      });

      return false;
}

function showError(message){
      bootbox.alert(message);

}
//add newly added data in table
function addrow(response,userRole) {

  var deleteBtnRow='';  
    if(userRole==='Admin' || userRole==='Super Admin')
      deleteBtnRow = '<a data-href="http-calls/delete-term.php" class="btn btn-danger btn-sm active" role="button" onClick="deleteBtnClicked(this);" id="delete-btn" data-id='+response.id+' data-type='+response.type+' data-name='+response.name+'>Delete</a>';
    
  var row = $('#dataTables-tracklist').dataTable().fnAddData( [
        '<a href="tracklist-details.php?term_name='+response.name+'&term_type='+response.type+'">'+response.name+'</a>',
        response.type,
        deleteBtnRow] );
  //  '<a href="#" class="btn btn-danger btn-sm active" role="button" data-toggle="modal" data-target="#confirm-delete" data-id='+response.id+' data-name='+response.name+'>Delete</a>'] );


//set tr id	
	var theNode = $('#dataTables-tracklist').dataTable().fnSettings().aoData[row[0]].nTr;
	theNode.setAttribute('id','dataTables-tracklist-' + response.id);
}