
$(document).ready(function() {
  admin_chart_data = [];

 admin_chart =  new Morris.Area({
        element: 'morris-admin-chart',
        xkey: 'time',
        ykeys: ['tweets','tps'],
        labels: ['Tweets','Tweets p/s'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
        /*hoverCallback: function(index, options, content) {
        return admin_chart_data[index].hover;*/
        //this.xlabelAngle = 30;
        //$("#row-content").html("<div>" + "Year: " + options.data[index].y + "<br />" + options.labels[0] + ": " + options.data[index].a + "<br />" + options.labels[1] + ": " + options.data[index].b + "</div>");
    //}
    });

error_message = $('#morris-admin-chart-error-message');
error_message.css('display','none');
admin_chart_div = $('#morris-admin-chart');


admin_chart_div.css('display','none');

over_table=$("#dataTables-admin-overview").dataTable();

overview_chart_loader= '<div id="overview_chart_loader" style="position: absolute; left: 50%; top: 5px;"><img src="img/ajax_loader_gray_32.gif"></img></div>';
$('#admin-overview-tabel-panel').append(overview_chart_loader);

chart_loader= '<div id="admin_chart_loader" style="position: absolute; left: 50%; top: 5px;"><img src="img/ajax_loader_gray_32.gif"></img></div>';
$('#morris-admin-chart-panel').append(chart_loader);
toggleChartMenu(false); 


//update_system_overview();

//add_admin_chart_data('true');

}); 




//init chart

function add_admin_chart_data(firstCall){  
      
  //alert('hello1');
 
  var from = $('#admin_chart_datetimepicker_from').val();
  var to = $('#admin_chart_datetimepicker_to').val();
  var frequency = $('#admin_chart_frequency').val();

  //error_message.css('display','none');
  //tweets_chart_div.css('display','none');
      $.ajax({
        type:"GET",
        url:"http-calls/admin1.php",
        dataType:"json",
        contentType:"application/json",
        data:"from="+from+"&to="+to+"&frequency="+frequency+"&call=chart"+"&firstCall="+firstCall,
        func:"chart",
        success:function(response){
        reload_admin_chart(response,firstCall);
        //alert(response[0].timestamp);
        //console.log(JSON.stringify(response));
       // alert('hello2');
        },
          error: function(response){
          //TODO show error on the UI
              //console.log(JSON.stringify(response));
              error_message.css('display','block');
              admin_chart_div.css('display','none');
             //alert('there was an error!' + JSON.stringify(response));
          },
          complete: function(){
            toggleChartMenu(true);
          }
      });

      return false;
}

function update_system_overview(){

      $.ajax({
        type:"GET",
        url:"http-calls/admin1.php",
        dataType:"json",
        contentType:"application/json",
        data:"call=overview",
        func:'overview',
        success:function(response){
              console.log(JSON.stringify(response));

          var tps = response.tweets_per_second;
          var total = response.total_tweets;

          over_table.fnUpdate(total,0,1); //
          over_table.fnUpdate(tps,1,1);//
       
        },
          error: function(response){
              console.log(JSON.stringify(response));
          },
          complete:function(){
                 $('#overview_chart_loader').remove();
          }
      });
    return false;
}

function reload_admin_chart(response,firstCall){
  admin_chart_data=[];
    //alert('inside reload chart: '+response.length);
    for(var i=0; i<response.length;i++){
        var timestamp = (response[i].timestamp);
        var tweets_count = response[i].tweets;
        var tps = response[i].tweets_per_second;
        //var hoverData = response[i].hover;
        
        admin_chart_data[i]={time:timestamp,
                    tweets:tweets_count,
                    tps:tps,
               };
       
    }
         // console.log(admin_chart_data);

  if(admin_chart_data.length){

    admin_chart_div.css('display','block');
    error_message.css('display','none');

    admin_chart.setData(admin_chart_data);
    admin_chart.redraw();

    $('#admin_chart_datetimepicker_from').val(response[0].timestamp);
    $('#admin_chart_datetimepicker_to').val(response[(response.length)-1].timestamp);


  }
  else{
       //alert('No data found, try with different input.');
        error_message.css('display','block');
        admin_chart_div.css('display','none');
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



//ajax loading dialog
$(document).ajaxSend(function(event, request, settings) {
    //$('#ajax_loader').show();
});

$(document).ajaxComplete(function(event, request, settings) {
      if (settings.func === 'chart')  
        $('#admin_chart_loader').remove();
      
    // $('#ajax_loader').hide();
});