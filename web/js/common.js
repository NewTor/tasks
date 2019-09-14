"use strict";
var spApplication = spApplication || {};

$(function() {
    $('#filter-btn').on('click', function() {
        spApplication.Controller.toggleFilter();
    });

    $('#btn__edit-ststus').on('click', function() {
        spApplication.Action.editStatus(0);
    });

    $('#btn__edit-tag').on('click', function() {
        spApplication.Action.editTag(0);
    });


});





