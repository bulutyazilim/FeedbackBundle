(function ($) {
    'use strict';

    var FeedbackAdmin = function (el, options) {
        this._opt = $.extend({}, this.options, options)
        this.init(el);
    }

    FeedbackAdmin.prototype.options = {
        selectors: {
            item: ".js-feedback-item",
            delete: ".js-feedback-item-delete",
            showDetails: ".js-feedback-item-show",
            markAsRead: ".js-feedback-item-markas-read",
            markAsDone: ".js-feedback-item-markas-done"
        }
    }

    FeedbackAdmin.prototype.init = function (el) {
        this._$el = $(el);
        this._$delete = this._$el.find(this._opt.selectors.delete);
        this._$showDetails = this._$el.find(this._opt.selectors.showDetails);
        this._$markAsRead = this._$el.find(this._opt.selectors.markAsRead);
        this._$markAsDone = this._$el.find(this._opt.selectors.markAsDone);

        this.bindEvents();
    }

    FeedbackAdmin.prototype.bindEvents = function () {
        var self = this;
        this._$delete.on('click', function (e) {
            e.preventDefault();
            var id = self.getItemId(this);
            self.delete(id);
        });

        this._$showDetails.on('click', function (e) {
            e.preventDefault();
            var id = self.getItemId(this);
            self.showDetails(id);
        });

        this._$markAsDone.on('click', function (e) {
            e.preventDefault();
            var id = self.getItemId(this);
            self.markAs(id, 'done');
        })

        this._$markAsRead.on('click', function (e) {
            e.preventDefault();
            var id = self.getItemId(this);
            self.markAs(id, 'read');
        })
    }

    FeedbackAdmin.prototype.getItemId = function (node) {
        return $(node).parents(this._opt.selectors.item).data('item-id')
    }

    FeedbackAdmin.prototype.delete = function (id) {
        var sure;
        sure = confirm("Are you sure?");
        if (!sure) {
            return;
        }
        $.ajax({
            url: "/admin/feedback/remove/" + id,
            type: "DELETE",
            dataType: 'json',
            success: function (rd) {
                if (rd.status) {
                    return document.location.reload();
                } else {
                    return alert('An error has occured');
                }
            }
        });
    }

    FeedbackAdmin.prototype.showDetails = function (id) {
        var $item = $("#entity_" + id)

        $item.slideToggle();
    }

    FeedbackAdmin.prototype.markAs = function (id, status) {
        $.ajax({
            url: "/admin/feedback/mark/" + status + "/" + id,
            type: "GET",
            dataType: "json",
            success: function (rd) {
                if (rd.status) {
                    return document.location.reload();
                } else {
                    return alert('An error has occured');
                }
            }
        });
    }

    $.fn.feedbackAdmin = function (options) {
        this.each(function () {
            return new FeedbackAdmin(this, options);
        })
    }

    $('.js-feedback').feedbackAdmin();

})(jQuery);
