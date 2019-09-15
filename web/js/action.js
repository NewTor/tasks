"use strict";
var spApplication = spApplication || {};
/**
 * Функции событий
 */
spApplication.Controller = {
    /**
     * Модальное окно
     *
     * @param options установки окна
     * @param id идентификатор сущности
     * @param callback возвратная функция
     */
    modal: function (options, id, callback) {
        $(options.element).load("ajax/" + options.server_addr + "?id=" + encodeURI(id))
            .dialog({
                title: options.title,
                width: options.width,
                height: options.height,
                resizable: false,
                draggable: true,
                modal: true,
                buttons: {
                    "Сохранить": function() {
                        var data = {
                            status_name: $("#status_name").val(),
                            tag_name: $("#tag_name").val(),
                            name: $("#name").val(),
                            status_id: $("#status_id").val(),
                            priority: $("#priority").val()
                        };
                        var json = JSON.stringify(data);
                        $.ajax({
                            async: false,
                            url: "/ajax/" + options.server_addr + "-save",
                            type: "POST",
                            data: ({id: id, json: json}),
                            success: function (result) {
                                callback(result);
                                $(options.element).dialog("close");
                            }
                        });
                    },
                    "Отмена": function() {
                        $(options.element).dialog("close");
                    }
                }
            });
    },
    /**
     * Удаление записи
     *
     * @param id идентификатор сущности
     * @param destination сущность
     * @param callback возвратная функция
     */
    deleteRow: function(id, destination, callback) {
        if(id != 0) {
            if(confirm("Вы действительно хотите удалить запись?")) {
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
     * Переключение панели фильтра
     */
    toggleFilter: function () {
        $("#filter-block").slideToggle({
            "complete": function() {
                $("#status_id").trigger("chosen:updated");
            }
        });
    },
    /**
     * Pjax загрузчик таблицы статусов
     */
    loadStatusGrid: function () {
        jQuery.pjax.defaults.timeout = 5000;
        jQuery.pjax.reload({container: "#status-pjax"});
    },
    /**
     * Pjax загрузчик таблицы тегов
     */
    loadTagsGrid: function () {
        jQuery.pjax.defaults.timeout = 5000;
        jQuery.pjax.reload({container: "#tags-pjax"});
    },
    /**
     * Pjax загрузчик таблицы задач
     */
    loadTasksGrid: function () {
        jQuery.pjax.defaults.timeout = 5000;
        jQuery.pjax.reload({container: "#tasks-pjax"});
    },
    /**
     * Pjax загрузчик тегов задачи
     */
    loadTaskTagsGrid: function () {
        jQuery.pjax.defaults.timeout = 5000;
        jQuery.pjax.reload({container: "#task-tags-pjax"});
    }
};
/**
 * Вызовы функций
 */
spApplication.Action = {
    /**
     * Сохранение статуса
     * @param id идентификатор статуса
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
     * Удаление статуса
     * @param id идентификатор статуса
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
    },
    /**
     * Сохранение тега
     * @param id идентификатор тега
     */
    editTag: function (id) {
        id = isNaN(id) ? 0 : id;
        spApplication.Controller.modal(spApplication.options.tags, id, function (result) {
            var obj = JSON.parse(result);
            if(obj.error) {
                alert(obj.message);
            }
            spApplication.Controller.loadTagsGrid();
        });
    },
    /**
     * Удаление тега
     * @param id идентификатор тега
     */
    deleteTag: function (id) {
        id = isNaN(id) ? 0 : id;
        spApplication.Controller.deleteRow(id, "tag", function (result) {
            var obj = JSON.parse(result);
            if(obj.error) {
                alert(obj.message);
            }
            spApplication.Controller.loadTagsGrid();
        });
    },
    /**
     * Сохранение задачи
     * @param id идентификатор задачи
     */
    editTask: function (id) {
        spApplication.Controller.modal(spApplication.options.task, id, function (result) {
            var obj = JSON.parse(result);
            if(obj.error) {
                alert(obj.message);
            }
            spApplication.Controller.loadTasksGrid();
        });
    },
    /**
     * Удаление задачи
     * @param id идентификатор задачи
     */
    deleteTask: function (id) {
        spApplication.Controller.deleteRow(id, "task", function (result) {
            var obj = JSON.parse(result);
            if(obj.error) {
                alert(obj.message);
            }
            spApplication.Controller.loadTasksGrid();
        });
    }



};

