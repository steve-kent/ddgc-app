//List of all names used for autofill
var namesList;
var courseList;

// Add the list of names passed in to namesList global variable
function AddNames(names)
{
    namesList = names;
}

// Add the list of courses passed in to courseList global variable
function AddCourses(courses)
{
    courseList = courses;
}

//Add autofill JQuery UI functionality to .autoName class elements
function AddAutoFill() {
    $(".autoName").autocomplete({
        source: namesList
    });
}

// Add another line for a score and put focus in the name input
function add_row()
{
    if (isLastLineValid())
    {
        rowno=$("#scoreHandis tr").length;
        rowno=rowno+1;
        $("#scoreHandis tr:last").after("<tr id='row"+rowno+"'><td>Name: <input type='text' name='name[]' class='autoName' size='15'></td><td>Raw Score: <input type='number' name='score[]' min='1' max='200' value='54' class='scoreField'></td><td><input type='button' value='DELETE' onclick=delete_row('row"+rowno+"')></td></tr>");
        AddAutoFill();
        $('table#scoreHandis tr:last input[name="name[]"]').focus();
    }
}

// Delete the row passed in from the page
function delete_row(rowno)
{
 $('#'+rowno).remove();
}

//Check if the last row has a vaild name and score
function isLastLineValid()
{
    flag = true;
    var nameInput =  $('table#scoreHandis tr:last input[name="name[]"]');
    var scoreInput = $('table#scoreHandis tr:last input[name="score[]"]');
    var course = $("#course");
    nameInput.removeClass("invalid");
    scoreInput.removeClass("invalid");
    if (scoreInput.val() < 1 || scoreInput.val() > 200 || isNaN(scoreInput.val()))
    {
        scoreInput.addClass("invalid");
        flag = false;
        scoreInput.focus();
    }
    if (!namesList.includes(nameInput.val()))
    {
        nameInput.addClass("invalid");
        flag = false;
        nameInput.focus();
    }
    if (!courseList.includes(course.val()))
    {
        course.addClass("invalid");
        flag = false;
        course.focus();
    }
    return flag;
}