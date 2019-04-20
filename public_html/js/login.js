function validateForm(theForm)
{
    $(theForm.userName).removeClass("invalid");
    $(theForm.password).removeClass("invalid");    

    if (theForm.userName.value == "")
    {
        $(theForm.userName).addClass("invalid");
        $('#validNameUser').show();
        return false;
    }

    if (theForm.password.value == "")
    {
        $(theForm.password).addClass("invalid");
        $('#validNameUser').show();
        return false;
    }


return true;
}
