(function ($) {
    'use strict';

    $.fn.feedback = function (success, fail) {
        var self = $(this);

        self.find('.dropdown-menu-form').on('click', function (e) {
            e.stopPropagation()
        });

        self.find('.screenshot').on('click', function () {
            self.find('.cam').removeClass('fa-camera fa-check').addClass('fa-refresh fa-spin');
            html2canvas($(document.body), {
                onrendered: function (canvas) {
                    self.find('.screen-uri').val(canvas.toDataURL("image/png"));
                    self.find('.cam').removeClass('fa-refresh fa-spin').addClass('fa-check');
                }
            });
        });

        self.find('.do-close').on('click', function () {
            self.find('.dropdown-toggle').dropdown('toggle');
            self.find('.reported, .failed').hide();
            self.find('.report').show();
            self.find('.cam').removeClass('fa-check').addClass('fa-camera');
            self.find('.screen-uri').val('');
            self.find('textarea').val('');
        });

        var failed = function () {
            self.find('.loading').hide();
            self.find('.failed').show();
            if (fail) {
                fail();
            }
        };

        self.find('form').on('submit', function (e) {
            e.preventDefault();

            self.find('.report').hide();
            self.find('.loading').show();

            var $this = $(this);


            $.ajax({
                url: $this.attr('action'),
                type: "POST",
                dataType: 'json',
                data: $this.serialize()
            })
                .done(function (res) {
                    if (res.error) {
                        return failed();
                    }

                    self.find('.loading').hide();
                    self.find('.reported').show();
                    return undefined;
                })
                .fail(function () {
                    failed();
                })
        });
    };

    $(function () {
        $('#feedback_wrapper_div').feedback();
    });
}(jQuery));


