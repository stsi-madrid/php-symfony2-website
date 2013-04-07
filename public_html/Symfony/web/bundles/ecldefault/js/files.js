$(document).ready
(
    function ()
    {
        var xhr          = new XMLHttpRequest(),
            UPL_FILE_URL = PARAM_1,
            DOCS_URL     = PARAM_2,
            REM_FILE_URL = PARAM_3,
            input_active = 1,
            REM_WINDOW   = $('#remove_window'),
            path_file_to_remove,
            li_element_to_remove,
            date = new Date(),
            year = date.getFullYear(),
            ajax_response,
            month_name,
            file_name,
            file_extension,
            file,
            url,
            ul,
            li;
            
        $('.select_file').click
        (
            function()
            {
                if (input_active == 1) {
                    $('input[type=file]').click();
                }
            }
        );
        $("#fileselect").change
        (
            function (event)
            {
                $('.loading').show();
                input_active = 0;
                file = event.target.files[0];
                xhr.onreadystatechange = function()
                {
                    if (xhr.readyState == 4) {
                        if ($('.js_'+year).length == 0) {
                            $('#file_list').append('<li>Recarga la página.</li>');
                        }
                        ajax_response = $.parseJSON(xhr.responseText);
                        month_name = ajax_response.month_name;
                        file_name = ajax_response.file_name;
                        file_extension = ajax_response.file_extension;
                        ul = $('.js_'+year).children('ul').first();
                        li = $('li.month_folder', ul).last();
                        if (!li.hasClass ('js_'+month_name)) {
                            ul.append('<li class="month_folder folder_open js_'+month_name+'"><span></span>'+month_name+'<ul></ul>');
                            li = li.next();
                        }
                        url = DOCS_URL+year+'/'+month_name+'/'+file_name+'.'+file_extension;
                        $('ul', li).append('<li class="files"><span class="delete" title="borrar"></span><span class="file_type_'+file_extension+'"></span><a target="_blank" href="'+url+'">'+file_name+'.'+file_extension+'</a></li>');                          
                        $('.loading').hide();
                        ul.fadeIn ('slow');
                        $('ul', li).fadeIn ('slow');
                        input_active = 1;
                    }
                };
                xhr.open('POST', UPL_FILE_URL, true);
                xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest"); // <-- añadido para symfony2
                xhr.setRequestHeader("X_FILENAME", file.name);
                xhr.send(file);
            }
        );
        $('#files').on
        (
            'click',            
            '.year_folder span, .month_folder span',
            function()
            {
                $(this).nextAll('ul').first().toggle('slow');
                $(this).closest('li').toggleClass('folder_open');
            }
        );
        $('#files').on
        (
            'click',
            '#no',
            function(event)
            {
                event.preventDefault();
                REM_WINDOW.fadeOut('slow');
            }
        );
        $('#files').on
        (
            'click',
            '#yes',
            function(event)
            {
                event.preventDefault();
                $.post(REM_FILE_URL, { input: path_file_to_remove });
                REM_WINDOW.fadeOut('slow');
                var folder = li_element_to_remove.closest('ul');
                li_element_to_remove.fadeOut
                (
                    'slow',
                    function()
                    {
                        $(this).remove();
                        if (folder.children().length == 0) {
                            folder.closest('li').fadeOut
                            (
                                'slow',
                                function()
                                {
                                    $(this).remove();
                                }
                            );
                        }
                    }
                );
            }
        );
        $('#files').on
        (
            'click',            
            '.delete',
            function(event)
            {
                event.preventDefault();
                li_element_to_remove = $(this).closest('li');
                path_file_to_remove = $('a', li_element_to_remove).attr('href');
                li_element_to_remove.append(REM_WINDOW);
                REM_WINDOW.hide();
                REM_WINDOW.fadeIn('slow');
            }
        );            
    }
);