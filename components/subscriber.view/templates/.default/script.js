//скрипты компонента
//скрипты
console.log("runs");


function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

$(document).ready(

  function(){
    var request;

    $("#subscribe-form").submit(function(event){
    event.preventDefault();
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);
    var $inputs = $form.find("input");

    var serializedData = $form.serialize();

    $inputs.prop("disabled", true);
    console.log(link);
    console.log(serializedData);

    request = $.ajax({
        url: link,
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        $('#subscibe-placeholder-div').css( "display", "block" );
        $('#subscibe-form-div').css( "display", "none" )
        console.log(response);
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

});

    $('#subscribe-button').click(
      function(){
        email = $('#email-input').val();
        if (validateEmail(email)) {
          console.log(email);
          $('#subscribe-form').submit();
        } else {
          console.log('wrong');
          $('#subscibe-alert-div').css( "display", "block" );
          $('#subscibe-form-div').css( "display", "none" );
          setTimeout(function(){
            $('#subscibe-alert-div').css( "display", "none" );
            $('#subscibe-form-div').css( "display", "block" );
          }, 1000);
        }
      }
    );
  }



);
