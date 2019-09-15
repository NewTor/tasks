"use strict";
var spApplication = spApplication || {};
spApplication.options = {};
/**
 * Установки модального окна задачи
 */
spApplication.options.task = {
    element: "#modal-task",
    height: 470,
    width: 600,
    title: "Редактирование задачи",
    server_addr: "edit-task"
};
/**
 * Установки модального окна статуса
 */
spApplication.options.status = {
    element: "#modal-status",
    height: 200,
    width: 390,
    title: "Редактирование статуса",
    server_addr: "edit-status"
};
/**
 * Установки модального окна тега
 */
spApplication.options.tags = {
    element: "#modal-tags",
    height: 200,
    width: 390,
    title: "Редактирование тега",
    server_addr: "edit-tag"
};