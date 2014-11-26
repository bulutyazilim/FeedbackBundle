$(function () {
    $("#feedback-tab").click(function () {
        $("#feedback-form").toggle("slide");
    });

    $("#feedback-form form").on('submit', function (event) {
        var $form = $(this);
        $.ajax({
            type: 'POST',
            url: '/feedback',
            data: $form.serialize(),
            success: function () {
                $("#feedback-form")
                        .toggle("slide")
                        .find("textarea").empty();
            }
        });
        event.preventDefault();
    });
});