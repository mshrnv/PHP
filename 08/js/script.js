function success(response){
    $('#calendar').empty();
    $('#calendar').append(response);
}

function update() {
    var year  = $('#year').val();
    var month = $('#month').val();
    var data = {year: year, month: month};
    $.get("./index.php", data, success, "html");
}