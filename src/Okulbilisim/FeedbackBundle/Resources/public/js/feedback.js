$(function () {
    $("#feedback-tab").click(function () {
        $("#feedback-form").toggle("slide");
    });

    $("#feedback-form form").on('submit', function (event) {
        var $form = $(this);
        $.ajax({
            type: 'POST',
            url: '/feedback/new',
            data: $form.serialize(),
            success: function () {
                $("#feedback-form")
                        .toggle("slide")
                        .find("textarea").empty();
            }
        });
        event.preventDefault();
    });
    $("#feedback .btn-close").on('click',function(){
        $("#feedback-form")
            .toggle("slide");
        return false;
    })
});