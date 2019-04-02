
function validateForm(theForm)
{
	
	if (theForm.name.value == "")
	{
		alert ("You must enter your name");
		theForm.name.focus();
		return false;
	}
	else if (theForm.email.value == "")
	{
		alert ("You must enter your email address");
		theForm.email.focus();
		return false;
	}
	else if (theForm.phone.value == "")
	{
		alert ("Please enter your phone number");
		theForm.phone.focus();
		return false;
	}
	
	else if (!anyBoxesChecked(theForm))
	{
		alert ("Please select your preferred method of contact");
		return false;
	}
	else
	{
		alert ("Your new member request has been submitted!");
		return true;
	}
}

function anyBoxesChecked(theForm)
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