$(document).ready(function(){

    // click copy to clickboard
    $(".copyToClipboard").click(function(){
        var textToCopy = $(this).children('textarea'),
            textArea = document.createElement('textarea');

        $(this).attr('data-original-title', 'Copied!')
            .tooltip('show')
            .attr('data-original-title', 'Copy');

        textArea.value = textToCopy.val();
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
    });

    // dropdown effect
    $('.dropdown').on('show.bs.dropdown', function(e){
        $(this).find('.dropdown-menu').first().stop(true, true).fadeIn('fast');
    });

    $('.dropdown').on('hide.bs.dropdown', function(e){
        $(this).find('.dropdown-menu').first().stop(true, true).fadeOut('fast');
    });

    // get current page
    var current_page = window.location.pathname.split("/").pop();

    // custom input file for profile picture
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    // add active class to left navbar
    $(function() {
        if (current_page === '') {
            $(".sidebar li a[href$='dashboard']").addClass('active');
        } else if (current_page === 'edit-page' || current_page === '404-edit' || current_page === 'maintenance-edit') {
            $(".sidebar li a[href$='pages']").addClass('active');
        } else if (current_page === 'edit-file') {
            $(".sidebar li a[href$='css-js-files']").addClass('active');
        } else if (current_page === 'edit-user') {
            $(".sidebar li a[href$='user-settings']").addClass('active');
        } else {
            $(".sidebar li a[href$="+ current_page +"]").addClass('active');
        }
    });

    // enable Bootstrap 4 Tooltips
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    // notifications click to dismiss
    $('.notification_close').click(function(e){
      e.preventDefault();
      var parent = $(this).parent('.notification');
      parent.fadeOut("slow", function() { $(this).remove(); } );
    });

    // search filter
    $("#search_table").keyup(function() {
        var value = $(this).val().toLowerCase();
        $("#search_tbody tr").filter(function() {
            $(this).toggle(
                $(this)
                  .text()
                  .toLowerCase()
                  .indexOf(value) > -1
            );
        });
    });

    // Update PAGE status
    $('.status_submit').click(function() {

        if ($(this).hasClass('visible')) {
            publishedStatus = '1';
        } else if ($(this).hasClass('hidden')) {
            publishedStatus = '0';
        }

        $('.status_submit').removeClass('btn-light active');
        $(this).addClass('btn-light active');

        var postForm = {
            'page_ID'        : $('#page_ID').val(),
            'page_published' : publishedStatus
        };

        $.ajax({
            type      : 'POST',
            data      : postForm,
            dataType  : 'json'
        });

    });

    // Update FILE status
    $('.update_page_status').click(function() {

        if ($(this).hasClass('visible')) {
            file_status = '1';
        } else if ($(this).hasClass('hidden')) {
            file_status = '0';
        }

        $('.update_page_status').removeClass('btn-light active');
        $(this).addClass('btn-light active');

        var postForm = {
            'file_ID'        : $('#file_ID').val(),
            'file_status' : file_status,
            'update_file_status' : null
        };

        $.ajax({
            type      : 'POST',
            data      : postForm,
            dataType  : 'json'
        });

    });

});
