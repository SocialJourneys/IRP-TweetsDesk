
$(document).ready(function() {
  hashtag_chart_data = [];

 hashtag_chart =  new Morris.Area({
        element: 'morris-hashtag-chart',
        xkey: 'time',
        ykeys: ['tweets'],
        labels: ['Tweets'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true,
        hoverCallback: function(index, options, content) {
        return hashtag_chart_data[index].hover;
        //this.xlabelAngle = 30;
        //$("#row-content").html("<div>" + "Year: " + options.data[index].y + "<br />" + options.labels[0] + ": " + options.data[index].a + "<br />" + options.labels[1] + ": " + options.data[index].b + "</div>");
    }
    });

error_message = $('#morris-hashtag-chart-error-message');
error_message.css('display','none');
hashtag_chart_div = $('#morris-hashtag-chart');

add_hashtag_chart_data('true');
hashtag_chart_div.css('display','none');

over_table=$("#dataTables-admin-overview").dataTable();

overview_chart_loader= '<div id="overview_chart_loader" style="position: absolute; left: 50%; top: 5px;"><img src="img/ajax_loader_gray_32.gif"></img></div>';
$('#admin-overview-tabel-panel').append(overview_chart_loader);

}); 




//init chart

function add_hashtag_chart_data(firstCall){  
      
  //alert('hello1');
 
  var from = $('#hashtag_chart_datetimepicker_from').val();
  var to = $('#hashtag_chart_datetimepicker_to').val();
  var frequency = $('#hashtag_chart_frequency').val();

  //error_message.css('display','none');
  //tweets_chart_div.css('display','none');
      $.ajax({
        type:"GET",
        url:"http-calls/admin.php",
        dataType:"json",
        contentType:"application/json",
        data:"from="+from+"&to="+to+"&frequency="+frequency+"&firstCall="+firstCall,
        success:function(response){
        reload_hashtag_chart(response,firstCall);
        //alert(response[0].timestamp);
        console.log(JSON.stringify(response));
       // alert('hello2');
        },
          error: function(response){
          //TODO show error on the UI
              console.log(JSON.stringify(response));
              error_message.css('display','block');
              hashtag_chart_div.css('display','none');
             //alert('there was an error!' + JSON.stringify(response));
          }
      });

      return false;
}

function update_system_overview(firstCall,total,per_sec){
//update overview values
    if(firstCall=='true'){

      //alert(total);
      over_table.fnUpdate(total,0,1); //
      over_table.fnUpdate(per_sec,1,1);//

    }

    return false;
}

function reload_hashtag_chart(response,firstCall){
  hashtag_chart_data=[];
    //alert('inside reload chart: '+response.length);
    for(var i=0; i<response.length;i++){
        var timestamp = (response[i].timestamp);
        var tweets_count = response[i].tweets;
        var hoverData = response[i].hover;
        
        hashtag_chart_data[i]={time:timestamp,
                    hover:hoverData,
                    tweets:tweets_count,
               };
       
    }
         // console.log(hashtag_chart_data);

  if(hashtag_chart_data.length){

      update_system_overview(firstCall,response[0].total_tweets,response[0].tweets_per_second);

    hashtag_chart_div.css('display','block');
            error_message.css('display','none');

     hashtag_chart.setData(hashtag_chart_data);
    hashtag_chart.redraw();

    $('#hashtag_chart_datetimepicker_from').val(response[0].timestamp);
    $('#hashtag_chart_datetimepicker_to').val(response[(response.length)-1].timestamp);


  }
  else{
       //alert('No data found, try with different input.');
        error_message.css('display','block');
        hashtag_chart_div.css('display','none');
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
  $('#morris-hashtag-chart-panel').append(chart_loader);
  //$('#ajax_loader').show();
  toggleChartMenu(false); 
});

$(document).ajaxComplete(function(event, request, settings) {
     $('#chart_loader').remove();
     $('#overview_chart_loader').remove();
 // $('#ajax_loader').hide();
  toggleChartMenu(true);
});