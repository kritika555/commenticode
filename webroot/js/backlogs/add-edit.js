$(document).ready(function () {
    $( ".datepicker" ).datepicker();
    $("#backlog-form").validate({
        rules: {
            title: {
                required: true
            },
            description: {
                required: true
            },
            start_date: {
                required: true
            },
            end_date: {
                required: true,
                greaterThan: "#start-date"
            },
            code_base:{
                required: true,
                extension: "zip"
            }
        },
        messages: {
            end_date: {
                greaterThan: "End date must be less then start date."
            },
            code_base:{
                extension: "Only zip file is allowed."
            }
        }
    });
});