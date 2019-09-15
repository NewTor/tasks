"use strict";
var spApplication = spApplication || {};
/**
 * Действия при загрузке страницы
 */
$(function() {
    /**
     * Переключение панели с фильтром
     */
    $('#filter-btn').on('click', function() {
        spApplication.Controller.toggleFilter();
    });
    /**
     * Обработка клик нового статуса
     */
    $('#btn__edit-ststus').on('click', function() {
        spApplication.Action.editStatus(0);
    });
    /**
     * Обработка клик нового тега
     */
    $('#btn__edit-tag').on('click', function() {
        spApplication.Action.editTag(0);
    });
    /**
     * Обработка клик новая задача
     */
    $('#btn__edit-task').on('click', function() {
        spApplication.Action.editTask(0);
    });

});





