  var tweets_chart =  new Morris.Area({
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
        //console.log(JSON.stringify(response));
       // alert('hello2');
        },
          error: function(response){
          //TODO show error on the UI
             // console.log(JSON.stringify(response));
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
    tweets_chart.setData(t_data);
    tweets_chart.redraw();
  }
  else
   alert('No data found, try with different input.');

    return false;   
}

//ajax loading dialog
$(document).ajaxSend(function(event, request, settings) {
  $('#ajax_loader').show();
});

$(document).ajaxComplete(function(event, request, settings) {
  $('#ajax_loader').hide();
});