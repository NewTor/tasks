


/*var modal = function() {

    $("#modal").load("ajax/add-status")
        .dialog({
            title: "Редактирование задачи",
            width: 590,
            height: 350,
            resizable: false,
            draggable: true,
            modal: true
        });
};*/

$(function() {
    $('#filter-btn').on('click', function() {
        $('#filter-block').slideToggle({
            'complete': function() {
                $('#status_id').trigger('chosen:updated');
            }
        });
    });
});





