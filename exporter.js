var progresspump ;
var modal;
var bar;
var bar_title;

$('#review-export-form').on('submit', function (e) {
        //alert('form was submitted');
        e.preventDefault();

          $.ajax({
            type: 'POST',
            url: 'exporter.php',
            dataType:'json',
            data: $('#review-export-form').serialize(),
            success: function (response) {
                console.log(response);
              //alert('form was submitted');
              clearInterval(progresspump);
              showFileDownload(response);

            },
            error: function(){
              //alert('EXPORTER: there was an error! ' + JSON.stringify(response));

              clearInterval(progresspump);
            console.log(JSON.stringify(response));
              var response = getDownloadedFileStatus();
              showFileDownload(response);
            
             
            }
          });

    showProgressBar();

});

//file export result message box
function showFileDownload(response){
        var filename=0;
        var records;
        if(response!=null){
            filename = response.file;
            records  = response.records;
        }
        
   
        var message;
        var footer_msg;
            if(filename!=0 && filename.length){
              //fix the file path
                //var paths = filename.split('/');
               // filename = paths[1]+'/'+paths[2];
                var link = filename;

                message = '<div class="progress-modal-message"><h2>Your exported file is ready.</h2><br/>';
                message+='<p>Total number of records: <strong>' + records +'</strong></p></div>';

                footer_msg="<div class='modal-footer'><a href='"+link+"' class='btn btn-primary' type='button' id='file-download-btn' download>Download</a></div>";

            }
            else{
                message = '<div class="progress-modal-message"><h2>There was an error.</h2><br/>';
                message+='<strong>Please try again.</strong></div>';

                footer_msg="<div class='modal-footer'><a class='btn btn-primary' type='button' class='close' data-dismiss='modal'>OK</a></div>";
            }
        //var box = bootbox.alert(message);
            //if(filename!=-1){
                //box.find(".btn-primary").remove();
                //box.find(".modal-footer").append("<a href='"+link+"' class='btn btn-primary' type='button' id='file-download-btn'>Download</a>");
                //box.find(".btn-primary").remove();
            initModal(false);

            modal.find(".modal-body").append(message);
            footer = modal.find(".modal-content");

            //modal.find(".modal-footer").remove();
            footer.append(footer_msg);
       // }

return false;
}


//show progress bar
function showProgressBar(){


    initModal(true);

   modal.modal('show');

  progresspump = setInterval(function(){
    /* query the completion percentage from the server */
    var data=0;
        $.ajax({
            url: 'http-calls/get-session.php',
            dataType:'json',
            async: false,
            success: function (response) {
                data = response.exporter.progress;
                updateProgressBar(progresspump,bar,response);
              //alert('form was submitted');
              //showFileDownload(response);
            },
            error:function(response){
              clearInterval(progresspump);

            }
        });
  }, 100);

//    modal.removeClass("progress-bar");

    return false;

}

//if the ajax request overload, use ajax call to check file status
function getDownloadedFileStatus(){
    var returnData;
        $.ajax({
            url: 'http-calls/get-session.php',
            dataType:'json',
            async: false,
            success: function (response) {
                returnData = response.exporter.exportedFile;
            }
        });

    return returnData;

}

function initModal(isBar){
    modal = $('.js-loading-bar'),
    bar = modal.find('.progress-bar');
    bar_title = modal.find('#progress-bar-title');

    modal.find(".progress-modal-message").remove();
    modal.find(".modal-footer").remove();
    if(isBar==true){
        bar.width(0+'%');
        bar.text(0+'%');
        bar.parent().css('display','block');
        bar_title.css('display','block');
        modal.find('.modal-header').css('display','none');
    }
    else{
        bar.parent().css('display','none');
        modal.find('.modal-header').css('display','block');
        bar_title.css('display','none');
    }

    return false;
}

//update progress value on UI

function updateProgressBar(callback, bar, response){
    value = response.exporter.progress;
    bar.width(value.toFixed(2)+'%');

    if (value>=99) {
        clearInterval(callback);
    }

    bar.text(value.toFixed(2)+'%');
    bar_title.text(response.exporter.progressMessage);

    return false;
}

//init modal with progress bar
/*$(document).ready(function() {
 this.$('.js-loading-bar').modal({
  backdrop: 'static',
  show: false
    }).on('shown.bs.modal', function( event ) {

   var $bar = $(event.target).find('.progress-bar'),
       _wait = function() {       
            setTimeout(function() {
              if ( $bar.is(':visible')) { 
                   $bar.addClass('animate');
               } else {
                  console.log('not ready'); 
                  _wait();
               }
            }, 0);       
       };
   
   _wait();
   
    });
}); */


//export form dynamic keyword fields
$(document).ready(function() {
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
            $(inputsWrapper).append('<div class="form-group-keyword"><select class="form-control review-control" name="textKeyword_condition_' + fieldCount+'"id="textKeyword_condition_'+fieldCount+'"><option value="~*">contains</option><option value="!~*">doesn\'t contain</option><option value="=">full match</option></select><input type="text" class="form-control review-control" name="text_'+ fieldCount +'"id="text_'+fieldCount+'" placeholder="enter keyword"/> <a href="#" class="removeclass5">&times;</a></div>');
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
  });