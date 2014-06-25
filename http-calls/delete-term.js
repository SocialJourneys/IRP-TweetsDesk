
function deleteTerm(term_id, term_name){
  

      $.ajax({
        type:"GET",
        url:"http-calls/delete-term.php",
        //dataType:"json",
        data:"term_id="+term_id,

        success:function(response){

        bootbox.alert("Successfully Deleted: <strong>"+term_name+"</strong>");
        //window.location.replace("http://stackoverflow.com");
        //TODO append in the UI
        //$('#confirm-delete').data('modal', null);
                   
        console.log(JSON.stringify(response));
        // window.location.href = window.location.href + "?delete=YES";
        
        //remove table row
        $('#dataTables-tracklist').dataTable().fnDeleteRow($('#dataTables-tracklist-'+term_id));

        },
          error: function(response){
          //TODO show error on the UI
           console.log(JSON.stringify(response));
               alert('there was an error!' + JSON.stringify(response));

          }
      });

        $('#confirm-delete').modal('toggle');

      return false;
}

/*function deleteTerm1(term_id, term_name){  

    // get txn id from current table row
    //var id = $(this).data('id');
   // alert(term_name);
    var heading = 'Confirmation';
    var question = 'Are you sure you want to delete ' + term_name + '?';
    var cancelButtonTxt = 'Cancel';
    var okButtonTxt = 'Confirm';

    var callback = function() {
        doDelete(term_id);
      //alert('delete confirmed ' + term_name);
    };

    confirmFunc(heading, question, cancelButtonTxt, okButtonTxt, callback);

}*/

// ---------------------------------------------------------- Generic Confirm  

  /*function confirmFunc(heading, question, cancelButtonTxt, okButtonTxt, callback) {

    var confirmModal = 
      $('<div class="modal hide fade">' +    
          '<div class="modal-header">' +
            '<a class="close" data-dismiss="modal" >&times;</a>' +
            '<h3>' + heading +'</h3>' +
          '</div>' +

          '<div class="modal-body">' +
            '<p>' + question + '</p>' +
          '</div>' +

          '<div class="modal-footer">' +
            '<a href="#" class="btn" data-dismiss="modal">' + 
              cancelButtonTxt + 
            '</a>' +
            '<a href="#" id="okButton" class="btn btn-primary">' + 
              okButtonTxt + 
            '</a>' +
          '</div>' +
        '</div>');

     
    confirmModal.find('#okButton').click(function(event) {
      callback();
      confirmModal.modal('hide');
    });

    $(confirmModal).appendTo('body');
    confirmModal.modal('show');     
  };*/

//ajax loading dialog
$(document).ajaxSend(function(event, request, settings) {
  $('#ajax_loader').show();
});

$(document).ajaxComplete(function(event, request, settings) {
  $('#ajax_loader').hide();
});