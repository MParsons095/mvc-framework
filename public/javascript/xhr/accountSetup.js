function xhrSaveAccountMeta(container,data,execFunc)
{
    responseMessages = {
        'success':'Acount Setup Complete! Loading Profile...',
        'error':'An error occurred while processing your account setup. Please refresh and try agian.'
    };

   xhrLoad('xhrCrud/accountMeta/save',container,data,responseMessages,execFunc);
}