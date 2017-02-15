    /**
     *
     * @type type Medlib.FriendRequest()
     */
    Medlib.plugin('FriendRequest',function () {
        function handleAjaxRequests(event) {

            event.preventDefault();

            $.extend(Medlib.Notification.options, {position: 'top-left'});

            var button = $(this),
                username = button.data('username'),
                token = button.data('token'),
                url = button.attr('href'),
                method = button.data('method') || 'POST',
                className = button.attr('class'),
                imgPath = button.closest('.panel-default').find('.img-circle').attr('src') || button.closest('.user-profile').find('.img-circle').attr('src');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': Setting.csrfToken
                }
            });

            $.ajax({
                type: method,
                url: url,
                data: {
                    username: username,
                    _token: Setting.csrfToken
                }
            }).done(function (data) {

                if (data.response == 'success') {
                    switch (className) {

                        case 'btn btn-success add-friend-request-button':
                            button.empty();
                            button.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;'+ Lang.get('auth.friends_send_request'));
                            button.attr('disabled', 'disabled');
                            Medlib.Notification.add({
                                title: 'Top Left',
                                text: data.message,
                                className: 'success'
                            });
                            break;

                        /**
                         * From friends/requests Interface
                         */
                        case 'btn btn-primary btn-success accept-friend-button':
                            button.empty();
                            button.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;'+ Lang.get('auth.friends_accept_request'));
                            button.attr('disabled', 'disabled');
                            Medlib.Notification.add({
                                title: 'Top Left',
                                text: data.message,
                                className: 'success'
                            });
                            button.closest('.panel-default').parents('.item').fadeOut(300);
                            if (data.count == 0) {
                                button.parents('.col-md-12').append('<div class="alert alert-info" role="alert">' +
                                    '<span class="glyphicon glyphicon-info-sign"></span>'+ Lang.get('auth.friends_dont_have') +' </div>'
                                );
                            }
                            break;

                        /**
                         * From friends/requests Interface
                         */
                        case 'btn btn-primary btn-danger del-friend-button btn-sm':
                            button.closest('.panel-default').parents('.item').fadeOut(300);
                            Medlib.Notification.add({
                                title: 'Top Left',
                                text: data.message,
                                className: 'success'
                            });
                            if (data.count == 0) {
                                button.parents('.col-md-12').append('<div class="alert alert-info" role="alert">' +
                                    '<span class="glyphicon glyphicon-info-sign"></span>'+ Lang.get('auth.friends_dont_have') +' </div>'
                                );
                            }
                            break;

                        /**
                         * From u/{username}
                         */
                        case 'btn btn-danger del-friend-button':
                            button.removeClass();
                            button.addClass('btn btn-success send-friend-request-button');
                            button.attr('href', url + '/requests');
                            button.attr('data-method', 'POST');
                            button.data('method', 'POST');
                            button.empty();
                            button.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;'+ Lang.get('auth.friends_remove_request'));
                            break;

                        case 'btn btn-success send-friend-request-button':
                            button.empty();
                            button.append('<i class="fa fa-check-circle fa-fw"></i>&nbsp;'+ Lang.get('auth.friends_send_request'));
                            button.attr('disabled', 'disabled');
                            Medlib.Notification.add({
                                title: 'Top Left',
                                text: data.message,
                                className: 'success'
                            });
                            break;

                        case 'btn btn-primary unfriend-button-3 btn-sm':

                            button.closest('.listed-object-close').slideUp();

                            $("a[data-username=" + button.attr('data-username') + "]").hide('slide', {direction: 'right'}, 300);

                            if (data.count == 0) {
                                $('.users-list').append('<div class="alert alert-info" role="alert">' +
                                    '<span class="glyphicon glyphicon-info-sign"></span>'+ Lang.get('auth.friends_dont_have') +'</div>');

                                $('#friend-side-list').hide();
                                $('#friend-list').append('<div class="alert alert-info" role="alert">'
                                    + '<span class="glyphicon glyphicon-info-sign"></span>' + Lang.get('auth.friends_dont_have')
                                    + '</div>');
                            }

                            var friendsCount = $('.friends-count').text();
                            var actualFriendsCount = parseInt(friendsCount) - 1;
                            $('.friends-count').text(actualFriendsCount);
                            break;

                        case 'logout-link':
                            if ($('#no-friend-chat-alert').is(":visible")) {
                                window.location.replace("/");
                            }
                            else {
                                $('.side-list').each(function () {
                                    var friendListUserId = $(this).data('username');
                                    sessionStorage.removeItem('conversation-with-' + friendListUserId);
                                });
                                window.location.replace("/");
                            }
                            break;
                    }
                }
                else if (data.response == 'failed') {
                    Medlib.Notification.add({
                        title: 'Top Left',
                        text: data.message,
                        className: 'danger'
                    });
                }
                else {
                    Medlib.Notification.add({
                        title: 'Top Left',
                        text: 'Something went wrong. Please try again.',
                        className: 'danger'
                    });
                }
            }).fail(function (data) {

                if (data.response == 'failed') {
                    Medlib.Notification.add({
                        title: 'Top Left',
                        text: data.message,
                        className: 'danger'
                    });
                }
                console.log(data);

                Medlib.Notification.add({
                    title: 'Top Left',
                    text: 'Something went wrong. Please try again.',
                    className: 'danger'
                });
            });

            return false;
        }

        return {
            main: function () {
                /**
                 * Ajax friend activity
                 */
                $('.add-friend-request-button').click(handleAjaxRequests);

                $('.users-list').on('click', '.accept-friend-button', handleAjaxRequests);
                $('.users-list').on('click', '.del-friend-button', handleAjaxRequests);
                $('.user-profile').on('click', '.send-friend-request-button', handleAjaxRequests);
                $('.user-profile').on('click', '.del-friend-button', handleAjaxRequests);
            }
        }
    });
