var namesList;

function AddNames(names)
{
    namesList = names;
}

function AddAutoFill(id) {
    $(".autoName").autocomplete({
        source: namesList
    });
}

function add_row()
{
    if (isLastLineValid())
    {
        rowno=$("#scoreHandis tr").length;
        rowno=rowno+1;
        $("#scoreHandis tr:last").after("<tr id='row"+rowno+"'><td>Name: <input type='text' name='name[]' class='autoName' id='name"+rowno+" autocomplete='off' size='15'></td><td>Raw Score: <input type='text' name='score[]' autocomplete='off' size='3'></td><td><input type='button' value='DELETE' onclick=delete_row('row"+rowno+"')></td></tr>");
        AddAutoFill("name" + rowno);
    }
}

function delete_row(rowno)
{
 $('#'+rowno).remove();
}

function isLastLineValid()
{
    flag = true;
    var nameInput =  $('table#scoreHandis tr:last input[name="name[]"]');
    var scoreInput = $('table#scoreHandis tr:last input[name="score[]"]');
    nameInput.removeClass("invalid");
    scoreInput.removeClass("invalid");
    if (!namesList.includes(nameInput.val()))
    {
        nameInput.addClass("invalid");
        flag = false;
    }
    if (scoreInput.val() < 1 || scoreInput.val() > 200 || isNaN(scoreInput.val()))
    {
        scoreInput.addClass("invalid");
        flag = false;
    }
    return flag;
}