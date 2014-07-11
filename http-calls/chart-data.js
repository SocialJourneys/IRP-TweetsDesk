  var chart =  new Morris.Area({
        element: 'morris-tmi-chart',
        xkey: 'time',
        ykeys: ['tweets', 'users'],
        labels: ['Tweets', 'Users'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

add_chart_data();

function add_chart_data(){  
      
  //alert('hello1');
 
  var from = $('#chart_datetimepicker_from').val();
  var to = $('#chart_datetimepicker_to').val();
  var frequency = $('#chart_frequency').val();

      $.ajax({
        type:"GET",
        url:"http-calls/chart-data.php",
        dataType:"json",
        contentType:"application/json",
        data:"from="+from+"&to="+to+"&frequency="+frequency,
        
        success:function(response){
        reload_chart(response);
        //alert(response[0].timestamp);
        console.log(JSON.stringify(response));
       // alert('hello2');
        },
          error: function(response){
          //TODO show error on the UI
              console.log(JSON.stringify(response));
             //alert('there was an error!' + JSON.stringify(response));
          }
      });

      return false;
}

function reload_chart(response){

    //alert('inside reload chart: '+response.length);

    var t_data = [];

    for(var i=0; i<response.length;i++){
        var timestamp = (response[i].timestamp);
        var tweets_count = parseInt(response[i].tweets_count);
        var authors_count = parseInt(response[i].authors_count);
        
        t_data[i]={time:timestamp,
                    tweets:tweets_count,
                    users:authors_count,
                };
       // console.log(timestamp);
       
    }
  
  if(t_data.length>0){
    chart.setData(t_data);
    chart.redraw();
  }
  else
   alert('No data found, try with different input.');
}

/*Morris.Area({
        element: 'morris-tmi-chart',
        data: [{
            time: '2014-06-10 12:00',
            tweets: 100,
            users: 12,
        }, {
            time: '2014-06-10 1:00',
            tweets: 200,
            users: 7,
        }, {
            time: '2014-06-10 2:00',
            tweets: 10,
            users: 3,
        }, {
            time: '2014-06-10 3:00',
            tweets: 15,
            users: 4,
        }, {
            time: '2014-06-10 4:00',
            tweets: 5,
            users: 2,
        }, {
            time: '2014-06-10 5:00',
            tweets: 20,
            users: 5,
        }, {
            time: '2014-06-10 6:00',
            tweets: 30,
            users: 7,
        }, {
            time: '2014-06-10 7:00',
            tweets: 100,
            users: 40,
        }, {
            time: '2014-06-10 8:00',
            tweets: 145,
            users: 70,
        }, {
            time: '2014-06-10 9:00',
            tweets: 350,
            users: 100,
        },  {
            time: '2014-06-10 10:00',
            tweets: 100,
            users: 12,
        }, {
            time: '2014-06-10 11:00',
            tweets: 200,
            users: 7,
        }, {
            time: '2014-06-10 12:00',
            tweets: 10,
            users: 3,
        }, {
            time: '2014-06-10 13:00',
            tweets: 15,
            users: 4,
        }, {
            time: '2014-06-10 14:00',
            tweets: 5,
            users: 2,
        }, {
            time: '2014-06-10 15:00',
            tweets: 20,
            users: 5,
        }, {
            time: '2014-06-10 16:00',
            tweets: 30,
            users: 7,
        }, {
            time: '2014-06-10 17:00',
            tweets: 100,
            users: 40,
        }, {
            time: '2014-06-10 18:00',
            tweets: 145,
            users: 70,
        }, {
            time: '2014-06-10 19:00',
            tweets: 350,
            users: 100,
        },
        {
            time: '2014-06-10 20:00',
            tweets: 20,
            users: 5,
        }, {
            time: '2014-06-10 21:00',
            tweets: 30,
            users: 7,
        }, {
            time: '2014-06-10 22:00',
            tweets: 10,
            users: 5,
        }, {
            time: '2014-06-10 23:00',
            tweets: 33,
            users: 6,
        }, {
            time: '2014-06-10 24:00',
            tweets: 28,
            users: 6,}
        ],
        xkey: 'time',
        ykeys: ['tweets', 'users'],
        labels: ['Tweets', 'Users'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });*/
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


