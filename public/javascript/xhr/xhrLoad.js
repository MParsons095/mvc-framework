function xhrLoad(location,container,data,responseMessages,funcCallback)
{
    var responseState = false;

    if(funcCallback == null)
    {
        funcCallback = {};
    }

    $.ajax({
        url: getRoot() + location + '/?' + new Date().getTime(),
        type: 'POST',
        dataType: 'json',
        data: data,
        beforeSend: function(sending) {
                setLoader(container,true);
        },
        success: function(xhr) {
            responseState = xhr.state;

            if(xhr.state)
            {
                if(responseMessages['success'] != 'undefined' && responseMessages['success'] != null)
                {
                    /**
                     *  Only display success messages if responseMessages['success'] has a value that is not false
                     */
                    if(responseMessages['success'] != false)
                    {
                        writeMessage(container,'success',responseMessages['success']);
                    }
                }
                
                if(funcCallback['success'] != null && funcCallback['success'] != 'undefined')
                {
                    //console.log(funcCallback['success'](xhr));
                   funcCallback['success'](xhr);
                }
                
            }
            else
            {
                if(xhr.response != 'undefined' && xhr.response != null)
                {
                    listMessages(container,'danger',xhr.response);
                }
                else if(responseMessages['error'] != 'undefined' && responseMessages['error'] != null)
                {
                    writeMessage(container,'error',responseMessages['error']);
                }
                else
                {
                    writeMessage(form,'danger','Request could not be completed. Please refresh and try again.');
                }

                if(funcCallback['successError'] != null && funcCallback['successError'] != 'undefined')
                {
                    funcCallback['successError'](xhr);
                }
                
            }
            console.log('XHR SUCCESS:');
            console.log(xhr);
        },
        error: function(xhr) {
           writeMessage(container,'danger','Request could not be completed. Please refresh and try again.');

            if(funcCallback['error'] != null && funcCallback['error'] != 'undefined')
            {
                funcCallback['error'](xhr);
            }
            console.log('XHR ERROR:');
            console.log(xhr);
        },
        complete: function(xhr) {
            setLoader(container,false);

            if(funcCallback['complete'] != null && funcCallback['complete'] != 'undefined')
            {
                funcCallback['complete'](xhr);
            }
            return responseState;
            console.log('------------------------------- complete');
        }
    });
}