
$(document).ready(function() {
 tweets_chart =  new Morris.Area({
        element: 'morris-tmi-chart',
        xkey: 'time',
        ykeys: ['tweets', 'users'],
        labels: ['Tweets', 'Users'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
   //     hoverCallback: function(index, options, content) {
     //     //alert(content);
       // return(content.append('<span>THIS</span>'));
    //}
    });

error_message = $('#morris-tmi-chart-error-message');
tweets_chart_div = $('#morris-tmi-chart');
//add_chart_data();

}); 

function add_chart_data1(){  
      
  //alert('hello1');
 
  var from = $('#chart_datetimepicker_from').val();
  var to = $('#chart_datetimepicker_to').val();
  var frequency = $('#chart_frequency').val();
  
  error_message.css('display','none');
  tweets_chart_div.css('display','none');

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
              error_message.css('display','block');
             //alert('there was an error!' + JSON.stringify(response));
          }
      });

      return false;
}

function reload_chart1(response){

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
        error_message.css('display','none');
    tweets_chart_div.css('display','block');
    
    tweets_chart.setData(t_data);
    tweets_chart.redraw();

     $('#chart_datetimepicker_from').val(response[0].timestamp);
    $('#chart_datetimepicker_to').val(response[(response.length)-1].timestamp);

  }
  else{
      // alert('No data found, try with different input.');
        error_message.css('display','block');
    }
    return false;   
}

function toggleChartMenu(isEnable){
      if(isEnable===true){
              $("#chart_menu").removeClass("input-disabled");
              //disable inputs inside parent div
              //$(chart_menu+" :input").attr("disabled", false);
              $("#chart_menu").find('input, button, select').attr('disabled',false);
          }
          //grey out
          else{
              $("#chart_menu").addClass("input-disabled");
              $("#chart_menu").find('input, button, select').attr('disabled',true);
      }

      return false;
          //$("#"+field_id).attr("disabled", false);
}


chart_loader= '<div id="chart_loader" style="position: absolute; left: 50%; top: 5px;"><img src="img/ajax_loader_gray_32.gif"></img></div>';

//ajax loading dialog
$(document).ajaxSend(function(event, request, settings) {
  $('#morris-tmi-chart-panel').append(chart_loader);
  //$('#ajax_loader').show();
  toggleChartMenu(false); 
});

$(document).ajaxComplete(function(event, request, settings) {
     $('#chart_loader').remove();
 // $('#ajax_loader').hide();
  toggleChartMenu(true);
});