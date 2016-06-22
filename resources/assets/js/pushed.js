$(function () {
    $.fn.showLoader = function(hide){
        $(this).removeClass(hide);
    };
    $.fn.hideLoader = function(hide){
        $(this).addClass(hide);
    };
    $.fn.getLocation = function (url) {
        $("#geoLoader").html("<img src='"+url+"images/ajax.gif' class='padding10'/> Loading Geo Location");
        if (navigator.geolocation) {
            var postion = navigator.geolocation.getCurrentPosition(showPosition);
            this.showLoader('hide');
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    };
    /**
     * Resets the form data.  Causes all form elements to be reset to their original value.
     * element.resetForm();
     */
    $.fn.resetForm = function() {
        var input = /^(?:color|date|datetime|email|month|number|hidden|password|range|search|tel|text|time|url|week)$/i;

        return this.each(function() {
            var type = this.type, tag = this.tagName.toLowerCase();
            if (tag == 'form')
                return $(':input',this).resetForm();
            if (input.test(type) || tag == 'textarea') { $(this).val(''); }
            else if (type == 'checkbox' || type == 'radio') { $(this).checked = false;}
            else if (type == 'select-multiple' || type == 'select-one' || tag == 'select') {
                /**
                $('option', this).each(function(){
                    this.removeAttribute('selected');
                });
                */
                $(this).selectedIndex = -1;
            }
            else if (type == "file") {
                if (/MSIE/.test(navigator.userAgent)) {
                    $(this).replaceWith($(this).clone(true));
                } else {
                    $(this).val('');
                }
            }
            else if (type == 'hidden') { $(this).val(''); }
        });
    };
    $(window).scroll(function(){
        if  ($(window).scrollTop() == $(document).height() - $(window).height()){
            loadData();
        }
    });

    /** Variable to store your files **/
    var files;

    $("#geocomplete").geocomplete({
        map: ".map_canvas",
        details: "form",
        types: ["geocode", "establishment"],
        mapOptions: {
            zoom: 8,
            disableDefaultUI: true,
            draggable: false,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL
            }
        },
        markerOptions: {
            animation: google.maps.Animation.DROP,
            flat: true,
        }
    });
    $('#center-column').on('click', '#status', handleFormSelect);
    $('#center-column').on('click', '#photos', handleFormSelect);
    $('#center-column').on('click', '#video', handleFormSelect);
    $('#center-column').on('click', '#place', handleFormSelect);
    $('#center-column').on('submit', 'form', handleValidateAndSubmit);
    $('#center-column').on('change', 'input[type=file]', prepareUpload);
    $('#center-column').on('change', '#geocomplete', showPosition);

    /** Grab the files and set them to our variable **/
    function prepareUpload(event) {
        files = event.target.files;
    }

    function handleFormSelect(event) {
        event.preventDefault();

        var button = $(this);

        var photos = $('#image').parent('.image');
        var video = $('#videoUrl').parent('.video');
        var place = $('#geocomplete').parent('.place');

        /** hidden all **/
        photos.hideLoader('hide');
        video.hideLoader('hide');
        place.hideLoader('hide');

        $("input[name='shareType']").val(button.attr('id'));

        if(button.attr('id') == 'video') {
            video.showLoader('hide');
            photos.hideLoader('hide');
            place.hideLoader('hide');
        }
        if(button.attr('id') == 'photos') {
            video.hideLoader('hide');
            photos.showLoader('hide');
            place.hideLoader('hide');
        }
        if(button.attr('id') == 'place') {
            video.hideLoader('hide');
            photos.hideLoader('hide');
            place.showLoader('hide');
        }

        return false;
    }
    function loadData() {
        $('div.postloader').html('<img src="http://medlib-v2.lan/images/ajax-loader.gif">');
        $.post("getData.php?lastID=" + $(".post-list:last").attr("id"),
            function(data){
                if (data != "") {
                    $(".post-list:last").after(data);
                }
                $('div.postloader').empty();
            });
    }
    
    function handleValidateAndSubmit(event) {
        event.stopPropagation();
        event.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method') || 'POST';
        var token = form.find("input[name='_token']").val();
        /** Setup parameters **/
        var geocomplete = {};
        var shareType = form.find("input[name='shareType']");
        var body = form.find("textarea");
        var senderName = form.find("input[name='senderName']");
        var senderProfileImage = form.find("input[name='senderProfileImage']");
        var image = form.find("input[name='image']");
        var videoUrl = form.find("input[name='videoUrl']");
        var location = form.find("input[name='location']");
        var place = form.find('#geocomplete');
        var map_canvas = form.find("#map_can");

        geocomplete['lat'] = form.find("input[name='lat']").val();
        geocomplete['lng'] = form.find("input[name='lng']").val();

        var formData = (window.FormData) ? new FormData() : null;
        var data = (formData !== null) ? formData : form.serialize();

        data.append('_token', token);
        data.append(senderName.attr('name'), senderName.val());
        data.append(senderProfileImage.attr('name'), senderProfileImage.val());

        if(body.val() == '' && body.attr('name') == 'body'){
            Messenger().post({
                message: "Please write something.",
                type: 'error',
                showCloseButton: true
            });
            return false;
        }

        data.append(body.attr('name'), body.val());

        if(shareType.val() == 'photos') {
            var filename = image.val();
            if (filename == "") {
                Messenger().post({
                    message: "<span class='error'>Please Browse to upload a valid image file</span>"+"<h2>Note</h2>"+"<span class='error_message'>Only JPEG, JPG and PNG Images type allowed</span>",
                    type: 'error',
                    showCloseButton: true
                });
                return false;
            }

            var match = ["image/jpeg","image/png","image/jpg"];
            var imagefile = files[0].type;

            if(!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                Messenger().post({
                    message: "<span class='error'>Please select a valid image file</span>"+"<h2>Note</h2>"+"<span class='error_message'>Only JPEG, JPG and PNG Images type allowed</span>",
                    type: 'error',
                    showCloseButton: true
                });
                return false;
            }
            // Adding the files
            $.each(files, function(key, value) {
                data.append(image.attr('name'), value);
            });
        }

        if(shareType.val() == 'video') {
            if (videoUrl.val() == '' && videoUrl.attr('name') == 'videoUrl') {
                Messenger().post({
                    message: "Video Url could not be empty",
                    type: 'error',
                    showCloseButton: true
                });
                return false;
            }
            var video = validateVideoUrl(videoUrl);
            if(video == false) {
                Messenger().post({
                    message: "Not a valid <b>Youtube/Vimeo</b> video URL",
                    type: 'error',
                    showCloseButton: true
                });
                return false;
            }
            data.append(videoUrl.attr('name'), videoUrl.val());
        }

        if(shareType.val() == 'place') {
            if (location.val() == '' && location.attr('name') == 'location') {
                Messenger().post({
                    message: "Place could not be empty.",
                    type: 'error',
                    showCloseButton: true
                });
                return false;
            }

            if((geocomplete['lat']  == '' ) || (geocomplete['lng'] == '')){
                console.log(geocomplete['lng'].val());
                Messenger().post({
                    message: "Not a valid place.",
                    type: 'error',
                    showCloseButton: true
                });
                return false;
            }
            data.append(location.attr('name'), JSON.stringify(geocomplete));
        }

        ajaxSubmit(url, method, data)
            .done(function(data){
            console.log("Done :", data);
        })
            .fail(function(data) {
                Messenger().post({
                    message: data.responseText,
                    type: 'error',
                    showCloseButton: true
                });
            });

        /**
         * Resets the form data.
         * form.resetForm();
         */

        body.resetForm();
        image.resetForm().hideLoader('hide');
        videoUrl.resetForm().hideLoader('hide');
        location.resetForm().hideLoader('hide');
        shareType.val('status');
        //map_canvas.removeAttr( 'style' ).empty();
        map_canvas.hideLoader('hide');
        place.showLoader('hide');
        place.parent('.place').hideLoader('hide');
    }

    function validateVideoUrl(videoUrl){

        //var regYoutube = /^.*((youtu.be/)|(v/)|(/u/w/)|(embed/)|(watch?))??v?=?([^#&?]*).*/;
        //var regVimeo = /^.*(vimeo.com/)((channels/[A-z]+/)|(groups/[A-z]+/videos/))?([0-9]+)/;
        //var regDailymotion = /^.+dailymotion.com/(video|hub)/([^_]+)[^#]*(#video=([^_&]+))?/;
        //var regMetacafe = /^.*(metacafe.com)(/watch/)(d+)(.*)/i;

        var url = videoUrl.val();
        var regYoutube = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var regVimeo = /^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;
        if(regYoutube.test(url) || regVimeo.test(url)) { return true; }
        else { return false; }
    }
    
    function ajaxSubmit(url, method, data) {

        return $.ajax({
            url : url,
            type : method,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: data
        });
    }

    /** Geolocation Show Position **/
    function showPosition(event) {
        event.preventDefault();
        /**
        * $("#latitude").val(position.coords.latitude);
        * $("#longitude").val(position.coords.longitude);
        * var img ="http://maps.googleapis.com/maps/api/staticmap?zoom=13&size=570x300&scale=2&maptype=roadmap&markers=color:red%7Clabel:S%7C"+ position.coords.latitude +","+ position.coords.longitude;
        * $("#geoContainerDiv").html("<img src='"+img+"' id='geoImage'/>")
        */
        var canvas = $('#map_can');
        canvas.showLoader('hide');
    }
});