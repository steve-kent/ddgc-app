$(document).ready(function() 
{
    // Toggle the member fields as enabled or readonly depending on the radio selection
    $("input[name='memberRadio']").change(function(){
            $('.memberFields').prop('readonly', $("input[name='memberRadio']:checked").val() == "isMember"? false : true);
            $('#oweShirt').toggleClass("disableClicks", $("input[name='memberRadio']:checked").val() == "isMember"? false : true);
    })
});

function editPlayer()
{
    $("#addPlayer :input").prop("readonly", false);
    $("#memberNumber").prop("readonly", true);    //Never let member number be changed
    $("#isMember").removeClass("disableClicks");
    $('.memberFields').prop('readonly', $("input[name='memberRadio']:checked").val() == "isMember"? false : true);
    $('#oweShirt').toggleClass("disableClicks", $("input[name='memberRadio']:checked").val() == "isMember"? false : true);
    $("#saveChanges").prop("disabled", false);    

}

function validateForm(theForm)
{
    $(theForm.firstName).removeClass("invalid");
    $(theForm.lastName).removeClass("invalid");
    $(theForm.nickName).removeClass("invalid");
    $("label[for='memberRadio']").removeClass("invalid");
    $('#validMemberOrNot').hide();
    $('#validNameOrNick').hide();

    if ((theForm.firstName.value == "" || theForm.lastName.value == "") && theForm.nickName.value == "")
    {
        $(theForm.firstName).addClass("invalid");
        $(theForm.lastName).addClass("invalid");
        $(theForm.nickName).addClass("invalid");
        $('#validNameOrNick').show();
        console.log("should return false");
        return false;
    }

    if(!anyRadiosChecked(theForm))
    {
        $("label[for='memberRadio']").addClass("invalid");
        $('#validMemberOrNot').show();
        return false;
    }
return true;
}

function anyRadiosChecked(theForm)
{
	var checkboxes = document.querySelectorAll('input[type="radio"]');
	for(i = 0; i < checkboxes.length; i++)
	{
		if (checkboxes[i].checked == true)
		{
			return true;
		}
	}
	return false;
}