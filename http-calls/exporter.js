$('#review-export-form').on('submit', function (e) {

        //alert('form was submitted');
        e.preventDefault();

          $.ajax({
            type: 'POST',
            url: 'http-calls/exporter.php',
            dataType:'json',
            data: $('#review-export-form').serialize(),
            success: function (response) {
                console.log(response);
              //alert('form was submitted');
              showFileDownload(response);
            },
            error: function(response){
            console.log(JSON.stringify(response));
             alert('there was an error!' + JSON.stringify(response));
            }
          });
});

//file export result message box
function showFileDownload(response){
        var filename = response.file;

        if(filename!=-1){
            var paths = filename.split("/");
            filename = paths[1]+'/'+paths[2];
        }

        var records = response.records;
        var message;
            if(filename!=-1){
                message = '<h2>Your exported file is ready.</h2><br/>';
                message+='<p>Total number of records: <strong>' + records +'</strong></p>';
            }
            else{
                message = '<h2>There was an error.</h2><br/>';
                message+='<strong>Please try again.</strong>';
            }
        var link = filename;
        var box = bootbox.alert(message);
            if(filename!=-1){
                box.find(".btn-primary").remove();
                box.find(".modal-footer").append("<a href='"+link+"' class='btn btn-primary' type='button' id='file-download-btn'>Download</a>");
            }

return false;
}


    //dynamic keyword fields
    var fieldCount = 1; //to keep track of text box added

    $("#add-keyword").click(function (e)  //on add input button click
    {
        //alert('hello');
        var maxInputs      = 20; //maximum input boxes allowed
        var inputsWrapper  = $("form .multiple-keywords"); //Input boxes wrapper ID
       // var addButton       = $("#add-keyword"); //Add button ID

        var zk = inputsWrapper.length; //initlal text box count
        //alert(zk);

        if(zk <= maxInputs) //max input box allowed
        {
            fieldCount++; //text box added increment
            //add input box
            $(inputsWrapper).append('<div class="form-group-keyword"><select class="form-control review-control" name="textKeyword_condition_' + fieldCount+'"id="textKeyword_condition_'+fieldCount+'"><option value="LIKE">contains</option><option value="=">exact match</option></select><input type="text" class="form-control review-control" name="text_'+ fieldCount +'"id="text_'+fieldCount+'" placeholder="enter keyword"/> <a href="#" class="removeclass5">&times;</a></div>');
            zk++; //text box increment
        }

        return false;
    });

    $("body").on("click",".removeclass5", function(e){ 
        //alert('trying to remove');
        var inputsWrapper  = $("form .multiple-keywords"); //Input boxes wrapper ID
        //user click on remove text
        var zk = inputsWrapper.length; //initlal text box count
        if( zk >= 1 ) {
                $(this).parent('div.form-group-keyword').remove(); //remove text box
                zk--; //decrement textbox
        }
        return false;
    });

//ajax loading dialog
$(document).ajaxSend(function(event, request, settings) {
  //$('#export-progress-bar').show();
  $('#myLargeModalLabel').modal('toggle');
});

$(document).ajaxComplete(function(event, request, settings) {
  //$('#export-progress-bar').hide();
  $('#myLargeModalLabel').modal('toggle');
});