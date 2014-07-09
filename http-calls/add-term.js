function addTerm(){  

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
        var tracklistArr = response.trackLists; //array
        var values='';
       // alert(tracklistArr);
        for(var i = 0; i < tracklistArr.length; i++) {
    		//console.log(response.trackLists[i].name);
    		if(values.length)
    			values=values+','+tracklistArr[i].name;
	    	else
	    		values=tracklistArr[i].name;

    		
    		addrow(tracklistArr[i]);
		}

        //alert (response.photos[0]);
		//	console.log(JSON.stringify(response));
        //bootbox.alert("Successfully Added: " + response.name);

			bootbox.alert("Successfully Added: </strong>" + values +"</strong>");

        //TODO append in the UI
        
        },
          error: function(response){
          //TODO show error on the UI
			console.log(JSON.stringify(response));
             alert('there was an error!' + JSON.stringify(response));

          }
      });

      return false;
}

//add newly added data in table
function addrow(response) {

    var row = $('#dataTables-tracklist').dataTable().fnAddData( [
        '<a href="tracklist-details.php?term_name='+response.name+'&term_type='+response.type+'">'+response.name+'</a>',
        response.type,
        '<a data-href="http-calls/delete-term.php" class="btn btn-danger btn-sm active" role="button" onClick="deleteBtnClicked(this);" id="delete-btn" data-id='+response.id+' data-type='+response.type+' data-name='+response.name+'>Delete</a>'] );
  //  '<a href="#" class="btn btn-danger btn-sm active" role="button" data-toggle="modal" data-target="#confirm-delete" data-id='+response.id+' data-name='+response.name+'>Delete</a>'] );


//set tr id	
	var theNode = $('#dataTables-tracklist').dataTable().fnSettings().aoData[row[0]].nTr;
	theNode.setAttribute('id','dataTables-tracklist-' + response.id);
}


