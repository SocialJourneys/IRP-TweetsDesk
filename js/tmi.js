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