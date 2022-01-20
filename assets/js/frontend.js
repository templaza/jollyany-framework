jQuery(function($){
    var updateHikashopCart = function () {
        if ($(".jollyany-hikacart").length){
            var hikacart_quantity = 0;
            $('#jollyany-hikacart-content .hikashop_cart_module tbody tr').find('input.hikashop_product_quantity_field').each(function (i, el) {
                hikacart_quantity   +=  parseInt($(el).val());
            });
            if (hikacart_quantity>0) {
                $('.jollyany-hikacart-icon > i').html('<span class="cart-count">'+hikacart_quantity+'</span>');
            } else {
                $('.jollyany-hikacart-icon > i').empty();
            }
        }
    };
    $(document).ready(function(){
        if ($('.logo-wrapper').length) {
            $('.logo-wrapper img').each(function (i, el){
                if ($(el).attr('src') && $(el).attr('src').substr( ($(el).attr('src').lastIndexOf('.') +1) ) === 'svg') {
                    $(el).attr('uk-svg','');
                }
            });
        }
        var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        if (isSafari) {
            $('picture').each(function (i, el){
                if ($(el).find('img').data('origin')) {
                    $(el).find('img').attr('data-src',$(el).find('img').data('origin'));
                }
            });
        }
        if ($('#astroid-preloader').length && $('#jollyany-preloader-logo-template').length && !$('#astroid-preloader .jollyany-preloader-logo').length) {
            $('#astroid-preloader').prepend($('#jollyany-preloader-logo-template').html());
        }
        if ($(".jollyany-hikacart").length){
            var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

            $.fn.attrchange = function(callback) {
                if (MutationObserver) {
                    var options = {
                        subtree: false,
                        attributes: true
                    };

                    var observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(e) {
                            callback.call(e.target, e.attributeName);
                        });
                    });

                    return this.each(function() {
                        observer.observe(this, options);
                    });
                }
            }
            $('#jollyany-hikacart-content .hikashop_cart').attrchange(function(attrName) {
                if(attrName=='class'){
                    updateHikashopCart();
                }
            });
            $(".jollyany-hikacart-icon").on("click", function(e){
                e.preventDefault();
            });
            $(".jollyany-hikashop-atc").on('click', function (e){
                UIkit.modal('#jollyany-hikacart-content').show();
            });
            if (!$('body').hasClass('com-hikashop')) {
                $('#jollyany-hikacart-content').find('form').submit();
            }
            updateHikashopCart();
        }
        if ($(".hikashop_listing_img_hover_slider").length) {
            $(".hikashop_listing_img_hover_slider").hover( function() {
                UIkit.slideshow($(this).find(".uk-slideshow")).startAutoplay();
            });
            $(".hikashop_listing_img_hover_slider").mouseleave( function() {
                UIkit.slideshow($(this).find(".uk-slideshow")).stopAutoplay();
            });
        }
        if ($(".jollyany-login").length){
            $(".jollyany-login-icon").on("click", function(e){
                e.preventDefault();
            });
        }
        if ($('#astroid-header').length && $('#astroid-header').hasClass('has-sidebar') && $('#jollyany-sidebar-collapsed-logo-template').length && !$('#astroid-header .astroid-sidebar-collapsed-logo').length) {
            $('#astroid-header').find('.astroid-sidebar-collapsable').after($('#jollyany-sidebar-collapsed-logo-template').html());
        }
        if ($('.jollyany-course-contact-form').length) {
            $(document).on('submit', '.jollyany-course-contact-form' , function (e) {
                e.preventDefault();
                var request = {},
                    $this   = $(this);
                request['data'] = $this.serializeArray();
                request['option'] = 'com_ajax';
                request['jollyany'] = 'course_contact_form';
                request[$this.find('.token').attr('name')] = 1;
                $.ajax({
                    type   : 'POST',
                    data   : request,
                    beforeSend: function(){
                        $this.find('.jollyany-ajax-contact-status').empty()
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            $this.find('.jollyany-ajax-contact-status').append('<div class="uk-alert-success" uk-alert><a class="uk-alert-close" uk-close></a><p>'+response.message+'</p></div>');
                            $this.find('.uk-input').val('');
                            $this.find('.uk-textarea').val('');
                        } else {
                            $this.find('.jollyany-ajax-contact-status').append('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a><p>'+JSON.stringify(response)+'</p></div>');
                        }
                    }
                });
            });
        }
        var ajaxCourseContent = function ($this, $request) {
            $.ajax({
                type   : 'POST',
                data   : $request,
                beforeSend: function(){
                    $this.find('.jollyany-course-lesson-detail').empty()
                },
                success: function (response) {
                    if (response.status == 'success') {
                        $this.find('.jollyany-course-lesson-detail').append(response.data);
                    } else {
                        $this.find('.jollyany-course-lesson-detail').append('<div class="uk-alert-danger" uk-alert><a class="uk-alert-close" uk-close></a><p>'+JSON.stringify(response)+'</p></div>');
                    }
                }
            });
        }
        if ($('.jollyany-course-table').length) {
            UIkit.util.on('.jollyany-course-detail', 'show', function () {
                var request = {},
                    $this   = $(this);
                request['id'] = $this.data('id');
                request['cid'] = $this.data('cid');
                request['option'] = 'com_ajax';
                request['jollyany'] = 'course_get_data';
                request[$this.data('token')] = 1;
                $this.find('.jollyany-course-table-content').empty().html($('#jollyany-course-table-content-template').html()).find('.jollyany-course-modal-detail').on('click', function (e){
                    e.preventDefault();
                    request['id'] = $(this).data('id');
                    request['cid'] = $(this).data('cid');
                    ajaxCourseContent($this, request);
                });
                ajaxCourseContent($this, request);
            });
        }
    });
});