function updateNetScore()
{
    let raw = $("#rawScore").val();
    let handicap = $('#handicap').val();
    $("#netScore").prop("readonly", false);
    $("#netScore").val = raw + handicap;
    $("#netScore").prop("readonly", true);    
}

function validateForm()
{
    let flag = true;
    let raw = $("#rawScore").val();
    let handicap = $('#handicap').val();
    let net = $("#netScore").val();

    // Make sure math is right and all are numbers
    flag = net == raw + handicap && !isNaN(raw) && !isNaN(handicap) && !isNaN(net);
    if(flag) 
    {
        return confirm('Done entering scores?');
    }

    return flag;
}