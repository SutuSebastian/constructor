$(document).ready(function(){

      // get current page
      var current_page = window.location.pathname.split("/").pop();

      // monaco editor toggle-ON fullscreen
      $('#toggle_editor_fullscreen').click(function(){
          $('.monaco-editor').parent().addClass('editor-fullscreen');
      });
      // monaco editor toggle-OFF fullscreen
      $(document).keyup(function(e) {
           if (e.key === "Escape" || e.key === "Esc" || e.key === 27) { // escape key maps to keycode `27`
              $('.monaco-editor').parent().removeClass('editor-fullscreen');
          }
      });
      
      // when CTRL+S / CMD+S click -> submit save function
      editorClickSubmit = function (editor_submit_button_ID) {
          jQuery(document).keydown(function(event) {
              if((event.ctrlKey || event.metaKey) && event.which == 83) {
                  $('#'+ editor_submit_button_ID).click();
                  event.preventDefault();
                  return false;
              }
          });
      }

      var notification_success = "<div class='notification_body fadeInDown animated'><div class='notification notification-success'><div class='notification_content'><p class='notification_type'>Success</p><p class='notification_message'>Code updated!</p></div><div class='notification_close'></div></div></div>";

      // function to create Monaco Editor instances
      createMonacoEditor = function (textarea_ID, editor_name, editor_div_ID, submit_post_name, monaco_language) {

          var textarea_val = $('#'+ textarea_ID).val();

          require.config({ paths: { 'vs': 'template/assets/ext/monaco-editor/min/vs' }});
          require(['vs/editor/editor.main'], function() {
              editor_name = monaco.editor.create(document.getElementById(''+ editor_div_ID +''), {
                  value: textarea_val,
                  language: monaco_language,
                  theme: 'vs-dark',
                  wordWrap: 'on',
                  automaticLayout: true
              });

              // Update Editor Value
              updateEditor = function (page_link) {
                  $('#editorSuccess').empty().html(notification_success);

                  $(function(){
                      setTimeout(function(){
                          $('#editorSuccess').empty();
                      }, 3000);
                  });

                  var editor_val  = editor_name.getValue(),
                      editor_post = {
                          'page_link'     : page_link,
                          'editor_value'  : editor_val,
                          [submit_post_name] : true,
                      };

                  $.ajax({
                      type      : 'POST',
                      data      : editor_post,
                      dataType  : 'JSON'
                  });
              } // end update editor

          });

      } // END monaco editor instance

      // specific page editor
      if (current_page === 'edit-page') {
          createMonacoEditor('editorVal', 'editor_specific', 'current_pageEditor', 'editor_update_submit','html');
          editorClickSubmit('update_page');
      }

      // Header edit
      if (current_page === 'header-edit') {
          createMonacoEditor('navbarVal', 'editor_nav', 'navbarEditor', 'template_update_submit','html');
          editorClickSubmit('update_navbar');
      }

      // Footer edit
      if (current_page === 'footer-edit') {
          createMonacoEditor('footerVal', 'editor_footer', 'footerEditor', 'template_update_submit','html');
          editorClickSubmit('update_footer');
      }

      // 404 edit
      if (current_page === '404-edit') {
          createMonacoEditor('404Val', 'editor_404', '404Editor', 'editor_update_submit','html');
          editorClickSubmit('update_404');
      }

      // Maintenance edit
      if (current_page === 'maintenance-edit') {
          createMonacoEditor('maintenanceVal', 'editor_maintenance', 'maintenanceEditor', 'editor_update_submit','html');
          editorClickSubmit('update_maintenance');
      }

      // Specific file editor
      if (current_page === 'edit-file') {

          var fileVal = $('#fileVal').val(),
              file_ID = $('#file_ID').val(),
              file_name = $('#file_name').val(),
              file_type = $('#file_type').val();

          if (file_type === 'js') {
              editor_language = 'javascript';
          } else {
              editor_language = 'css';
          }

          // style editor
          require.config({ paths: { 'vs': 'template/assets/ext/monaco-editor/min/vs' }});
          require(['vs/editor/editor.main'], function() {
              editor = monaco.editor.create(document.getElementById('current_fileEditor'), {
                  value: fileVal,
                  language: editor_language,
                  theme: 'vs-dark',
                  wordWrap: 'on',
                  automaticLayout: true
              });

              // Update Editor Value
              updateEditor = function () {
                  $('#editorSuccess').empty().html(notification_success);

                  $(function(){
                      setTimeout(function(){
                          $('#editorSuccess').empty();
                      }, 3000);
                  });

                  var editorVal = editor.getValue(),
                      editorPost = {
                          'file_ID'       : file_ID,
                          'file_name'     : file_name,
                          'file_type'     : file_type,
                          'editor_value'  : editorVal,
                          'file_update_submit' : true,
                      };

                  $.ajax({
                      type      : 'POST',
                      data      : editorPost,
                      dataType  : 'JSON'
                  });

              } // end update editor

          });
          editorClickSubmit('update_file');
      } // END file update

      // link style & script edit
      if (current_page === 'link-resources') {

          var link_styleVal = $('#link_styleVal').val(),
              link_scriptVal = $('#link_scriptVal').val();

          // style editor
          require.config({ paths: { 'vs': 'template/assets/ext/monaco-editor/min/vs' }});
          require(['vs/editor/editor.main'], function() {
              editor1 = monaco.editor.create(document.getElementById('link_styleEditor'), {
                  value: link_styleVal,
                  language: 'html',
                  theme: 'vs-dark',
                  wordWrap: 'on',
                  automaticLayout: true
              });

              // script editor
              editor2 = monaco.editor.create(document.getElementById('link_scriptEditor'), {
                  value: link_scriptVal,
                  language: 'html',
                  theme: 'vs-dark',
                  wordWrap: 'on',
                  automaticLayout: true
              });

              // Update Editor Value
              updateEditor = function () {
                  $('#editorSuccess').empty().html(notification_success);

                  $(function(){
                      setTimeout(function(){
                          $('#editorSuccess').empty();
                      }, 3000);
                  });

                  var editorVal1 = editor1.getValue(),
                      editorVal2 = editor2.getValue(),
                      editorPostStyle = {
                          'page_link'     : 'link-style',
                          'editor_value'  : editorVal1,
                          'template_update_submit' : true,
                      },
                      editorPostScript = {
                          'page_link'     : 'link-script',
                          'editor_value'  : editorVal2,
                          'template_update_submit' : true,
                      };


                  // style
                  $.ajax({
                      type      : 'POST',
                      data      : editorPostStyle,
                      dataType  : 'JSON'
                  });
                  // script
                  $.ajax({
                      type      : 'POST',
                      data      : editorPostScript,
                      dataType  : 'JSON'
                  });
              } // end update editor

          });

          editorClickSubmit('update_resources');

      } // END link style & script edit

});
