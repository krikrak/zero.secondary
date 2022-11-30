jQuery(function ($) {
function ajax_filter() {
        // $('#misha_filters').submit(function(){

        $.ajax({
            url: misha_loadmore_params.ajaxurl,
            data: $('#misha_filters').serialize(), // form data
            dataType: 'json', // this data type allows us to receive objects from the server
            type: 'POST',
            beforeSend: function (xhr) {
                $('#misha_filters').find('button').text('Filtering...');
            },
            success: function (data) {

                // when filter applied:
                // set the current page to 1
                misha_loadmore_params.current_page = 1;

                // set the new query parameters
                misha_loadmore_params.posts = data.posts;

                // set the new max page parameter
                misha_loadmore_params.max_page = data.max_page;

                // change the button label back
                // $('#misha_filters').find('button').text('Apply filter');

                // insert the posts to the container
                $('#ajax_post_wrap').html(data.content);

                // hide load more button, if there are not enough posts for the second page
                if (data.max_page < 2) {
                    $('#misha_loadmore').hide();
                } else {
                    $('#misha_loadmore').show();
                }
            },
            complete: function () {
                
                if (typeof ScrollTrigger === 'undefined' || ScrollTrigger === null) {} else {
                if (typeof scrollevent_motion === 'undefined' || scrollevent_motion === null) {} else {
                    // scrollevent_motion();
                }
                // ScrollTrigger.refresh();
                }
            }
        });
        

        // do not submit the form
        return false;
    };
    // });

    $('input[type="checkbox"]').click(function () {
        $('input[type="checkbox"]').not(this).prop("checked", false);
    });

    $('#misha_filters').change(function () {
        ajax_filter();
    });
});