$('input[name="login"]').click(function(){
    resetForm();

    form = $('form');
    email = $('input[name="email"]').val();
    password = $('input[name="password"]').val();
    submitButton = $('input[name="login"]').val();

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
            if(response.status)
            {
                form.html('<p>You have successfully logged in! You will be redirected in <b><span class="timer">3</span></b></p>');
                var url = getRoot();
                setRedirectCountdown(2,url,$('.timer'));
            }
            else
            {
                alert(1);
                console.log(response);
                writeMessage(form,'danger','Failed to Login. Check your login Credentials.');
               /// listMessages(form,'danger',{'12345'});
            }
        },
        error: function(xhr) {
            writeMessage(form,'danger','Request could not be completed. Please refresh and try again.');
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