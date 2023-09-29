! function($, window, e) {
    "use strict";
    var filename    =   'jollyany_package_'+Math.random().toString(36).substring(7);
    var progress    =   $('<div/>', {"class": 'progress'}),
        progressbar =   $('<div/>', {
            "class" :   'progress-bar progress-bar-striped progress-bar-animated',
            "role"  :   'progressbar',
            "aria-valuenow"  :   '0',
            "aria-valuemin"  :   '0',
            "aria-valuemax"  :   '100',
            "style"  :   'width: 0%'
        }),
        textStatus  =   $('<div/>', {
            "class" :   'text-muted'
        });
    progress.append(progressbar);
    if (TZ_LOGO_IMG) {
        $('#astroid-sidebar-wrapper .logo-image').empty().html('<img style="vertical-align: baseline;" src="../templates/'+TZ_TEMPLATE_NAME+'/images/logo-admin.png" alt="'+TZ_TEMPLATE_NAME+'" />');
    }
    var resetProgress = function () {
        progressbar.attr('aria-valuenow',0).css('width', '0%');
        progressbar.addClass('progress-bar-animated').addClass('progress-bar-striped');
    };
    var actionDownloadPackage = function (request, button, dialogPopup) {
        $.ajax({
            url    : 'index.php?t='+Math.random().toString(36).substring(7),
            type   : 'POST',
            data   : request,
            beforeSend: function(){
                textStatus.html('<i class="far fa-compass fa-spin"></i> Downloading Package...');
            },
            success: function (response) {
                if (response.status === 'success') {
                    progressbar.attr('aria-valuenow',(request['step']*100)/response.pathcount).css('width', (request['step']*100)/response.pathcount+'%');
                    if (response.pathcount <= request['step']) {
                        textStatus.text('Package download completed!');
                        request['archive']      = response.archive;
                        request['jollyany']     = 'unzip_package';
                        actionUnzipPackage(request, button, dialogPopup);
                    } else {
                        request['step']++;
                        actionDownloadPackage(request, button, dialogPopup);
                    }
                } else {
                    dialogPopup.find('.dialogDebug').text(response.message);
                    button.find('i').remove();
                    button.removeAttr('disabled','');
                }
            }
        });
    };
    var actionUnzipPackage  =   function (request, button, dialogPopup) {
        $.ajax({
            url    : 'index.php?t='+Math.random().toString(36).substring(7),
            type   : 'POST',
            data   : request,
            beforeSend: function(){
                textStatus.html('<i class="far fa-compass fa-spin"></i> Unzip Package...');
            },
            success: function (response) {
                if (response.status === 'success') {
                    textStatus.text('Package unzip completed!');
                    request['package']      = response.package;
                    textStatus.html('<i class="far fa-compass fa-spin"></i> Redirect to install page...');
                    window.onbeforeunload = null;
                    window.location.href = response.url_root;
                } else {
                    dialogPopup.find('.dialogDebug').text(response.message);
                    button.find('i').remove();
                    button.removeAttr('disabled','');
                }
            }
        });
    };
    var getExtInfo  =   function (request, dialogPopup) {
        $.ajax({
            url    : 'index.php?t='+Math.random().toString(36).substring(7),
            type   : 'POST',
            data   : request,
            beforeSend: function(){
                dialogPopup.find('.extensions-container').html('<i class="far fa-compass fa-spin"></i> Get package data...');
            },
            success: function (response) {
                if (response.status === 'success') {
                    var $data       =   $.parseJSON(response.data),
                        $exts       =   dialogPopup.find('.extensions-container');
                    $exts.empty();
                    for (var i = 0; i<$data.length; i ++) {
                        var extension   =   $('<div/>', {"class": 'form-group form-check pl-4'}),
                            checkbox    =   $('<input/>', {
                                "class" :   'form-check-input extension-item',
                                "type"  :   'checkbox',
                                "id"    :   'extension-'+i,
                                "value" :   i
                            }),
                            label       =   $('<label/>', {
                                "class" :   'form-check-label',
                                "for"   :   'extension-'+i
                            });
                        label.append('<h6>'+$data[i].name+'</h6>');
                        extension.append(checkbox).append(label);
                        $exts.append(extension);
                    }
                } else {
                    dialogPopup.find('.dialogDebug').text(response.message);
                }
            }
        });
    };
    var getDataPackage  =   function (request, button, dialogPopup) {
        $.ajax({
            url    : 'index.php?t='+Math.random().toString(36).substring(7),
            type   : 'POST',
            data   : request,
            beforeSend: function(){
                textStatus.html('<i class="far fa-compass fa-spin"></i> Get package data...');
            },
            success: function (response) {
                if (response.status === 'success') {
                    request['jollyany']     =   'install_package';
                    actionInstallPackage(request, button, dialogPopup, 0, $.parseJSON(response.data));
                } else {
                    dialogPopup.find('.dialogDebug').text(response.message);
                    button.find('i').remove();
                    button.removeAttr('disabled','');
                }
            }
        });
    };
    var actionInstallPackage    =   function (request, button, dialogPopup, index, data) {
        if (index<data.length) {
            var extension   =   data[index];
            request['extension']    =   JSON.stringify(extension);
            $.ajax({
                url    : 'index.php?t='+Math.random().toString(36).substring(7),
                type   : 'POST',
                data   : request,
                beforeSend: function(){
                    textStatus.html('<i class="far fa-compass fa-spin"></i> Installing: '+extension.name+'...');
                },
                success: function (response) {
                    if (response.status === 'success') {
                        progressbar.attr('aria-valuenow',((index+1)*100)/data.length).css('width', ((index+1)*100)/data.length+'%');
                        textStatus.html('<i class="far fa-smile"></i> '+extension.name+' installed!');
                        actionInstallPackage(request, button, dialogPopup, index+1, data);
                    } else {
                        dialogPopup.find('.dialogDebug').append('<br />+'+response.message);
                        button.find('i').remove();
                        button.removeAttr('disabled','');
                    }
                }
            });
        } else {
            button.find('i').remove();
            button.removeAttr('disabled','');
            progressbar.removeClass('progress-bar-animated').removeClass('progress-bar-striped');
            textStatus.html('<i class="far fa-smile"></i> All extensions has installed!');
            var req = {};
            req[dialogPopup.find('.install-action').data('token')]      =   1;
            req['code']     =   dialogPopup.find('.install-action').data('file');
            req['jollyany'] =   'get_version';
            req['option']   =   'com_ajax';
            $.ajax({
                url    : 'index.php?t='+Math.random().toString(36).substring(7),
                type   : 'POST',
                data   : req,
                success: function (response) {
                    if (response.status === 'success') {
                        if (response.type === 'extension') {
                            $('.card.'+response.element).find('.version').empty().text(response.data);
                        } else {
                            if ($('.card.'+response.element).find('.card-title').find('.badge').length) {
                                $('.card.'+response.element).find('.card-title').find('.badge').empty().text(response.data);
                            } else {
                                $('.card.'+response.element).find('.card-title').append(' <span class="badge badge-pill badge-primary">'+response.data+'</span>')
                            }
                        }
                    }
                }
            });
        }
    };
    $(document).ready(function() {
        var popup, timeInterval, templatejson = null,
            btn_active = $("#jollyany-theme-activate"),
            template = $("#jollyany-form-data-json");
        if (template.length) try {
            templatejson = JSON.parse(template.html()), template.html("")
        } catch (window) {}
        if (null != templatejson) {
            var doc = $("<html>"),
                head = $("<head>"),
                body = $("<body>");
            doc.append(head).append(body);
            var style = $("<link>").attr({
                rel: "stylesheet",
                href: templatejson.api + "/components/com_tz_envato_license/css/style.css"
            });
            head.append(style), head.append("<title>Jollyany &ndash; Product Activation</title>");
            var form = $('<form style="display:none;">').attr({
                action: templatejson.api+'/index.php?option=com_tz_envato_license&view=activation',
                method: "POST",
                enctype: "multipart/form-data",
                id: "jollyany-activate-product-form",
                acceptCharset: "ISO-8859-1"
            }).append('<div class="jollyany-activation-loading"><div class="jollyany-activation-loading-content"><h2>Please wait&hellip;</h2><p>You will be redirected to Envato website in few seconds</p></div></div>');
            for (var jsonelement in templatejson) $("<input>").attr({
                type: "hidden",
                name: jsonelement,
                value: templatejson[jsonelement]
            }).appendTo(form);
            body.append(form);
            var browser = function() {
                var userAgent = window.navigator.userAgent,
                    n = userAgent.indexOf("MSIE ");
                if (n > 0) return parseInt(userAgent.substring(n + 5, userAgent.indexOf(".", n)), 10);
                if (userAgent.indexOf("Trident/") > 0) {
                    var a = userAgent.indexOf("rv:");
                    return parseInt(userAgent.substring(a + 3, userAgent.indexOf(".", a)), 10)
                }
                var o = userAgent.indexOf("Edge/");
                return o > 0 && parseInt(userAgent.substring(o + 5, userAgent.indexOf(".", o)), 10)
            }();
            browser && (form.attr("target", "jollyanyProductActivationWindow"), form.appendTo($(document.body)));
            btn_active.on("click", function(a) {
                a.preventDefault();
                var html = doc.clone(),
                    forminside = html.find("form"),
                    maxheight = 600,
                    minheight = browser ? 550 : 350,
                    screenW = screen.width / 2 - 300,
                    screenH = screen.height / 2 - minheight / 2;
                popup = window.open("", "jollyanyProductActivationWindow", "width=600, height=" + minheight + ", top=" + screenH + ", left=" + screenW);
                browser ? form.submit() : $(popup.document.body).append(html);
                popup ? browser || html.find("link").on("load", function() {
                    forminside.show(), setTimeout(function() {
                        minheight = 800, popup.resizeTo(maxheight, minheight), popup.moveBy(0, -200);
                        forminside.submit();
                    }, 1100)
                }) : alert("Your browser is blocking popups, activation process cannot continue!");
                window.clearInterval(timeInterval), timeInterval = setInterval(function() {
                    if (browser) {
                        try {
                            popup.parent
                        } catch (e) {
                            window.clearInterval(timeInterval), window.location.reload()
                        }
                    } else popup.parent || (window.clearInterval(timeInterval), window.location.reload())
                }, 300);
            });
        }
        $(".delete-template-activation").on("click", function(t) {
            var token   =   $(this).data('token'),
                $this   =   $(this);
            if (confirm("Are you sure you want to delete template activation?")) {
                var request = {};
                request[token] = 1;
                request['jollyany'] = 'deactivate';
                request['option'] = 'com_ajax';
                $.ajax({
                    url    : 'index.php?t='+Math.random().toString(36).substring(7),
                    type   : 'POST',
                    data   : request,
                    beforeSend: function(){
                        $this.find('i').addClass('fa-spin');
                    },
                    success: function (response) {
                        $this.find('i').removeClass('fa-spin');
                        if (response.status === 'success') {
                            window.location.reload();
                        } else {
                            $this.appendText(JSON.stringify(response));
                        }
                    }
                });
                return 1;
            }
        });
        if ($('#astroid-page-jollyanyexts .as-group-content').length) {
            var dialogExtPopup         =   $('#install-ext-dialog'),
                dialogExtTemplate      =   $('#jollyany-dialog-extension');

            $('.intall-extension').on('click', function (e) {
                e.preventDefault();
                var thisLink    =   $(this);
                if (thisLink.data('status') === 0) {
                    alert('Your license is invalid or expired! You need buy or renew your license to use this premium feature!');
                } else {
                    dialogExtPopup.html(dialogExtTemplate.html());
                    dialogExtPopup.find('.extension-name').text(thisLink.data('name'));
                    dialogExtPopup.find('.install-action').attr('data-file',thisLink.data('file'));
                    dialogExtPopup.modal('show');
                    dialogExtPopup.find('.install-action').on('click', function (e) {
                        var request = {},
                            $this   = $(this);
                        request['install_code']         =   $this.data('file');
                        request['option']               =   'com_ajax';
                        request[$this.data('token')]    = 1;
                        request['file_name']            = filename;
                        request['step']                 = 1;
                        request['jollyany']             = 'get_extension_package';
                        $this.attr('disabled','disabled');
                        $this.prepend('<i class="fas fa-spinner fa-pulse"></i>');
                        dialogExtPopup.find('.dialogDebug').html('');
                        resetProgress();
                        dialogExtPopup.find('.dialogDebug').append(progress).append(textStatus);
                        textStatus.text('<i class="far fa-compass fa-spin"></i> Preparing to download package...');
                        getDataPackage(request, $this, dialogExtPopup);
                        return 1;
                    });
                }
            });

            dialogExtPopup.on('hidden.bs.modal', function (e) {
                $(this).empty();
            })
        }
        if ($('#astroid-form-fieldset-section-presets .astroid-form-fieldset-section').length) {
            var presetContainer    =   $('#astroid-form-fieldset-section-presets .astroid-form-fieldset-section');
            presetContainer.find(".form-group > .row > *[class^='col-sm-']").attr('class','col-12 col-sm-12');
            $('#jollyany-save-preset').on('click', function (e) {
                e.preventDefault();
                if ($('#jollyany-preset-name').val() === '') {
                    alert('Please insert name of preset!');
                    $('#jollyany-preset-name').focus();
                    return false;
                }
                $('#jollyany-preset').val(1);
                $('#jollyany-template').val(TZ_TEMPLATE_NAME);
                $('#astroid-form').submit();
                window.onbeforeunload = null;
                window.location.reload();
                return false;
            });

            $('.jollyany-load-preset').on('click', function (e) {
                e.preventDefault();
                var token   =   $(this).data('token'),
                    $this   =   $(this);
                if (confirm("Your current configure will be lost and overwritten by new data. Are you sure?")) {
                    var request = {};
                    request[token]      =   1;
                    request['name']     =   $this.data('name');
                    request['template'] =   TZ_TEMPLATE_NAME;
                    request['jollyany'] =   'loadpreset';
                    request['option']   =   'com_ajax';
                    $.ajax({
                        url    : 'index.php?t='+Math.random().toString(36).substring(7),
                        type   : 'POST',
                        data   : request,
                        beforeSend: function(){
                            $this.attr('disabled','disabled');
                            $this.prepend('<i class="fas fa-spinner fa-pulse"></i>');
                        },
                        success: function (response) {
                            $this.removeAttr('disabled','');
                            $this.find('i').remove();
                            if (response.status === 'success') {
                                var _json = Admin.checkUploadedSettings(response.data);
                                if (_json !== false) {
                                    Admin.saveImportedSettings(_json);
                                }
                            }
                        }
                    });
                }
                return 1;
            });

            $('.jollyany-del-preset').on('click', function (e) {
                var token   =   $(this).data('token'),
                    $this   =   $(this);
                if (confirm("This preset will be deleted! Are you sure?")) {
                    var request = {};
                    request[token]      =   1;
                    request['name']     =   $this.data('name');
                    request['template'] =   TZ_TEMPLATE_NAME;
                    request['jollyany'] =   'removepreset';
                    request['option']   =   'com_ajax';
                    $.ajax({
                        url    : 'index.php?t='+Math.random().toString(36).substring(7),
                        type   : 'POST',
                        data   : request,
                        success: function (response) {
                            window.onbeforeunload = null;
                            window.location.reload();
                        }
                    });
                }
                return 1;
            })
        }
        if ($('#astroid-page-jollyanyimport .as-group-content').length) {
            var dialogPopup     =   $('#install-package-dialog'),
                dialogTemplate  =   $('#jollyany-dialog-template');
            
            $('.intall-package').on('click', function (e) {
                e.preventDefault();
                var thisLink    =   $(this);
                if (thisLink.data('status') === 0) {
                    alert('Your license is invalid or expired! You need buy or renew your license to use this premium feature!');
                } else {
                    dialogPopup.html(dialogTemplate.html());
                    dialogPopup.find('.package-name').text(thisLink.data('name'));
                    dialogPopup.find('.install-action').attr('data-file',thisLink.data('file'));
                    dialogPopup.find('h5, small').each(function (i, el) {
                        var text = $(this).text();
                        text = text.replace("##templatename##", thisLink.data('name'));
                        $(this).text(text);
                    });
                    var request = {};
                    request['install_code']     =   thisLink.data('file');
                    request['option']           =   'com_ajax';
                    request['jollyany']         =   'get_extensions_data';
                    request[thisLink.data('token')]    = 1;
                    getExtInfo(request, dialogPopup);
                    dialogPopup.modal('show');

                    $('#demo-data-package').on('change', function() {
                        if(this.checked) {
                            dialogPopup.find('.db_info').show();
                        } else {
                            dialogPopup.find('.db_info').hide();
                        }
                    });

                    $('.install-action').on('click', function (e) {
                        var request = {},
                            $this   = $(this),
                            exts    = new Array();
                        dialogPopup.find('.extension-item').each(function (i, el) {
                            if ($(el).is(':checked')) {
                                exts.push($(el).val());
                            }
                        });
                        request[$this.data('token')]    = 1;
                        request['option']               = 'com_ajax';
                        request['extension-package']    = exts;
                        request['template-package']     = $('#template-package:checked').length;
                        request['demo-data-package']    = $('#demo-data-package:checked').length;
                        request['file_name']            = filename;
                        request['step']                 = 1;
                        request['install_code']         = $this.data('file');
                        if ($('#demo-data-package:checked').length) {
                            if (confirm("Your current data will be lost and overwritten by new content. Are you sure?")) {
                                request['jollyany']          = 'download_package';
                                $this.attr('disabled','disabled');
                                $this.prepend('<i class="fas fa-spinner fa-pulse"></i>');
                                dialogPopup.find('.dialogDebug').html('');
                                resetProgress();
                                dialogPopup.find('.dialogDebug').append(progress).append(textStatus);
                                textStatus.text('<i class="far fa-compass fa-spin"></i> Preparing to download package...');
                                actionDownloadPackage(request, $this, dialogPopup);
                            } else {
                                return 1;
                            }
                        } else {
                            request['jollyany']          = 'get_package_data';
                            $this.attr('disabled','disabled');
                            $this.prepend('<i class="fas fa-spinner fa-pulse"></i>');
                            dialogPopup.find('.dialogDebug').html('');
                            resetProgress();
                            dialogPopup.find('.dialogDebug').append(progress).append(textStatus);
                            textStatus.text('<i class="far fa-compass fa-spin"></i> Preparing to download package...');
                            getDataPackage(request, $this, dialogPopup);
                        }
                        return 1;
                    });
                }
            });

            dialogPopup.on('hidden.bs.modal', function (e) {
                $(this).empty();
                // $(this).find('.install-action').attr('data-file','').removeAttr('disabled','').find('i').remove();
                // $(this).find('.dialogDebug').html('');
                // $(this).find('#demo-data-package').prop("checked", false);
            })
        }
        if (tzthumbs_cache.length) {
            var request = {};
            request[tztoken]        =   1;
            request['jollyany']     =   'cache_thumb';
            request['option']       =   'com_ajax';
            request['thumbs']       =   tzthumbs_cache;
            $.ajax({
                url    : 'index.php?t='+Math.random().toString(36).substring(7),
                type   : 'POST',
                data   : request
            });
        }
    })
}(jQuery, window);