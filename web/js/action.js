"use strict";
var spApplication = spApplication || {};
/**
 *
 *
 */
spApplication.Controller = {
    /**
     *
     *
     */
    modal: function (options, id, callback) {
        $(options.element).load("ajax/" + options.server_addr + '?id=' + id)
            .dialog({
                title: options.title,
                width: options.width,
                height: options.height,
                resizable: false,
                draggable: true,
                modal: true,
                buttons: {
                    'Сохранить': function() {
                        var data = {
                            status_name: $('#status_name').val(),
                            tag_name: $('#tag_name').val(),
                            name: $('#name').val(),
                            status_id: $('#status_id').val(),
                            priority: $('#priority').val(),
                            tags: ''
                        };
                        var json = JSON.stringify(data);
                        $.ajax({
                            async: false,
                            url: "/ajax/" + options.server_addr + '-save',
                            type: "POST",
                            data: ({id: id, json: json}),
                            success: function (result) {
                                callback(result);
                                $(options.element).dialog('close');
                            }
                        });
                    },
                    'Отмена': function() {
                        $(options.element).dialog('close');
                    }
                }
            });
    },
    /**
     *
     *
     */
    deleteRow: function(id, destination, callback) {
        if(id != 0) {
            if(confirm('Вы действительно хотите удалить запись?')) {
                $.ajax({
                    async: false,
                    url: "/ajax/delete-" + destination,
                    type: "POST",
                    data: ({id: id}),
                    success: function (result) {
                        callback(result);
                    }
                });
            }
        }
    },
    /**
     *
     *
     */
    toggleFilter: function () {
        $('#filter-block').slideToggle({
            'complete': function() {
                $('#status_id').trigger('chosen:updated');
            }
        });
    },
    /**
     *
     *
     */
    loadStatusGrid: function () {
        jQuery.pjax.defaults.timeout = 5000;
        jQuery.pjax.reload({container: '#status-pjax'});
    }
};
/**
 *
 *
 */
spApplication.Action = {
    /**
     *
     *
     */
    editStatus: function (id) {
        id = isNaN(id) ? 0 : id;
        spApplication.Controller.modal(spApplication.options.status, id, function (result) {
            var obj = JSON.parse(result);
            if(obj.error) {
                alert(obj.message);
            }
            spApplication.Controller.loadStatusGrid();
        });

    },
    /**
     *
     *
     */
    deleteStatus: function (id) {
        id = isNaN(id) ? 0 : id;
        spApplication.Controller.deleteRow(id, "status", function (result) {
            var obj = JSON.parse(result);
            if(obj.error) {
                alert(obj.message);
            }
            spApplication.Controller.loadStatusGrid();
        });
    }





};

