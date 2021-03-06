function updateNetScore()
{
    let raw = Number($("#rawScore").val());
    let handicap = Number($('#handicap').val());
    //$("#netScore").prop("readonly", false);
    let netScore = raw + handicap;
    $("#netScore").val(netScore);
    //$("#netScore").prop("readonly", true);    
}

function validateForm()
{
    let flag = true;
    let raw = Number($("#rawScore").val());
    let handicap = Number($('#handicap').val());
    let net = Number($("#netScore").val());

    // Make sure math is right and all are numbers
    flag = net == raw + handicap && !isNaN(raw) && !isNaN(handicap) && !isNaN(net);
    if(flag) 
    {
        return confirm('Are you sure you want to update this score?');
    }
    return flag;
}

function confirmDelete()
{
    var name = $("#player").val();
    return confirm('Are you sure you want to delete this score for ' + name + '?');
}