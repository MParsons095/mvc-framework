$('input[name="loginSubmit"]').click(function(){
    resetForm();

    form = $('form');
    email = $('input[name="loginEmail"]').val();
    password = $('input[name="loginPassword"]').val();
    submitButton = $('input[name="loginSubmit"]').val();

    if(!validate(email,'email',true) || !validate(password,'alphaNumeric',true))
    {
        writeMessage($('form'),'danger','Invalid Login Credentials');
        return false;
    }


    $.ajax({
        url: getRoot() + 'account/xhrLogin',
        type: 'POST',
        dataType: 'json',
        data: {'email':email,'password':password},
        beforeSend: function(sending) {
                setLoader(form,true);
        },
        success: function(response) {
            if(response.state)
            {
                form.html('<p>You have successfully logged in! You will be redirected in <b><span class="timer">3</span></b></p>');
                var url = getRoot() + 'account/profile';
                setLoader($('.modal-body'),true);
                setRedirectCountdown(2,url,$('.timer'));
            }
            else
            {
               listMessages(form,'danger','error',response);
            }

            console.log(response);
        },
        error: function(xhr) {
            writeMessage(form,'danger','Request could not be completed. Please refresh and try again.');
            console.log(xhr);
        },
        complete: function() {
            setLoader(form,false);
        }
    });
	
    return false;
});


function validateEmail()
{

}