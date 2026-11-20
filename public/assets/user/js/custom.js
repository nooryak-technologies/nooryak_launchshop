"use strict";

WebFont.load({
    google: { "families": ["Lato:300,400,700,900"] },
    custom: { "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: [mainurl + '/assets/admin/css/fonts.min.css'] },
    active: function () {
        sessionStorage.fonts = true;
    }
});

function cloneInput(fromId, toId, event) {
    let $target = $(event.target);
    if ($target.is(':checked')) {
        $('#' + fromId + ' .form-control').each(function (i) {
            let index = i;
            let val = $(this).val();
            let $toInput = $('#' + toId + ' .form-control').eq(index);

            if ($toInput.hasClass('summernote')) {
                let editorContent = tinyMCE.get($(this).attr('id')).getContent();
                let tmcId = $toInput.attr('id');
                tinyMCE.get(tmcId).setContent(editorContent);
            } else if ($(this).data('role') == 'tagsinput') {
                if (val.length > 0) {
                    let tags = val.split(',');
                    tags.forEach(tag => {
                        $toInput.tagsinput('add', tag);
                    });
                } else {
                    $toInput.tagsinput('removeAll');
                }
            } else if ($(this).data('role') == 'checkbox') {
                if ($(this).is(':checked')) {
                    $toInput.prop('checked', true);
                }
            } else {
                $toInput.val(val);
            }
        });
    } else {
        $('#' + toId + ' .form-control').each(function (i) {
            let $toInput = $('#' + toId + ' .form-control').eq(i);

            if ($(this).hasClass('summernote')) {
                $toInput.summernote('code', '');
            } else if ($(this).data('role') == 'tagsinput') {
                $toInput.tagsinput('removeAll');
            } else {
                $toInput.val('');
            }
        });
    }
}


/*****************************************************
 ==========Bootstrap Notify start==========
 ******************************************************/
function bootnotify(message, title, type) {
    var content = {};

    content.message = message;
    content.title = title;
    content.icon = 'fa fa-bell';

    $.notify(content, {
        type: type,
        placement: {
            from: 'top',
            align: 'right'
        },
        showProgressbar: true,
        time: 1000,
        allow_dismiss: true,
        delay: 4000
    });
}
/*****************************************************
 ==========Bootstrap Notify end==========
 ******************************************************/

/*****************************************************
==========Demo code ==========
******************************************************/
if (demo_mode == 'active') {
    $.ajaxSetup({
        beforeSend: function (jqXHR, settings, event) {
            if (settings.type == 'POST') {
                if ($(".request-loader").length > 0) {
                    $(".request-loader").removeClass('show');
                }
                if ($(".modal").length > 0) {
                    $(".modal").modal('hide');
                }
                if ($("button[disabled='disabled']").length > 0) {
                    $("button[disabled='disabled']").removeAttr('disabled');
                }
                bootnotify('This is demo version. You cannot change anything here!', 'Demo Version', 'warning')
                jqXHR.abort(event);
            }
        },
        complete: function () {
            // hide progress spinner
        }
    });
}
/*****************************************************
==========Demo code end==========
******************************************************/

$(function ($) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* ***************************************************************
    ==========disabling default behave of form submits start==========
    *****************************************************************/
    $("#ajaxEditForm").attr('onsubmit', 'return false');
    $("#ajaxForm").attr('onsubmit', 'return false');
    /* *************************************************************
    ==========disabling default behave of form submits end==========
    ***************************************************************/

    // make any post as a featured post or not.
    $(document).on('change', '.featured-portfoliCat', function () {
        $('.request-loader').addClass('show');
        let catInfo = $(this).data();
        $("#featuredPortfoliCat" + catInfo.data).submit();
    });


    // get sub category for item insert
    $(document).on('change', '.getSubCategory', function () {
        let url = $("#subcatGetterForItem").attr('value');
        let id = $(this).val();
        let code = $(this).data('code');

        var formData = new FormData();
        formData.append('url', url);
        formData.append('category_id', id);
        formData.append('code', code);
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#" + code + '_subcategory').empty();
                $("#" + code + '_subcategory').append('<option value="">-Select Subcategory-</option>');
                jQuery.each(response.subcategories, function (key, value) {
                    $("#" + code + '_subcategory').append('<option value="' + value.id + '">' + value.name + '</option>')
                });
            },
            error: function (data) {
            }
        });
    });



    // Sidebar Search

    $(".sidebar-search").on('input', function () {
        let term = $(this).val().toLowerCase().trim();

        if (term.length > 0) {
            $(".sidebar ul li.nav-item").each(function (i) {
                let $mainMenu = $(this);
                let menuName = $mainMenu.find("> a p, > a span").text().toLowerCase();

                // if any main menu text is matched
                if (menuName.indexOf(term) > -1) {
                    $mainMenu.removeClass('d-none').addClass('d-block');
                } else {
                    let matched = 0;
                    // search sub-items of the current main menu
                    $mainMenu.find('span.sub-item').each(function () {
                        if ($(this).text().toLowerCase().indexOf(term) > -1) {
                            matched = 1;
                            $(this).closest('li').removeClass('d-none').addClass('d-block');
                        } else {
                            $(this).closest('li').removeClass('d-block').addClass('d-none');
                        }
                    });

                    // if any sub-item is matched
                    if (matched == 1) {
                        $mainMenu.removeClass('d-none').addClass('d-block');
                        // Auto-expand the dropdown so user sees the matched items
                        $mainMenu.find('.collapse').addClass('show');
                        $mainMenu.find('[data-toggle="collapse"]').attr('aria-expanded', 'true');
                    } else {
                        $mainMenu.removeClass('d-block').addClass('d-none');
                    }
                }
            });
        } else {
            $(".sidebar ul li.nav-item").removeClass('d-none').addClass('d-block');
            $(".sidebar ul li.nav-item .collapse li").removeClass('d-none').addClass('d-block');
        }
    });

    $(".sidebar-search").on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            e.stopPropagation();

            let $firstLink = $(".sidebar ul li.nav-item:not(.d-none) .collapse li:not(.d-none) a[href]").first();
            if ($firstLink.length === 0) {
                $firstLink = $(".sidebar ul li.nav-item:not(.d-none) > a[href]:not([data-toggle='collapse'])").first();
            }
            if ($firstLink.length === 0) {
                $firstLink = $(".sidebar ul li.nav-item:not(.d-none) .collapse a[href]").first();
            }

            if ($firstLink.length > 0) {
                let href = $firstLink.attr('href');
                if (href && href !== '#' && href !== 'javascript:void(0);') {
                    window.location.href = href;
                }
            }
            return false;
        }
    });

    $("#sidebarSearchForm").on('submit', function (e) {
        e.preventDefault();
        return false;
    });

    // =========================================================================
    // User Dashboard Sidebar Scroll Persistence, Centering & AJAX Navigation
    // =========================================================================
    $(function () {
        const $sidebarWrapper = $('.sidebar-wrapper');

        function restoreSidebarScroll($targetEl) {
            if (!$sidebarWrapper.length) return;
            const $scrollElem = $sidebarWrapper.find('.scroll-content').length ? $sidebarWrapper.find('.scroll-content') : $sidebarWrapper;
            const $activeItem = ($targetEl && $targetEl.length)
                ? $targetEl
                : $('.sidebar .nav-item.active, .sidebar li.active, .sidebar .subnav li.active, .sidebar .nav-collapse li.active').filter(':visible').last();

            if ($activeItem.length > 0) {
                const wrapperOffset = $sidebarWrapper.offset().top;
                const wrapperHeight = $sidebarWrapper.height();
                const itemOffset = $activeItem.offset().top;
                const currentScroll = $scrollElem.scrollTop() || $sidebarWrapper.scrollTop();

                const targetScroll = currentScroll + (itemOffset - wrapperOffset) - (wrapperHeight / 2) + ($activeItem.outerHeight() / 2);
                $scrollElem.stop(true, false).animate({
                    scrollTop: Math.max(0, targetScroll)
                }, 200);
                $sidebarWrapper.stop(true, false).animate({
                    scrollTop: Math.max(0, targetScroll)
                }, 200);
            } else {
                const savedScroll = sessionStorage.getItem('userSidebarScroll');
                if (savedScroll !== null) {
                    $scrollElem.scrollTop(parseInt(savedScroll, 10));
                    $sidebarWrapper.scrollTop(parseInt(savedScroll, 10));
                }
            }
        }

        function reinitializePlugins($container) {
            // 1. Tagsinput
            if ($.fn.tagsinput) {
                $container.find('input[data-role="tagsinput"]').each(function () {
                    if (!$(this).data('tagsinput')) {
                        $(this).tagsinput();
                    }
                });
            }

            // 2. Select2 & NiceSelect
            if ($.fn.select2) {
                $container.find('.select2').each(function () {
                    $(this).select2();
                });
            }
            if ($.fn.niceSelect) {
                $container.find('select.nice-select, select.header-nice-select').each(function () {
                    $(this).niceSelect();
                });
            }

            // 3. Flatpickr / Datepicker
            if (window.flatpickr) {
                $container.find('.datepicker, .flatpickr').each(function () {
                    flatpickr(this);
                });
            }

            // 4. JSColor
            if (typeof jscolor !== 'undefined' && jscolor.installByClassName) {
                jscolor.installByClassName("jscolor");
            }

            // 5. Iconpicker
            if ($.fn.iconpicker) {
                $container.find('.icp-dd').each(function () {
                    $(this).iconpicker();
                });
            }

            // 6. DataTables
            if ($.fn.DataTable) {
                $container.find('#basic-datatables').each(function () {
                    if (!$.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable({
                            responsive: true
                        });
                    }
                });
            }

            // 7. Re-execute inline scripts within the loaded content
            $container.find('script').each(function () {
                const scriptSrc = $(this).attr('src');
                if (!scriptSrc) {
                    try {
                        $.globalEval($(this).text() || this.textContent || this.innerHTML || '');
                    } catch (e) {
                        console.warn('AJAX script eval warning:', e);
                    }
                }
            });
        }

        function loadDashboardPage(url, pushState = true) {
            if (!url || url.indexOf('javascript:') === 0 || url === '#') return;

            $('.request-loader').addClass('show');

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'html',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (response) {
                    try {
                        const $temp = $('<div>').append($.parseHTML(response, document, true));
                        const newTitle = $temp.find('title').text();
                        if (newTitle) {
                            document.title = newTitle;
                        }

                        // Extract main content
                        const $newContent = $temp.find('.main-panel .content');
                        if ($newContent.length > 0) {
                            $('.main-panel .content').replaceWith($newContent);
                            if (pushState) {
                                window.history.pushState({ dashboardAjaxUrl: url }, '', url);
                            }

                            // Smooth scroll content to top
                            $('html, body').animate({ scrollTop: 0 }, 150);

                            // Re-initialize dynamic components
                            reinitializePlugins($('.main-panel .content'));
                        } else {
                            // Fallback if structural layout differs
                            window.location.href = url;
                            return;
                        }
                    } catch (err) {
                        console.error('AJAX page parse error, falling back to full load:', err);
                        window.location.href = url;
                        return;
                    }
                },
                error: function (xhr) {
                    console.warn('AJAX page fetch error, falling back to full reload:', xhr.status);
                    window.location.href = url;
                },
                complete: function () {
                    $('.request-loader').removeClass('show');
                }
            });
        }

        // Intercept sidebar navigation clicks
        $(document).on('click', '.sidebar a[href]', function (e) {
            const href = $(this).attr('href');
            const target = $(this).attr('target');
            const hasDataToggle = $(this).attr('data-toggle') === 'collapse';

            // Skip dropdown toggles, external links, anchor hashes, or non-GET links
            if (hasDataToggle || target === '_blank' || !href || href === '#' || href.indexOf('javascript:') === 0) {
                return;
            }

            // Check if internal user dashboard URL
            try {
                const targetUrl = new URL(href, window.location.origin);
                if (targetUrl.origin !== window.location.origin) {
                    return; // External URL -> normal navigation
                }
                if (targetUrl.pathname.indexOf('/user/logout') > -1) {
                    return; // Logout -> normal navigation
                }
            } catch (err) {
                return;
            }

            e.preventDefault();

            // Set active states on sidebar
            $('.sidebar li, .sidebar .nav-item').removeClass('active');
            const $clickedLi = $(this).closest('li').addClass('active');
            const $parentNavItem = $(this).closest('.nav-item').addClass('active');

            // Keep parent collapse open
            $(this).closest('.collapse').addClass('show');

            // Center active item in sidebar
            restoreSidebarScroll($clickedLi);

            // Load page via AJAX
            loadDashboardPage(href, true);
        });

        // Handle Browser Back / Forward buttons
        window.addEventListener('popstate', function (e) {
            if (e.state && e.state.dashboardAjaxUrl) {
                loadDashboardPage(e.state.dashboardAjaxUrl, false);
                // Also update sidebar active link
                const currentPath = window.location.pathname;
                $('.sidebar a[href]').each(function () {
                    const linkHref = $(this).attr('href');
                    if (linkHref && linkHref.indexOf(currentPath) > -1) {
                        $('.sidebar li, .sidebar .nav-item').removeClass('active');
                        $(this).closest('li').addClass('active');
                        $(this).closest('.nav-item').addClass('active');
                        $(this).closest('.collapse').addClass('show');
                        restoreSidebarScroll($(this).closest('li'));
                        return false;
                    }
                });
            }
        });

        let isInitialScroll = true;
        setTimeout(function() { isInitialScroll = false; }, 1000);

        $('.sidebar a').on('click', function () {
            const $scrollElem = $sidebarWrapper.find('.scroll-content').length ? $sidebarWrapper.find('.scroll-content') : $sidebarWrapper;
            sessionStorage.setItem('userSidebarScroll', $scrollElem.scrollTop() || $sidebarWrapper.scrollTop());
        });

        $(document).on('scroll', '.sidebar-wrapper, .sidebar-wrapper .scroll-content', function () {
            if (!isInitialScroll) {
                sessionStorage.setItem('userSidebarScroll', $(this).scrollTop());
            }
        });

        setTimeout(restoreSidebarScroll, 100);
        setTimeout(restoreSidebarScroll, 350);
        setTimeout(restoreSidebarScroll, 700);
    });

    /* ***************************************************
    ==========fontawesome icon picker start==========
    ******************************************************/
    $('.icp-dd').iconpicker();

    $('.icp').on('iconpickerSelected', function (event) {
        $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
    });


    /* ***************************************************
    ==========fontawesome icon picker upload end==========
    ******************************************************/


    /* ***************************************************
    ========== tinyMCE Init start==========
    ******************************************************/
    $(".summernote").each(function (i) {
        tinymce.init({
            selector: '.summernote',
            plugins: 'autolink charmap emoticons image link lists media searchreplace table visualblocks wordcount directionality',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | ltr rtl',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            promotion: false,
            mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
            ]
        });
    });


    /* ***************************************************
    ==========tinyMCE initialization end==========
    ******************************************************/
    var tooltipTriggerList = [].slice.call($('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })



    $('.icp-dd').iconpicker();
    $('.icp').on('iconpickerSelected', function (event) {
        $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
    });


    /* ***************************************************
    ==========Summernote initialization end==========
    ******************************************************/



    /* ***************************************************
    ==========Bootstrap Notify start==========
    ******************************************************/
    function bootnotify(message, title, type) {
        var content = {};

        content.message = message;
        content.title = title;
        content.icon = 'fa fa-bell';

        $.notify(content, {
            type: type,
            placement: {
                from: 'top',
                align: 'right'
            },
            showProgressbar: true,
            time: 1000,
            allow_dismiss: true,
            delay: 4000,
        });
    }
    /* ***************************************************
    ==========Bootstrap Notify end==========
    ******************************************************/



    /* ***************************************************
    ==========Form Submit with AJAX Request Start==========
    ******************************************************/

    $("#submitBtn").on('click', function (e) {
        $(e.target).attr('disabled', true);

        $(".request-loader").addClass("show");

        let ajaxForm = document.getElementById('ajaxForm');
        let fd = new FormData(ajaxForm);
        let url = $("#ajaxForm").attr('action');
        let method = $("#ajaxForm").attr('method');

        if ($("#ajaxForm .summernote").length > 0) {
            $("#ajaxForm .summernote").each(function (i) {
                let index = i;
                let $toInput = $('.summernote').eq(index);

                let tmcId = $toInput.attr('id');
                let content = tinyMCE.get(tmcId).getContent();

                fd.delete($(this).attr('name'));
                fd.append($(this).attr('name'), content);
            });
        }

        let blob_image_url = $('#blob_image').text().trim();
        if (blob_image_url.length > 0) {
            var base64ImageContent = blob_image_url.replace(/^data:image\/(png|jpg);base64,/, "");
            var blob = base64ToBlob(base64ImageContent, 'image/png');
            fd.append('thumbnail', blob);
        }

        $.ajax({
            url: url,
            method: method,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $(e.target).attr('disabled', false);
                $(".request-loader").removeClass("show");

                $(".em").each(function () {
                    $(this).html('');
                })

                if (data.status == 'fail') {
                    $('.modal').modal('hide');
                    bootnotify(data.message, 'Warning', 'warning');
                }
                if (data == "success" || (data && data.status == "success")) {
                    $('.modal').modal('hide');
                    if (data && data.redirect) {
                        window.location.href = data.redirect;
                    } else if (data && data.url) {
                        window.location.href = data.url;
                    } else {
                        location.reload();
                    }
                }

                if (data == "downgrade") {
                    $('.modal').modal('hide');
                    "use strict";
                    var content = {};
                    content.message = downgradText;
                    content.title = WarningText;
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    $("#limitModal").modal('show');
                }

                // if error occurs
                else if (typeof data.error != 'undefined') {
                    for (let x in data) {
                        if (x == 'error') {
                            continue;
                        }
                        document.getElementById('err' + x).innerHTML = data[x][0];
                    }
                }
            },
            error: function (error) {
                $(".em").each(function () {
                    $(this).html('');
                })
                for (let x in error.responseJSON.errors) {
                    document.getElementById('err' + x).innerHTML = error.responseJSON.errors[x][0];
                }
                $(".request-loader").removeClass("show");
                $(e.target).attr('disabled', false);
            }
        });
    });

    $("#submitBtn2").on('click', function (e) {
        $(e.target).attr('disabled', true);

        $(".request-loader").addClass("show");

        let ajaxForm2 = document.getElementById('ajaxForm2');
        let fd = new FormData(ajaxForm2);
        let url = $("#ajaxForm2").attr('action');
        let method = $("#ajaxForm2").attr('method');

        if ($("#ajaxForm2 .summernote").length > 0) {
            $("#ajaxForm2 .summernote").each(function (i) {
                let index = i;
                let $toInput = $('.summernote').eq(index);

                let tmcId = $toInput.attr('id');
                let content = tinyMCE.get(tmcId).getContent();

                fd.delete($(this).attr('name'));
                fd.append($(this).attr('name'), content);
            });
        }

        $.ajax({
            url: url,
            method: method,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $(e.target).attr('disabled', false);
                $(".request-loader").removeClass("show");

                $(".em").each(function () {
                    $(this).html('');
                })

                if (data == "success" || (data && data.status == "success")) {
                    $('.modal').modal('hide');
                    if (data && data.redirect) {
                        window.location.href = data.redirect;
                    } else if (data && data.url) {
                        window.location.href = data.url;
                    } else {
                        location.reload();
                    }
                }

                // if error occurs
                else if (typeof data.error != 'undefined') {
                    for (let x in data) {
                        if (x == 'error') {
                            continue;
                        }
                        document.getElementById('err' + x).innerHTML = data[x][0];
                    }
                }
            },
            error: function (error) {

                $(".em").each(function () {
                    $(this).html('');
                })
                for (let x in error.responseJSON.errors) {
                    document.getElementById('err' + x).innerHTML = error.responseJSON.errors[x][0];
                }
                $(".request-loader").removeClass("show");
                $(e.target).attr('disabled', false);
            }
        });
    });


    $(".modal-form").on('submit', function (e) {
        e.preventDefault();

        var $form = $(this);
        var url = $form.attr('action');
        var method = $form.attr('method');
        var fd = new FormData(this);
        $(".request-loader").addClass("show");

        $.ajax({
            url: url,
            method: method,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $(".request-loader").removeClass("show");
                $(".em").each(function () {
                    $(this).html('');
                });

                if (data === "success" || (data && data.status === "success")) {
                    $('.modal').modal('hide');
                    if (data && data.redirect) {
                        window.location.href = data.redirect;
                    } else if (data && data.url) {
                        window.location.href = data.url;
                    } else {
                        location.reload();
                    }
                } else if (typeof data === 'object' && data.error) {
                    // Handle the case where `data` contains error information
                    for (var key in data.error) {
                        if (data.error.hasOwnProperty(key)) {
                            $('#err' + key).html(data.error[key][0]);
                        }
                    }
                }
            },
            error: function (xhr) {
                $(".request-loader").removeClass("show");
                $form.find('button, input[type="submit"]').attr('disabled', false);

                $(".em").each(function () {
                    $(this).html('');
                });
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    for (var key in xhr.responseJSON.errors) {
                        if (xhr.responseJSON.errors.hasOwnProperty(key)) {
                            $form.find('.err' + key).html(xhr.responseJSON.errors[key][0]);
                        }
                    }
                }
            }
        });
    });


    function base64ToBlob(base64, mime) {
        mime = mime || '';
        var sliceSize = 1024;
        var byteChars = window.atob(base64);
        var byteArrays = [];

        for (var offset = 0, len = byteChars.length; offset < len; offset += sliceSize) {
            var slice = byteChars.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        return new Blob(byteArrays, { type: mime });
    }


    // insertitem
    $('#itemForm').on('submit', function (e) {
        $('.request-loader').addClass('show');
        e.preventDefault();

        let action = $('#itemForm').attr('action');
        let fd = new FormData(document.querySelector('#itemForm'));

        let blob_image_url = $('#blob_image').text().trim();
        if (blob_image_url.length > 0) {
            var base64ImageContent = blob_image_url.replace(/^data:image\/(png|jpg);base64,/, "");
            var blob = base64ToBlob(base64ImageContent, 'image/png');
            fd.append('thumbnail', blob);
        }

        $.ajax({
            url: action,
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                $('.request-loader').removeClass('show');

                if (data == 'success') {
                    location.reload();
                }
                if (data == "downgrade") {
                    $('.modal').modal('hide');
                    "use strict";
                    var content = {};
                    content.message = downgradText;
                    content.title = WarningText;
                    content.icon = 'fa fa-bell';
                    $.notify(content, {
                        type: 'warning',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        showProgressbar: true,
                        time: 1000,
                        delay: 4000,
                    });
                    $("#limitModal").modal('show');
                }
            },
            error: function (error) {
                $('#postErrors').removeClass('d-none');
                let errors = ``;

                if (error.responseJSON && error.responseJSON.errors) {
                    for (let x in error.responseJSON.errors) {
                        let errArr = error.responseJSON.errors[x];
                        let msg = Array.isArray(errArr) ? errArr[0] : errArr;
                        errors += `<li>
              <p class="text-danger mb-0">${msg}</p>
            </li>`;
                    }
                } else if (error.responseJSON && error.responseJSON.message) {
                    errors += `<li>
              <p class="text-danger mb-0">${error.responseJSON.message}</p>
            </li>`;
                } else {
                    errors += `<li>
              <p class="text-danger mb-0">An unexpected error occurred while saving item. Please try again.</p>
            </li>`;
                }

                $('#postErrors ul').html(errors);

                $('.request-loader').removeClass('show');

                $('html, body').animate({
                    scrollTop: $('#postErrors').offset().top - 100
                }, 1000);
            }
        });
    });



    $("#permissionBtn").on('click', function () {
        $("#permissionsForm").trigger("submit");
    });

    $("#langBtn").on('click', function () {
        $("#langForm").trigger("submit");
    });
    /* ***************************************************
    ==========Form Submit with AJAX Request End==========
    ******************************************************/

    /* ***************************************************
    ==========datatables start==========
    ******************************************************/
    $('#basic-datatables').DataTable({
        responsive: true,
        ordering: false,
        "language": {
            "search": Search + ':',
            "lengthMenu": `${showText} _MENU_ ${entriesText}`,
            "info": `${Showing} _START_ ${to} _END_ ${ofText} _TOTAL_ ${entriesText}`,
            "paginate": {
                "next": nextText,
                "previous": previousText
            }
        }
    });
    /* ***************************************************
    ==========datatables end==========
    ******************************************************/


    /* ***************************************************
    ==========Form Prepopulate After Clicking Edit Button Start==========
    ******************************************************/
    $(".editbtn").on('click', function () {
        let datas = $(this).data();
        delete datas['toggle'];

        for (let x in datas) {
            if ($("#in" + x).hasClass('summernote')) {
                tinyMCE.activeEditor.setContent(datas[x])
            } else if ($("#in" + x).hasClass('image')) {
                $("#in" + x).attr('src', datas[x]);
            } else if ($("#in" + x).hasClass('jscolor')) {
                $("#in" + x).val(datas[x]);
                // Explicitly reinitialize jscolor
                const colorInput = document.getElementById("in" + x);
                if (colorInput.jscolor) {
                    colorInput.jscolor.fromString(datas[x]); // Update color picker value
                } else {
                    colorInput.jscolor = new jscolor(colorInput); // Initialize jscolor
                }
            } else if ($("#in" + x).data('role') == 'tagsinput') {
                if (datas[x].length > 0) {
                    let arr = datas[x].split(" ");
                    for (let i = 0; i < arr.length; i++) {
                        $("#in" + x).tagsinput('add', arr[i]);
                    }
                } else {
                    $("#in" + x).tagsinput('removeAll');
                }
            }
            else if ($("input[name='" + x + "']").attr('type') == 'radio') {
                $("input[name='" + x + "']").each(function (i) {
                    if ($(this).val() == datas[x]) {
                        $(this).prop('checked', true);
                    }
                });
            }
            else {
                $("#in" + x).val(datas[x]);
                if ($('#inicon').length > 0) {
                    $('#inicon').attr('class', datas['icon']);
                }
            }
        }

    });

    /* ***************************************************
    ==========Form Prepopulate After Clicking Edit Button End==========
    ******************************************************/




    /* ***************************************************
    ==========Form Update with AJAX Request Start==========
    ******************************************************/
    $("#updateBtn").on('click', function (e) {

        $(".request-loader").addClass("show");

        if ($("#ajaxEditForm .iconpicker-component").length > 0) {
            $("#editInputIcon").val($("#ajaxEditForm .iconpicker-component").find('i').attr('class'));
        }


        let ajaxEditForm = document.getElementById('ajaxEditForm');
        let fd = new FormData(ajaxEditForm);
        let url = $("#ajaxEditForm").attr('action');
        let method = $("#ajaxEditForm").attr('method');

        $('.form-control').each(function (i) {
            let index = i;
            let $toInput = $('.form-control').eq(index);

            if ($(this).hasClass('summernote')) {
                let tmcId = $toInput.attr('id');
                let content = tinyMCE.get(tmcId).getContent();
                fd.delete($(this).attr('name'));
                fd.append($(this).attr('name'), content);
            }
        });

        $.ajax({
            url: url,
            method: method,
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {

                $(".request-loader").removeClass("show");

                $(".em").each(function () {
                    $(this).html('');
                })

                if (data == "success" || (data && data.status == "success")) {
                    $('.modal').modal('hide');
                    if (data && data.redirect) {
                        window.location.href = data.redirect;
                    } else if (data && data.url) {
                        window.location.href = data.url;
                    } else {
                        location.reload();
                    }
                }

                // if error occurs
                else if (typeof data.error != 'undefined') {
                    for (let x in data) {
                        if (x == 'error') {
                            continue;
                        }
                        document.getElementById('eerr' + x).innerHTML = data[x][0];
                    }
                }
            }
        });
    });

    $(".update-btn").each(function () {
        $(this).on('click', function (e) {
            let $this = $(this);

            $(".request-loader").addClass("show");

            let formId = $(this).data('form_id');
            let ajaxEditForm = document.getElementById(formId);
            let fd = new FormData(ajaxEditForm);
            let url = $("#" + formId).attr('action');
            let method = $("#" + formId).attr('method');

            $("#" + formId + " .form-control").each(function (i) {
                let index = i;
                let $toInput = $('.form-control').eq(index);
                if ($(this).hasClass('summernote')) {
                    let tmcId = $toInput.attr('id');
                    let content = tinyMCE.get(tmcId).getContent();

                    fd.delete($(this).attr('name'));
                    fd.append($(this).attr('name'), content);
                }
            });

            $.ajax({
                url: url,
                method: method,
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    let parentCount = $this.parents('.modal').length;
                    let parentId;
                    // if the form is in modal
                    if (parentCount > 0) {
                        parentId = $this.parents('.modal').attr('id');
                    }
                    // if the form is not in modal
                    else {
                        parentId = formId;
                    }
                    $(".request-loader").removeClass("show");

                    $("#" + parentId).children(".em").each(function () {
                        $(this).html('');
                    })

                    if (data == "success") {
                        location.reload();
                    }

                    // if error occurs
                    else if (typeof data.error != 'undefined') {
                        for (let x in data) {
                            if (x == 'error') {
                                continue;
                            }
                            $("#" + parentId + " .eerr" + x).html(data[x][0]);
                        }
                    }
                }
            });
        });
    });
    /* ***************************************************
    ==========Form Update with AJAX Request End==========
    ******************************************************/



    /* ***************************************************
    ==========Delete Using AJAX Request Start==========
    ******************************************************/
    $('.deletebtn').on('click', function (e) {
        e.preventDefault();

        $(".request-loader").addClass("show");

        swal({
            title: are_you_sure,
            text: wont_revert_text,
            type: 'warning',
            buttons: {
                confirm: {
                    text: yes_delete_it,
                    className: 'btn btn-success'
                },
                cancel: {
                    text: cancel,
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                $(this).parent(".deleteform").trigger('submit');
            } else {
                swal.close();
                $(".request-loader").removeClass("show");
            }
        });
    });
    /* ***************************************************
    ==========Delete Using AJAX Request End==========
    ******************************************************/

    /* ***************************************************
    ========== Set Currency Default Alert ==========
    ******************************************************/
    $('.DefaultBtn').on('click', function (e) {
        e.preventDefault();

        $(".request-loader").addClass("show");

        swal({
            title: are_you_sure,
            text: default_currency_msg,
            type: 'warning',
            buttons: {
                confirm: {
                    text: yes,
                    className: 'btn btn-success'
                },
                cancel: {
                    text: cancel,
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                $(this).parent(".DefaultForm").trigger('submit');
            } else {
                swal.close();
                $(".request-loader").removeClass("show");
            }
        });
    });
    /* ***************************************************
    ========== Set Currency Default Alert End ==========
    ******************************************************/


    /* ***************************************************
    ==========Close Ticket Using AJAX Request Start==========
    ******************************************************/
    $('.close-ticket').on('click', function (e) {
        e.preventDefault();

        $(".request-loader").addClass("show");

        swal({
            title: 'Are you sure?',
            text: "You want to close this ticket!",
            type: 'warning',
            buttons: {
                confirm: {
                    text: 'Yes, close it!',
                    className: 'btn btn-success'
                },
                cancel: {
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                swal.close();
                $(".request-loader").removeClass("show");
            } else {
                swal.close();
                $(".request-loader").removeClass("show");
            }
        });
    });
    /* ***************************************************
    ==========Delete Using AJAX Request End==========
    ******************************************************/


    /* ***************************************************
    ==========Delete Using AJAX Request Start==========
    ******************************************************/
    $(document).on('change', '.bulk-check', function () {
        let val = $(this).data('val');
        let checked = $(this).prop('checked');

        // if selected checkbox is 'all' then check all the checkboxes
        if (val == 'all') {
            if (checked) {
                $(".bulk-check").each(function () {
                    $(this).prop('checked', true);
                });
            } else {
                $(".bulk-check").each(function () {
                    $(this).prop('checked', false);
                });
            }
        }


        // if any checkbox is checked then flag = 1, otherwise flag = 0
        let flag = 0;
        $(".bulk-check").each(function () {
            let status = $(this).prop('checked');

            if (status) {
                flag = 1;
            }
        });

        // if any checkbox is checked then show the delete and processing buttons
        if (flag == 1) {
            $(".bulk-delete").addClass('d-inline-block');
            $(".bulk-delete").removeClass('d-none');
            $(".bulk-processing").addClass('d-inline-block');
            $(".bulk-processing").removeClass('d-none');
        }
        // if no checkbox is checked then hide them
        else {
            $(".bulk-delete").removeClass('d-inline-block');
            $(".bulk-delete").addClass('d-none');
            $(".bulk-processing").removeClass('d-inline-block');
            $(".bulk-processing").addClass('d-none');
        }
    });

    $('.bulk-delete').on('click', function () {

        swal({
            title: are_you_sure,
            text: wont_revert_text,
            type: 'warning',
            buttons: {
                confirm: {
                    text: yes_delete_it,
                    className: 'btn btn-success'
                },
                cancel: {
                    text: cancel,
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Delete) => {
            if (Delete) {
                $(".request-loader").addClass('show');
                let href = $(this).data('href');
                let ids = [];

                // take ids of checked one's
                $(".bulk-check:checked").each(function () {
                    if ($(this).data('val') != 'all') {
                        ids.push($(this).data('val'));
                    }
                });

                let fd = new FormData();
                for (let i = 0; i < ids.length; i++) {
                    fd.append('ids[]', ids[i]);
                }

                $.ajax({
                    url: href,
                    method: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {

                        $(".request-loader").removeClass('show');
                        if (data == "success") {
                            location.reload();
                        }
                    }
                });
            } else {
                swal.close();
            }
        });

    });

    $('.bulk-processing').on('click', function () {

        swal({
            title: are_you_sure,
            text: "You want to process all selected orders and send them to Shiprocket?",
            type: 'warning',
            buttons: {
                confirm: {
                    text: "Yes, process!",
                    className: 'btn btn-success'
                },
                cancel: {
                    text: cancel,
                    visible: true,
                    className: 'btn btn-danger'
                }
            }
        }).then((Process) => {
            if (Process) {
                $(".request-loader").addClass('show');
                let href = $(this).data('href');
                let ids = [];

                // take ids of checked one's
                $(".bulk-check:checked").each(function () {
                    if ($(this).data('val') != 'all') {
                        ids.push($(this).data('val'));
                    }
                });

                let fd = new FormData();
                for (let i = 0; i < ids.length; i++) {
                    fd.append('ids[]', ids[i]);
                }

                $.ajax({
                    url: href,
                    method: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $(".request-loader").removeClass('show');
                        location.reload();
                    },
                    error: function() {
                        $(".request-loader").removeClass('show');
                        location.reload();
                    }
                });
            } else {
                swal.close();
            }
        });

    });
    /* ***************************************************
    ==========Delete / Bulk Processing Using AJAX Request End==========
    ******************************************************/


    //  image (id) preview js/
    $(document).on('change', '#image', function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.showImage img').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    })

    $(document).on('change', '#image2', function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.showImage2 img').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    })
    $(document).on('change', '#image3', function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.showImage3 img').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    })
    $(document).on('change', '#image4', function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.showImage4 img').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    })
    $(document).on('change', '#image5', function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.showImage5 img').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    })
    $(document).on('change', '#image6', function (event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.showImage6 img').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    })

    //  image (class) preview js/


    //date & time picker here
    $(".flatpickr").flatpickr({
        enableTime: true,
        noCalendar: true,
        allowInput: true,
        dateFormat: shopSetting == 12 ? 'h:i K' : 'H:i',
        time_24hr: shopSetting == 12 ? false : true,
        minuteIncrement: 1,
        static: true
    });
    $(".datepicker").flatpickr({
        enableTime: false,
        noCalendar: false,
        allowInput: true,
        static: true
    });


    // select2
    if ($('.select2').length > 0) {
        $('.select2').select2();
    }
});

// Delete Using AJAX Request Start
$('.deleteBtn').on('click', function (e) {
    e.preventDefault();
    $(".request-loader").addClass("show");

    swal({
        title: are_you_sure,
        text: wont_revert_text,
        type: 'warning',
        buttons: {
            confirm: {
                text: yes_delete_it,
                className: 'btn btn-success'
            },
            cancel: {
                visible: true,
                className: 'btn btn-danger'
            }
        }
    }).then((Delete) => {
        if (Delete) {
            $(this).parent(".deleteForm").submit();
        } else {
            swal.close();
            $(".request-loader").removeClass("show");
        }
    });
});
// Delete Using AJAX Request End


// In your Javascript (external .js resource or <script> tag)
$(document).ready(function () {
    $('.select2').select2();

    $(".category-template-select").on('change', function () {

        var categoryId = $(this).data('category_id');
        let val = $(this).val();

        if (val == 1) {
            $("#categorytemplateModal" + categoryId).modal('show');
        }

        $(`#categorytemplateModal${categoryId} input[name='template']`).val(val);
        if (val == 0) {
            $(`#categorytemplateForm${categoryId}`).trigger('submit');
        }
    });

    $(document).on('focusin', function (e) {
        if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .tam-assetmanager-root").length) {
            e.stopImmediatePropagation();
        }
    });

    // Convert SVG QR code downloads to PNG on the fly
    $(document).on('click', 'a.qr-download, #downloadBtn', function (e) {
        let href = $(this).attr('href');
        if (href && href.indexOf('.svg') !== -1) {
            e.preventDefault();
            let filename = $(this).attr('download') || 'qr-code.png';
            if (filename.indexOf('.svg') !== -1) {
                filename = filename.replace(/\.svg/g, '.png');
            }
            
            let image = new Image();
            image.crossOrigin = 'anonymous';
            image.onload = function() {
                let canvas = document.createElement('canvas');
                canvas.width = image.naturalWidth || image.width || 300;
                canvas.height = image.naturalHeight || image.height || 300;
                let ctx = canvas.getContext('2d');
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(image, 0, 0);
                
                let a = document.createElement('a');
                a.download = filename;
                a.href = canvas.toDataURL('image/png');
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            };
            image.src = href;
        }
    });
});
