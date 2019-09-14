"use strict";
var spApplication = spApplication || {};
/**
 *
 */
spApplication.options = {};
/**
 *
 */
spApplication.options.task = {
    element: "#modal",
    height: 350,
    width: 590,
    title: "Редактирование задачи",
    server_addr: "edit-task"
};
/**
 *
 */
spApplication.options.status = {
    element: "#modal-status",
    height: 200,
    width: 390,
    title: "Редактирование статуса",
    server_addr: "edit-status"
};
/**
 *
 */
spApplication.options.tags = {
    element: "#modal-tags",
    height: 200,
    width: 390,
    title: "Редактирование тега",
    server_addr: "edit-tag"
};