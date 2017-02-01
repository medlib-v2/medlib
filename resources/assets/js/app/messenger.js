
(function($) {

    function Messenger(element) {
        this.$element = $(element);
        this.messages = [];

        this.initialize();
        this.getRecentMessage();
    }

    Messenger.prototype.initialize = function() {
        var self = this;

        this.$element.find('.user_message').on('keypress', function(e) {
            if (e.which == 13) {
                self.sendMessage($(this).val());
                $(this).val("");
            }
        });

        this.$element.on('message-updated', function() {
            self.drawMessage();
        });
    };

    Messenger.prototype.sendMessage = function(message) {
        var self = this;

        $.ajax({
            url: '/api/write_message.php',
            data: {
                message: message
            },
            type: 'POST',
            dataType: 'json',
            success: function() {
                self.getRecentMessage();
            }
        });
    };

    Messenger.prototype.getRecentMessage = function() {
        var self = this;

        $.ajax({
            url: '/api/get_message.php',
            data: {
                offset: this.messages.length
            },
            type: 'GET',
            dataType: 'json',
            success: function(json) {
                self.messages = self.messages.concat(json.messages);

                self.$element.trigger('message-updated', [self.messages]);
            }
        });
    };

    Messenger.prototype.drawMessage = function() {
        var $totalMessageCountContainer = this.$element.find('.total-message-count');
        var $listContainer = this.$element.find('ul');
        var $lists = $listContainer.find('li');
        var offset = $lists.size();

        $totalMessageCountContainer.text(this.messages.length);

        for (var i = offset; i < this.messages.length; i ++) {
            var $list = $('<li>');
            $list.text(this.messages[i].content);

            $list.appendTo($listContainer);
        }
    };

    $.fn.messenger = function() {
        return this.each(function() {
            if (!$(this).data('messenger')) {
                $(this).data('messenger', new Messenger(this));
            }
        });
    };
})(jQuery);