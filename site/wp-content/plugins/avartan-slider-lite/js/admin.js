            /**
             * Allow to write only integer
             * 
             * @param {object} character code
             * 
             * @return {boolean} status of key valid or not
            */
            function isNumberKey(evt)
            {
                var event = (evt) ? evt : window.event;
                var charCode = (event.which) ? event.which : event.keyCode;
                if (charCode > 31 && (charCode < 37 || charCode > 40) && (charCode < 48 || charCode > 57) && charCode != 127)
                {
                    return false;
                }
                else
                {
                    return true;
                }

            }
            /**
             * Not allow any special character except underscore and minus
             * 
             * @param {object} character code
             * 
             * @return {boolean} status of key valid or not
            */
            function isNotSpecialChar(e)
            {
                var regex = new RegExp(/^[!~`"'?,|;:><@#\$%\^\&*\)\(\[\]\{\}\\\/+=.]+$/g);
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (!regex.test(str)) {
                    return true;
                }

                e.preventDefault();
                return false;

            }
(function($) {
    
    //Window Load Event
    $(window).load(function() {
            
         /********************************/
        /**  BACKEND GENERAL SETTINGS  **/
        /*******************************/
        
         //GLOBAL VARIABLE
        var loadWin = 1;
           
       
        //Display slider screen after load and hide loader
        $('.as-slider-wrapper').show();
        $('.as-admin-preloader').hide();
        
        //Run tabs
        $('.as-tabs').tabs({
                history: true,
                show: function(event, ui) {
                        var $target = $(ui.panel);
                        if(target.hasClass('as-tabs-fade')) {
                                $('.content:visible').effect(
                                        'explode',
                                        {},
                                        1500,
                                        function(){
                                                $target.fadeIn(300);
                                        }
                                );
                        }
                }
        });
        
        //Display success message block
        function  avartansliderShowMsg(msg,type) {
            if($.trim(msg)!=''){
                $.bootstrapGrowl($.trim(msg), {
                ele: 'body', // which element to append to
                type: type, // (null, 'info', 'error', 'success')
                offset: {from: 'top', amount: 50}, // 'top', or 'bottom'
                align: 'right', // ('left', 'right', or 'center')
                width: 350, // (integer, or 'auto')
                delay: 8000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
                allow_dismiss: true, // If true then will display a cross to close the popup.
                stackup_spacing: 10 // spacing between consecutively stacked growls.
              });
              $("html, body").animate({ scrollTop: 0 }, "slow");
          }
        }
         
        /***********************/
        /**  SLIDER SETTINGS  **/
        /***********************/
        
        //check this feature available for pro version only
        $('.as-admin').on('click', '.as-pro-version', function() {
            var html = avartanslider_translations.slider_pro_version;
            html += '<a href="https://www.solwininfotech.com/product/wordpress-plugins/avartan-slider/" target="_blank" class="as-plugin-buy-now-msg">'+avartanslider_translations.upgrade_pro+'</a>';
            avartansliderShowMsg(html,'danger');
        });
        
        //Set alias, shortcode and php function
        $('.as-slider').find('#as-slider-name').on('blur',function() {
                var alias = avartansliderGetAlias();
                var shortcode = "[avartanslider alias='" + alias + "']";
                var phpfunction = "if(function_exists('avartanslider')) avartanslider('" + alias + "');";
                $('.as-slider').find('#as-slider-alias').val(alias);
                $('.as-slider').find('#as-slider-shortcode').val(shortcode);
                $('.as-slider').find('#as-slider-php-function').val(phpfunction);
        });

        //Get the alias starting form the name
        function  avartansliderGetAlias() {
                var slider_name = $('.as-slider').find('#as-slider-name').val();
                var slider_alias = slider_name.toLowerCase();
                slider_alias = slider_alias.replace(/ /g, '_');
                return slider_alias;
        }

        //Select slider setting tab to display slider setting block
        $('.as-admin').on('click', '.as-slider-setting-tab', function() {
            if(typeof $(this).attr('data-slider-tab') !== "undefined" && $(this).attr('data-slider-tab') !== '') {
                $('.as-slider-setting-tab').removeClass('as-is-active');
                $(this).addClass('as-is-active');
                $('.as-slider-setting-block').hide();
                $($(this).attr('data-slider-tab')).css('display','table');
                $('.as-reset-slider-settings').attr('data-reset-block',$(this).attr('data-slider-tab'));
            }
        });

        //Set active class to current clicked button
        $('.as-admin').on('click', '.as-slider-tabs a', function() {
            $('.as-slider-tabs').find('a').removeClass('as-is-active');
            $(this).addClass('as-is-active');
        });
        
        //Select slider setting inner tab to display inner block
        $('.as-admin').on('click', '.as-inner-tab', function() {
            $(this).closest('.as-inner-menu').find('.as-inner-tab').removeClass('as-active');
            $(this).addClass('as-active');
            $(this).closest('.as-inner-container').find('.as-inner-table').hide();
            $($(this).attr('data-href')).css('display','table');
        });

        //Call editor resizing function on change slider layout
        $('.as-admin').on('change', '#as-slider-layout', function() {
            avartansliderSetSlidesEditingAreaSizes();
            if($(this).val() == 'full-width') {
                $('.as-full-width-block').css('display','table-row');
            }
            else {
                $('.as-full-width-block').hide();
            }
        });
        
        //Call editor resizing function on change slider width   
        $('.as-admin').on('keyup change click', '#as-slider-startWidth', function() {
            avartansliderSetSlidesEditingAreaSizes();
        });
        
        //Call editor resizing function on change slider Height
        $('.as-admin').on('keyup change click', '#as-slider-startHeight', function() {
            avartansliderSetSlidesEditingAreaSizes();
        });
        
        //Toggle options based on request
        $('.as-admin').on('change', '.as-toggle-options', function() {
           if($(this).val() == 1) {
               if($(this).closest('form').length > 0) {
                    $($(this).closest('form').find($(this).attr('data-option'))).show();
                    
               } else {
                    $($(this).attr('data-option')).show();
               }
               
           } 
           else {
               if($(this).closest('form').length > 0) {
                    $($(this).closest('form').find($(this).attr('data-option'))).hide();
                    
               } else {
                    $($(this).attr('data-option')).hide();
               }
           }
        });
        
        //Intialize color picker 
        $('.as-admin .as-slider #as-slider-settings .ad-s-setting-content .as-slider-background-type-color-picker-input').wpColorPicker({
                // a callback to fire whenever the color changes to a valid color
                change: function(event, ui){
                        // Change only if the color picker is the user choice
                },
                // a callback to fire when the input is emptied or an invalid color
                clear: function() {},
                // hide the color picker controls on load
                hide: true,
                // show a group of common colors beneath the square
                // or, supply an array of colors to customize further
                palettes: true
        });
        
        //Set Radio on click of Slider colorpicker container
        $('.as-admin #as-slider-settings .as-slider-settings-wrapper .as-slider-setting-block .wp-picker-container').on('click',function() {  
                $(this).closest('.as-content').find('#as-slider-background-type-color').val(1);
        });
        
        //Set background color (transparent or color-picker)
        $('.as-admin #as-slides').on('change', '.as-slider-settings-wrapper #as-slider-background-type-color', function() {
               var btn = $(this);

               if(btn.val() == '0') {
                       btn.closest('.as-content').find('.as-slider-background-type-color-picker-input').val('');
               }
        });   
        
        //Select option for shadow
        $('.as-admin .as-slider').on('change', '#as-slider-settings .ad-s-setting-content #as-slider-shadow-type', function() {
            if($(this).val() == 1){
                $('.as-shadow-list-wrapper').show();
            }
            else
            {
                $('.as-shadow-list-wrapper').hide();
            }
        });

        //Set default shadow
        $('.as-admin .as-slider').on('click', '#as-slider-settings .as-slider-default-shadow', function(event) {
            if($(this).closest('.as-content').find('#as-slider-shadow-type').val() == 1)
            {
                if($('.as-shadow-list-wrapper').css('display') == 'none')
                {
                    $('.as-default-option-wrapper').hide();
                    $('.as-shadow-list-wrapper').show();
                }
                else
                {
                    $('.as-shadow-list-wrapper').hide();    
                }
            }
            else
            {
                $(this).closest('.as-content').find('#as-slider-shadow-type').val(1);
                $(this).closest('.as-content').find('#as-slider-shadow-type').trigger('change');
            }
        });

        //Select deault shadow from given list
        $('.as-admin .as-slider').on('click', '#as-slider-settings .as-shadow-list tr td', function() {
            $('.as-shadow-list tr td').removeClass('active');
            $(this).addClass('active');
            var image_class = $(this).find('img').attr('data-shadow-class');

            $(this).closest('.as-content').find('.as-slider-default-shadow').attr('data-shadow-class',image_class);
        });
        
        //Select option for loader
        $('.as-admin .as-slider').on('change', '#as-slider-settings .ad-s-setting-content #as-slider-loaderType', function() {
            if($(this).val() == 0){
                $('.as-loader-list-wrapper').show();
                $('.as-loader-img-block').hide();
                $('.as-loader-def-block').show();
            }
            else
            {
                $('.as-loader-def-block').hide();    
                $('.as-loader-img-block').show();
                $('.as-slider-default-loader').attr('data-loader-style','loader1');
                $('.as-loader-list td').removeClass('active');
                $('.as-loader-list td:eq(0)').addClass('active');
                $('.as-loader-list-wrapper').hide();
            }
        });

        //Set default loader image
        $('.as-admin .as-slider').on('click', '#as-slider-settings .as-slider-default-loader', function(event) {
            if($('#as-slider-loaderType').val() == 0)
            {
                if($('.as-loader-list-wrapper').css('display') == 'none')
                {
                    $('.as-default-option-wrapper').hide();
                    $('.as-loader-list-wrapper').show();
                }
                else
                {
                    $('.as-loader-list-wrapper').hide();    
                }
            }
            else
            {
                $('#as-slider-loaderType').val(0);
                $('#as-slider-loaderType').trigger('change');
            }
        });


        //Select deault loader from given list
        $('.as-admin .as-slider').on('click', '#as-slider-settings .as-loader-list tr td', function() {
            $('.as-loader-list tr td').removeClass('active');
            $(this).addClass('active');
            var image_class = $(this).find('img').attr('data-loader-style');

            $(this).closest('.as-content').find('.as-slider-default-loader').attr('data-loader-style',image_class);
        });
		
        //Check whether to display control list or not
        $('.as-admin .as-slider').on('change', '#as-slider-settings #as-slider-enableArrows', function() {
            if($(this).val() == 1){
                $('.as-arrows-block').show();
            }
            else
            {
                $('.as-arrows-block').hide();
            }
        });

        //Set default controls image
        $('.as-admin .as-slider').on('click', '#as-slider-settings .as-slider-default-arrows', function() {
            if($('.as-arrows-list-wrapper').css('display') == 'none')
            {
                $('.as-default-option-wrapper').hide();
                $('.as-arrows-list-wrapper').show();
            }
            else
            {
                $('.as-arrows-list-wrapper').hide();    
            }
        });

        //Select deault controls from given list
        $('.as-admin .as-slider').on('click', '#as-slider-settings .as-arrows-list tr td', function() {
            $('.as-arrows-list tr td').removeClass('active');
            $(this).addClass('active');
            var image_class = $(this).find('img').attr('data-arrows-style');

            $(this).closest('.as-content').find('.as-slider-default-arrows').attr('data-arrows-style',image_class);
        });

        //Check whether to display navigation list or not
        $('.as-admin .as-slider').on('change', '#as-slider-settings #as-slider-enableBullets', function() {
            if($(this).val() == 1){
                $('.as-navbullets-block').show();
            }
            else
            {
                $('.as-navbullets-block').hide();
            }
        });

        //Set default navigation image
        $('.as-admin .as-slider').on('click', '#as-slider-settings .as-slider-default-bullets', function(event) {
            if($('.as-bullets-list-wrapper').css('display') == 'none')
            {
                $('.as-default-option-wrapper').hide();
                $('.as-bullets-list-wrapper').show();
            }
            else
            {
                $('.as-bullets-list-wrapper').hide();    
            }
        });

        //Select deault navigation from given list
        $('.as-admin .as-slider').on('click', '#as-slider-settings .as-bullets-list tr td', function() {
            $('.as-bullets-list tr td').removeClass('active');
            $(this).addClass('active');
            var image_class = $(this).find('img').attr('data-bullets-style');

            $(this).closest('.as-content').find('.as-slider-default-bullets').attr('data-bullets-style',image_class);
        });        
            
        /**********************/
        /** SLIDES SETTINGS **/
        /********************/
	
        //Sticky save slide button
        $(document).on("scroll",function() {
            if($('.as-save-slide').length > 0) {
            var saveBtn = $('.as-save-slide'),
                objSlide = $('.as-slides-list'),
                objSlideOffset = objSlide.offset().top,
                doc_scroll = $(document).scrollTop();
                
                if (objSlideOffset - doc_scroll < 35) 
                        saveBtn.addClass("sticky");
                else
                        saveBtn.removeClass("sticky");
                }

        })
            
        var slides_number = $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').length - 1;
        // Run sortable
        var slide_before; // Contains the index before the sorting
        var slide_after; // Contains the index after the sorting
            
        //Set sortable
        $('.as-slide-tabs .as-sortable').sortable({
                items: 'li:not(.ui-state-disabled)',
                cancel: '.ui-state-disabled',

                // Store the actual index
                start: function(event, ui) {
                        slide_before = $(ui.item).index();
                },

                // Change the .as-slide order based on the new index and rename the tabs
                update: function(event, ui) {
                        // Store the new index
                        slide_after = $(ui.item).index();

                        // Change the slide position
                        var slide = $('.as-admin #as-slides .as-slides-list .as-slide:eq(' + slide_before + ')');			
                        var after = $('.as-admin #as-slides .as-slides-list .as-slide:eq(' + slide_after + ')');			
                        if(slide_before < slide_after) {
                                slide.insertAfter(after);
                        }
                        else {
                                slide.insertBefore(after);
                        }

                        // Rename all the tabs
                        $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').each(function() {
                                var temp = $(this);
                                if(!temp.find('a').hasClass('as-add-new')) {
                                        temp.find('a').find('.as-slide-index').html((temp.index() + 1));
                                }
                        });
                        avartansliderUpdateSlidePos();
                }
        });
        $('.as-slide-tabs .as-sortable li').disableSelection();
		
        //Show the slide when clicking on the link
        $('.as-admin #as-slides').on('click', '.as-slide-tabs ul.as-sortable li a',function () {
                $('.as-live-preview').each(function(){
                    var btn = $(this)
                    var slide_parent = btn.closest('.as-slide');
                    if(btn.hasClass('as-live-preview-running')) {
                        btn.removeClass('as-live-preview-running');
                        btn.html('<span class="dashicons dashicons-search"></span>');
                        avartansliderStopLivePreview(slide_parent);
                    }
                });
                // Do only if is not click add new
                if($(this).parent().index() != slides_number) {
                        // Hide all tabs
                        $('.as-admin #as-slides .as-slides-list .as-slide').css('display', 'none');
                        var tab = $(this).parent().index();
                        $('.as-admin #as-slides .as-slides-list .as-slide:eq(' + tab + ')').css('display', 'block');

                        // Active class
                        $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').removeClass('active');
                        $(this).parent().addClass('active');

                        if(!$(this).hasClass('as-add-new')){
                            $('.as-slide-tab').find('a').removeClass('as-is-active');
                            $(this).addClass('as-is-active');
                        }
                }
        });
            
        //Show the slide when clicking on the link
        $('.as-admin #as-slides').on('click', '.as-element-pro-tab ul.as-element-pro-tab-ul li a',function () {
                var slide_parent = $(this).closest('.as-slide');
                $(slide_parent).find('.as-element-type-block').hide();
                $(slide_parent).find('li').removeClass('active');
                $(slide_parent).find('li').find('a').removeClass('as-is-active');
                $(slide_parent).find($(this).attr('data-href')).show();
                $(this).parent().addClass('active');
                $(this).addClass('as-is-active');
        });
            
        //On load check which tab is selected then assign active class
         if(window.location.hash) {
            //set the value as a variable, and remove the #
            var hash_value = window.location.hash;
            $('.as-slider-tabs li').find('a').each(function(){
                if($(this).attr('href') == $.trim(hash_value)){
                    $('.as-slider-tabs li').find('a').removeClass('as-is-active');
                    $(this).addClass('as-is-active');
                }
            });

        }
        
        //Add slide new on click
        $('.as-admin #as-slides .as-add-new').click(function() {
                avartansliderAddSlide();
        });	
            
        //Also add a new slide if slides_number == 0
        if(slides_number == 0) {
                avartansliderAddSlide();
        }
        else {
                $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').eq(0).find('a').click();
        }
		
        //Add new slide
        function  avartansliderAddSlide() {

            var add_btn = $('.as-admin #as-slides .as-add-new');

            $('.as-slide-tab').find('a').removeClass('as-is-active');

            var void_slide = $('.as-admin #as-slides .as-void-slide').html();
            // Insert the link at the end of the list
            var html = '';
                html += '<li class="ui-state-default">';
                html += '<a class="as-button as-is-navy as-is-active">';
                html += '<span class="dashicons dashicons-visibility as-visibility as-publish as-is-temp-disabled as-pro-version"></span>';
                html += '<span class="as-slide-name">#<span class="as-slide-index">' + (slides_number + 1) + '</span> <span class="as-slide-name-val">'+avartanslider_translations.slide + '</span></span>';
                html += '<span class="dashicons dashicons-dismiss as-close"></span>';
                html += '</a></li>';
                add_btn.parent().before(html);

            // jQuery UI tabs are not working here. For now, just use a manual created tab
//                    $('.as-admin #as-slides .as-slide-tab').tabs('refresh');
            // Create the slide
            $('.as-admin #as-slides .as-slides-list').append('<div class="as-slide">' + void_slide + '</div>');
            slides_number++;

            // Open the tab just created
            var tab_index = add_btn.parent().index() - 1;
            $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').eq(tab_index).find('a').click();

            // Active class
            $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').removeClass('active');
            $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').eq(tab_index).addClass('active');

            // Set editing area sizes
            avartansliderSetSlidesEditingAreaSizes();

            avartansliderSlidesColorPicker();
            $('.as-admin #as-slides .as-slides-list .as-slide .ad-s-setting-content .as-slide-settings-list .wp-picker-container').on('click',function() {  
                loadWin = 0;
                if($(this).closest('form').hasClass('as-pro-version')){
                    avartansliderShowMsg(avartanslider_translations.slider_pro_version,'danger');
                }
            });
        }
        
        //Delete slide
        $('.as-admin #as-slides').on('click', '.as-slide-tabs ul.as-sortable li .as-close',function (event) {
                var del_slide_index = $(this).closest('li').index();
                var del_slide_id = $('.as-slide:eq('+del_slide_index+')').find('.as-save-slide').attr('data-slide-id');
                if($('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').length <= 2) {
                        avartansliderShowMsg(avartanslider_translations.slide_delete_just_one,'danger');
                        return;
                }

                var confirm = window.confirm(avartanslider_translations.slide_delete_confirm);
                if(!confirm) {
                        return;
                }

                slides_number--;

                var slide_index = $(this).closest('li').index();

                $(this).closest('li').remove();
                // Remove the slide itself
                $('.as-admin #as-slides .as-slides-list .as-slide').eq(slide_index).remove();

                // Scale back all the slides text
                for(var i = slide_index; i < slides_number; i++) {
                        var slide = $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').eq(i);
                        var indx = parseInt(slide.find('.as-slide-index').text());
                        slide.find('.as-slide-index').text(indx - 1);
                }


                $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').removeClass('active');
                $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li').eq(0).addClass('active');

                $('.as-slide-tab').find('a').removeClass('as-is-active');
                $('.as-admin #as-slides .as-slide-tabs ul.as-sortable li:eq(0) a').addClass('as-is-active');
                $('.as-admin #as-slides .as-slides-list .as-slide').css('display', 'none');
                $('.as-admin #as-slides .as-slides-list .as-slide').eq(0).css('display', 'block');		

                avartansliderDeleteSlide(del_slide_id);
        });
        
        //Intialize background color picker
        function  avartansliderSlidesColorPicker() {
            //Background Color Picker
            $('.as-admin #as-slides .as-slides-list .as-slide-settings-list .as-slide-background-type-color-picker-input').wpColorPicker({
                    // a callback to fire whenever the color changes to a valid color
                    change: function(event, ui){
                        if(loadWin == 0) {
                            // Change only if the color picker is the user choice
                            var container = $(this).closest('.as-slide');
                            if (container.find('.as-slide-background-type-color').val() == 1) {
                                var area = container.find('.as-elements .as-editor-wrapper');
                                area.css('background', ui.color.toString() );    
                            }
                        }    
                    },
                    // a callback to fire when the input is emptied or an invalid color
                    clear: function() {
                            var container = $(this).closest('.as-slide');
                            if (container.find('.as-slide-background-type-color').val() == 1) {
                                var area = container.find('.as-elements .as-editor-wrapper');
                                area.css('background', 'rgba(0,0,0,0)');    
                            }
                    },
                    // hide the color picker controls on load
                    hide: true,
                    // show a group of common colors beneath the square
                    // or, supply an array of colors to customize further
                    palettes: true
            });

            //Color overlay on background image    
            $('.as-admin #as-slides .as-slides-list .as-slide-settings-list .as-slide-background-color-overlay-picker-input').wpColorPicker({
                    // a callback to fire whenever the color changes to a valid color
                    change: function(event, ui){

                    },
                    // a callback to fire when the input is emptied or an invalid color
                    clear: function() {
                    },
                    // hide the color picker controls on load
                    hide: true,
                    // show a group of common colors beneath the square
                    // or, supply an array of colors to customize further
                    palettes: true
            });
        }
        
        //Call Slide color picker intialization        
        avartansliderSlidesColorPicker();
        
        //Set Radio button of bgcolor when color picker container clicked
        $('.as-admin #as-slides .as-slides-list .as-slide .ad-s-setting-content .as-slide-settings-list .wp-picker-container').on('click',function() {  
            loadWin = 0;
            $(this).closest('.as-content').find('.as-slide-background-type-color').val(1);
            if($(this).closest('form').hasClass('as-pro-version')){
                avartansliderShowMsg(avartanslider_translations.slider_pro_version,'danger');
            }
        });
        
        //Set background color (transparent or color-picker)
        $('.as-admin #as-slides').on('change', '.as-slides-list .as-slide-settings-list .as-slide-background-type-color', function() {
                var btn = $(this);
                var area = btn.closest('.as-slide').find('.as-elements .as-editor-wrapper');

                if(btn.val() == '0') {
                        area.css('background-color', 'rgba(0,0,0,0)');
                        btn.closest('form').find('.as-slide-background-type-color-picker-input').val('rgba(0,0,0,0)');
                }
                else {
                    var color_picker_value = btn.closest('.as-content').find('.as-slide-background-type-color-picker-input').val();
                    area.css('background-color', color_picker_value);
                }
        }); 

        //Set background image (none or image)
        $('.as-admin #as-slides').on('change', '.as-slides-list .as-slide-settings-list .as-slide-background-type-image', function() {
                var btn = $(this);
                var area = btn.closest('.as-slide').find('.as-elements .as-editor-wrapper');

                if(btn.val() == '0') {
                        area.css('background-image', 'none');
                }
                else {
                        var slide_parent = $(this).closest('.as-slide');
                        avartansliderAddSlideImageBackground(slide_parent);
                }
        });

        //Set Background image (the upload function)
        $('.as-admin #as-slides').on('click', '.as-slides-list .as-slide-settings-list .as-slide-background-type-image-upload-button', function() {
                var btn = $(this);
                if(btn.closest('.as-content').find('.as-slide-background-type-image').val() == '1') {
                        var slide_parent = $(this).closest('.as-slide');
                        avartansliderAddSlideImageBackground(slide_parent);
                }
                else
                {
                    btn.closest('.as-content').find('.as-slide-background-type-image').val(1);
                    btn.closest('.as-content').find('.as-slide-background-type-image').trigger('change');
                }
        });

        /**
         * upload slider background image
         * 
         * @param {object} slider_parent parent object
        */
        function  avartansliderAddSlideImageBackground(slide_parent) {
                var area = slide_parent.find('.as-editor-wrapper');

                // Upload
                var file_frame;

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                  file_frame.open();
                  return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                  title: jQuery( this ).data( 'uploader_title' ),
                  button: {
                        text: jQuery( this ).data( 'uploader_button_text' ),
                  },
                  multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                  // We set multiple to false so only get one image from the uploader
                  attachment = file_frame.state().get('selection').first().toJSON();

                  // Do something with attachment.id and/or attachment.url here
                  var image_src = attachment.url;

                  // Set background
                  area.css('background-image', 'url("' + image_src + '")');
                  // I add a data with the src because, is not like images (when there is only the src link), the background contains the url('') string that is very annoying when we will get the content
                  area.attr('data-background-image-src', image_src);

                    setSlideBackgroundPos(slide_parent);
                    setSlideBackgroundRepeats(slide_parent);
                    setSlideBackgroundSize(slide_parent);
                });

                // Finally, open the modal
                file_frame.open();	
        }

        //Operation for background position
        $('.as-admin #as-slides').on('change', '.as-slides-list .as-slide-settings-list .as-slide-background-position', function () {
            var slide_parent = $(this).closest('.as-slide');

            if ($(this).val() == 'percentage') {
                slide_parent.find(".as-background-position").show();
            } else {
                slide_parent.find(".as-background-position").hide();
                slide_parent.find(".as-background-position").val('0');
            }

            setSlideBackgroundPos(slide_parent);
        });

        //Background property: positions x and y 
        $('.as-admin #as-slides').on('keyup change click', '.as-slides-list .as-slide-settings-list .as-background-position', function () {
            var slide_parent = $(this).closest('.as-slide');
            setSlideBackgroundPos(slide_parent);
        });

        /*
         * Set Background image
         * 
         * @param {object} slide_parent
         * 
         * @returns {undefined}
         */
        function setSlideBackgroundPos(slide_parent){
            var area = slide_parent.find('.as-editor-wrapper');

            var slide_bg_pos = slide_parent.find('.as-slide-background-position').val();
            if (slide_bg_pos == 'percentage') {
                slide_bg_pos = $.trim(slide_parent.find(".as-slide-background-position-x").val()) + '% ' + $.trim(slide_parent.find(".as-slide-background-position-y").val()) + '%';
            }

            area.css('background-position', slide_bg_pos);
        }

        //Operation for background repeat
        $('.as-admin #as-slides').on('change', '.as-slides-list .as-slide-settings-list .as-slide-background-repeat', function () {
            var slide_parent = $(this).closest('.as-slide');
            setSlideBackgroundRepeats(slide_parent);
        });

        /*
         * Set Background Repeats
         * 
         * @param {object} slide_parent
         * 
         * @returns {undefined}
         */
        function setSlideBackgroundRepeats(slide_parent){
            var area = slide_parent.find('.as-editor-wrapper');
            var slide_bg_repeat = slide_parent.find('.as-slide-background-repeat').val();

            area.css('background-repeat', slide_bg_repeat);
        }

        //Operation for background repeat
        $('.as-admin #as-slides').on('change', '.as-slides-list .as-slide-settings-list .as-slide-background-property-size', function () {
            var slide_parent = $(this).closest('.as-slide');

            var slide_background = $(this).val();
            slide_parent.find(".as-background-size").val('100');
            if (slide_background == 'percentage') {
                slide_parent.find(".as-background-size").show();
            } else {
                slide_parent.find(".as-background-size").hide();
            }

            setSlideBackgroundSize(slide_parent);
        });

        //Background property: size x and y 
        $('.as-admin #as-slides').on('keyup change click', '.as-slides-list .as-slide-settings-list .as-background-size', function () {
            var slide_parent = $(this).closest('.as-slide');
            setSlideBackgroundSize(slide_parent);
        });

        /*
         * Set Background Repeats
         * 
         * @param {object} slide_parent
         * 
         * @returns {undefined}
         */
        function setSlideBackgroundSize(slide_parent){
            var area = slide_parent.find('.as-editor-wrapper');
            var slide_background = slide_parent.find('.as-slide-background-property-size').val();

            if(slide_background == 'percentage') {
                slide_background = $.trim(slide_parent.find('.as-slide-background-size-x').val()) + '% ' + $.trim(slide_parent.find('.as-slide-background-size-y').val()) + '%';
            }

            area.css('background-size', slide_background);
        }
        
        //Apply custom CSS
        $('.as-admin #as-slides').on('keyup', '.as-slides-list .as-slide-settings-list .as-slide-custom-css', function() {
                var text = $(this);
                var area = text.closest('.as-slide').find('.as-elements .as-editor-wrapper');
                var css = text.val();

                // Save current styles
                var width = area.css('width');
                var height = area.css('height');
                var background_image = area.css('background-image');
                var background_color = area.css('background-color');
                var background_position = area.css('background-position');
                var background_repeat = area.css('background-repeat');
                var background_size = area.css('background-size');

                // Apply CSS
                area.attr('style', css);
                area.css({
                        'width' : width,
                        'height' : height,
                        'background-image' : background_image,
                        'background-color' : background_color,
                        'background-position' : background_position,
                        'background-repeat' : background_repeat,
                        'background-size' : background_size
                });
        });	
        
        /************************/
        /** ELEMENTS SETTINGS **/
        /**********************/
        
        //EDITOR ACTIONS
            
        //Set correct size for the editing area
        function  avartansliderSetSlidesEditingAreaSizes() {
            var layout = $('.as-admin #as-slider-settings .as-slider-settings-wrapper #as-slider-layout').val();
            var width = parseInt($('.as-admin #as-slider-settings .as-slider-settings-wrapper #as-slider-startWidth').val());
            var height = parseInt($('.as-admin #as-slider-settings .as-slider-settings-wrapper #as-slider-startHeight').val());

            var ewp = $('.as-wrapper').width();

            $('.as-admin #as-slides .as-slide .as-slide-editing-area').css({
                    'width' : width,
                    'height' : height,
            });
            if(layout == 'full-width'){
                if($('.as-admin #as-slides .as-slide .as-slide-editing-area').hasClass('fixed')){
                    $('.as-admin #as-slides .as-slide .as-slide-editing-area').removeClass('fixed');
                }
                if(width >= ewp){
                    $('.as-admin #as-slides .as-slide .as-slide-editing-area').addClass('fixed');
                }
                else {
                    width = '100%';
                }
            }
            else{
                if(!$('.as-admin #as-slides .as-slide .as-slide-editing-area').hasClass('fixed')){
                    $('.as-admin #as-slides .as-slide .as-slide-editing-area').addClass('fixed');
                }
            }
            $('.as-admin #as-slides .as-slide .as-editor-wrapper').css({
                    'width' : width,
                    'height' : height,
            });
        }
        
        //Call Editing Area size function
        avartansliderSetSlidesEditingAreaSizes();
        
        //DRAGGABLE ELEMENTS
        
        //Make draggable
        function  avartansliderDraggableElements() {
                $('.as-admin .as-elements .as-element').draggable({
                        'containment' : 'parent',

                        start: function() {
                                // Select when dragging
                                avartansliderSelectElement($(this));
                        },

                        drag: function(){
                                // Set left and top positions on drag to the textbox
                                var position = $(this).position();
                                var left = position.left;
                                var top = position.top;
                                var index = $(this).index();

                                if($(this).hasClass('as-text-element'))
                                {
                                    $(this).css({
                                        width : 'auto',
                                        height : 'auto'
                                    });
                                }   

                                $(this).closest('.as-elements').find('.as-elements-list .as-element-settings:eq(' + index + ') .as-element-data-left').val(left);
                                $(this).closest('.as-elements').find('.as-elements-list .as-element-settings:eq(' + index + ') .as-element-data-top').val(top);
                                $(this).attr('data-left', left);                            
                                $(this).attr('data-top', top);   
                            }        
                });
        }
        
        //Run draggables
        avartansliderDraggableElements();
        
        //SELECT ELEMENT
        /**
         * Selects an element, shows its options and makes the delete element button available
         * 
         * @param {object} element selected element object
        */
        function  avartansliderSelectElement(element) {
                var index = element.index();
                var slide = element.closest('.as-slide');		
                var options = slide.find('.as-elements .as-elements-list');

                // Hide all options - .active class
                options.find('.as-element-settings').css('display', 'none');
                options.find('.as-element-settings').removeClass('active');

                // Show the correct options + .active class
                options.find('.as-element-settings:eq(' + index + ')').css('display', 'block');
                options.find('.as-element-settings:eq(' + index + ')').addClass('active');
                options.find('.as-element-settings:eq(' + index + ')').find('.as-element-type-block').hide();
                options.find('.as-element-settings:eq(' + index + ')').find('.as-element-pro-tab-ul li:nth-child(1) a').trigger('click');

                // Add .active class to the element in the editing area
                element.parent().children().removeClass('active');
                element.addClass('active');

                // Make the delete and the duplicate buttons working
                slide.find('.as-elements-actions .as-delete-element').removeClass('as-is-disabled');
                slide.find('.as-elements-actions .as-duplicate-element').removeClass('as-is-disabled');

                $(element).closest('.as-elements').find('.as-ele-time').find('.as-ele-list').removeClass('active');
                $(element).closest('.as-elements').find('.as-ele-time').find('.as-ele-list:eq(' + index + ')').addClass('active');
        }
		
           
        //call select element function
        $('.as-admin #as-slides').on('click', '.as-slide .as-elements .as-slide-editing-area .as-element', function(e) {
                // Do not click the editing-area
                e.stopPropagation();

                // Do not open links
                e.preventDefault();

                avartansliderSelectElement($(this));
        });   
		
        //DESELECT ELEMENTS
        
        //Call Deselect elements
        $('.as-admin').on('click', '.as-slide .as-elements .as-editor-wrapper', function() {
                avartansliderDeselectElements();
        });

        //Deselect elements function
        function  avartansliderDeselectElements() {
                $('.as-admin .as-slide .as-elements .as-slide-editing-area .as-element').removeClass('active');
                $('.as-admin .as-slide .as-elements .as-elements-list .as-element-settings').removeClass('active');		
                $('.as-admin .as-slide .as-elements .as-elements-list .as-element-settings').css('display', 'none');		

                // Hide delete and duplicate element btns
                $('.as-admin .as-slide .as-elements-actions .as-delete-element').addClass('as-is-disabled');
                $('.as-admin .as-slide .as-elements-actions .as-duplicate-element').addClass('as-is-disabled');
        } 
        
        //ELEMENT EDITOR ACTIONS 
            
        //Hide and show layer menu
        $('.as-admin #as-slides').on('mouseenter mousemove', '.as-layer-menu',function() {
               $(this).find('ul').show();
        });
        
        $('.as-admin #as-slides').on('mouseleave', '.as-layer-menu', function() {
            $(this).find('ul').hide();
        });   
            
        //DUPLICATE ELEMENT
        
        /**
         * Duplicate the selected element
         * 
         * @param {object} element selected element object
        */
        function  avartansliderDuplicateElement(element) {

                var index = element.index();
                var slide_parent = element.closest('.as-slide');

                element.clone().appendTo(element.parent());
                var element_options = slide_parent.find('.as-elements-list .as-element-settings').eq(index);
                element_options.clone().insertBefore(element_options.parent().find('.as-void-text-element-settings'));

                avartansliderDeselectElements();

                avartansliderSelectElement(element.parent().find('.as-element').last());

                // Clone fixes (Google "jQuery clone() bug")
                var cloned_options = element.parent().find('.as-element').last().closest('.as-slide').find('.as-elements-list .as-element-settings.active');

                cloned_options.find('.as-element-data-in').val(element_options.find('.as-element-data-in').val());
                cloned_options.find('.as-element-data-out').val(element_options.find('.as-element-data-out').val());
                cloned_options.find('.as-element-custom-css').val(element_options.find('.as-element-custom-css').val());			
                if(element_options.hasClass('as-image-element-settings')) {
                        cloned_options.find('.as-image-element-upload-button').data('src', element_options.find('.as-image-element-upload-button').data('src'));	
                        cloned_options.find('.as-image-element-upload-button').data('alt', element_options.find('.as-image-element-upload-button').data('alt'));	
                }

                var prev_layer_class = element.closest('.as-slide').find('.as-ele-list:eq(' + index + ')').attr('class');
                var prev_layer_type = element.closest('.as-slide').find('.as-ele-list:eq(' + index + ')').find('.as-ele-title').find('span.fa').attr('class');
                var prev_layer_name = element.closest('.as-slide').find('.as-ele-list:eq(' + index + ')').find('.as-ele-title').find('span.as-ele-heading').html();
                var prev_delay_time = element.closest('.as-slide').find('.as-ele-list:eq(' + index + ')').find('.as-delay-ele').val();
                var prev_easein = element.closest('.as-slide').find('.as-ele-list:eq(' + index + ')').find('.as-easein-ele').val();
                var prev_easeout = element.closest('.as-slide').find('.as-ele-list:eq(' + index + ')').find('.as-easeout-ele').val();
                var prev_zindex = element.closest('.as-slide').find('.as-ele-list:eq(' + index + ')').find('.as-z-index-ele').val();
                if(!element.closest('.as-slide').find('.as-ele-list:eq(' + index + ')').hasClass('active')){
                    prev_layer_class = prev_layer_class+' active';
                }
                if(slide_parent.find('.as-ele-time tbody').find('tr.as-no-record').length > 0){
                    slide_parent.find('.as-ele-time tbody').html('');
                }
                var ele_html = avartansliderGetEleTimingBlock(prev_layer_class, prev_layer_type, prev_layer_name, prev_delay_time, prev_easein, prev_easeout, prev_zindex);
                slide_parent.find('.as-ele-time tbody').append(ele_html);

                // Make draggable
                avartansliderDraggableElements();
                
        }
        
        //By click on Duplicate element button to call deulicate element function
        $('.as-admin #as-slides').on('click', '.as-slide .as-elements .as-elements-actions .as-duplicate-element', function() {
                // Click only if an element is selected
                if($(this).hasClass('as-is-disabled')) {
                        return;
                }

                var slide_parent = $(this).closest('.as-slide');
                var element = slide_parent.find('.as-elements .as-slide-editing-area .as-element.active');
                avartansliderDuplicateElement(element);
        });
        
        //DELETE ELEMENT
        /**
         * Delete element. Remember that the button should be enabled / disabled somewhere else
         * 
         * @param {object} element selected element object
        */
        function  avartansliderDeleteElement(element) {
                var index = element.index();
                var slide_parent = element.closest('.as-slide');

                element.closest('.as-slide').find('.as-ele-time').find('.as-ele-list:eq('+ index +')').remove();

                element.remove();
                var element_options = slide_parent.find('.as-elements-list .as-element-settings:eq(' + index + ')');
                element_options.remove();

                //Set the disable class for Delete all Element
                if(slide_parent.find('.as-slide-editing-area .as-element').length == 0){
                    if(!slide_parent.find('.as-elements-actions .as-delete-all-element').hasClass('as-is-disabled'))
                    {
                        slide_parent.find('.as-elements-actions .as-delete-all-element').addClass('as-is-disabled');
                    }    
                }
                avartansliderDeselectElements();

        }
        
        //By click on delete element call delete element function
        $('.as-admin #as-slides').on('click', '.as-slide .as-elements .as-elements-actions .as-delete-element', function() {
                // Click only if an element is selected
                if($(this).hasClass('as-is-disabled')) {
                        return;
                }
                var confirm = window.confirm(avartanslider_translations.ele_del_confirm);
                if(!confirm) {
                        return;
                }
                var slide_parent = $(this).closest('.as-slide');
                var element = slide_parent.find('.as-elements .as-slide-editing-area .as-element.active');
                avartansliderDeleteElement(element);

        });
        
        //DELETE ALL ELEMENT
        
        //By click on delete all element call delete element function
        $('.as-admin #as-slides').on('click', '.as-slide .as-elements .as-elements-actions .as-delete-all-element', function() {
                // Click only if an element is selected
                if($(this).hasClass('as-is-disabled')) {
                        return;
                }
                
                var confirm = window.confirm(avartanslider_translations.ele_del_all_confirm);
                if(!confirm) {
                        return;
                }

                var slide_parent = $(this).closest('.as-slide');
                var elements = slide_parent.find('.as-elements .as-slide-editing-area .as-element');
                $(elements).each(function(){
                    var element = $(this);
                    avartansliderDeleteElement(element);
                });

                slide_parent.find('.as-ele-time tbody').append('<tr class="as-no-record"><td colspan="6" align="center">'+avartanslider_translations.element_no_found_txt+'</td></tr>');


        });
        
        //ELEMENT TIMING BLOCK
        
        //Display Element Timing block
        $('.as-admin').on('click', '.as-ele-time-btn', function () {
            var slide_parent = $(this).closest('.as-slide');
            slide_parent.find('.as-ele-time').fadeIn();
        });

        //Hide Element Timing block
        $('.as-admin').on('click', '.as-close-block', function () {
            $(this).parent().fadeOut();
        });

        //Change delay time layer wise
        $('.as-admin').on('keyup', '.as-elements .as-ele-time .as-delay-ele', function() {
                var index = $(this).closest('.as-ele-list').index();
                var delay_element = $(this).closest('.as-elements').find('.as-elements-list .as-element-settings:eq(' + index + ')').find('.as-element-data-delay');
                delay_element.val($(this).val());
        });

        //Change Ease In layer wise
        $('.as-admin').on('keyup', '.as-elements .as-ele-time .as-easein-ele', function() {
                var index = $(this).closest('.as-ele-list').index();
                var easein_element = $(this).closest('.as-elements').find('.as-elements-list .as-element-settings:eq(' + index + ')').find('.as-element-data-easeIn');
                easein_element.val($(this).val());
        });

        //Change Ease Out layer wise
        $('.as-admin').on('keyup', '.as-elements .as-ele-time .as-easeout-ele', function() {
                var index = $(this).closest('.as-ele-list').index();
                var easeout_element = $(this).closest('.as-elements').find('.as-elements-list .as-element-settings:eq(' + index + ')').find('.as-element-data-easeOut');
                easeout_element.val($(this).val());
        });

        //Change z_index layer wise
        $('.as-admin').on('keyup change click', '.as-elements .as-ele-time .as-z-index-ele', function() {
                var index = $(this).closest('.as-ele-list').index();
                var easeout_element = $(this).closest('.as-elements').find('.as-elements-list .as-element-settings:eq(' + index + ')').find('.as-element-z-index');
                easeout_element.val($(this).val());
                $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').css('z-index', parseFloat($(this).val()));
        });

        //Select element
        $('.as-admin #as-slides').on('click', '.as-slide .as-elements .as-ele-time .as-ele-list', function() {
                var index = $(this).index();
                var select_block = $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')');
                $(select_block).trigger('click');
        });

        //Hide element
        $('.as-admin #as-slides').on('click', '.as-slide .as-elements .as-ele-time .as-ele-list .dashicons', function() {
                var index = $(this).closest('.as-ele-list').index();
                var hide_block = $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')');
                if($(this).closest('.as-ele-list').hasClass('hide_element'))
                {
                    hide_block.show();
                    $(this).closest('.as-ele-list').removeClass('hide_element');
                }
                else
                {
                    hide_block.hide();
                    $(this).closest('.as-ele-list').addClass('hide_element');
                }

        });
        
        /**
        * Append Element timing block
        * 
        * @param {object} content object of slider anchor
        */
        function  avartansliderGetEleTimingBlock(ele_class, ele_type, ele_title, ele_delay, ele_ease_in, ele_ease_out, ele_z_index) {
            var html = '';
            html += '<tr class="' + ele_class + '">';
            html += '<td title="' + avartanslider_translations.show_hide_ele_title + '"><span class="dashicons dashicons-visibility"></span></td>';
            html += '<td class="as-ele-title"><span class="' + ele_type + '"></span><span class="as-ele-heading">' + ele_title + '</span></td>';
            html += '<td><input type="number" min="0" value="' + ele_delay + '" class="as-delay-ele" onkeypress="return isNumberKey(event);" /></td>';
            html += '<td><input type="number" min="0" value="' + ele_ease_in + '" class="as-easein-ele" onkeypress="return isNumberKey(event);" /></td>';
            html += '<td><input type="number" min="0" value="' + ele_ease_out + '" class="as-easeout-ele" onkeypress="return isNumberKey(event);" /></td>';
            html += '<td><input type="number" value="' + ele_z_index + '" class="as-z-index-ele" min="0" onkeypress="return isNumberKey(event);" /></td>';
            html += '</tr>';
            return html;
        }
        
           
        // TEXT ELEMENTS   
        
        //Add text click
        $('.as-admin #as-slides').on('click', '.as-slide .as-elements .as-elements-actions .as-add-text-element', function() {
                var slide_parent = $(this).closest('.as-slide');
                slide_parent.find('.as-elements-actions').find('.as-layer-menu').find('ul').hide();

                avartansliderAddTextElement(slide_parent);
        });

        /**
         * Add text. Receives the slide as object
         * 
         * @param {object} slide_parent parent class object
        */
        function  avartansliderAddTextElement(slide_parent) {
                var area = slide_parent.find('.as-slide-editing-area');
                var settings_div = slide_parent.find('.as-elements .as-elements-list .as-void-text-element-settings');
                var settings = '<div class="as-element-settings as-text-element-settings">' + $('.as-admin .as-slide .as-elements .as-void-text-element-settings').html() + '</div>';

                // Insert in editing area
                area.append('<div class="as-element as-text-element" style="z-index: 1;">' + avartanslider_translations.text_element_default_html + '</div>');

                // Insert the options
                settings_div.before(settings);

                // Make draggable
                avartansliderDraggableElements();

                // Display settings
                avartansliderSelectElement(area.find('.as-element').last());
                if(slide_parent.find('.as-ele-time tbody').find('tr.as-no-record').length > 0){
                    slide_parent.find('.as-ele-time tbody').html('');
                }
                var ele_html = avartansliderGetEleTimingBlock('as-ele-list active', 'fa fa-text-width', avartanslider_translations.text_element_default_html, 300, 300, 300, 1);
                slide_parent.find('.as-ele-time tbody').append(ele_html);

                //Enable Delete All Element Button
                slide_parent.find('.as-elements-actions .as-delete-all-element').removeClass('as-is-disabled');
        }

        //Modify text
        $('.as-admin').on('keyup', '.as-elements .as-elements-list .as-element-settings .as-element-inner-html', function() {
                var index = $(this).closest('.as-element-settings').index();
                var slide_parent = $(this).closest('.as-slide');
                var text_element = $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')');

                text_element.html($(this).val());
                slide_parent.find('.as-ele-time').find('.as-ele-list:eq('+index+')').find('.as-ele-title span:eq(1)').html($(this).val());
        });
        
        // IMAGE ELEMENTS
        
        //Add images click
        $('.as-admin #as-slides').on('click', '.as-slide .as-elements .as-elements-actions .as-add-image-element', function() {
                var slide_parent = $(this).closest('.as-slide');
                slide_parent.find('.as-elements-actions').find('.as-layer-menu').find('ul').hide();
                avartansliderAddImageElement(slide_parent);
        });

        //Upload Image click
        $('.as-admin').on('click', '.as-elements .as-elements-list .as-image-element-settings .as-image-element-upload-button', function() {
                var slide_parent = $(this).closest('.as-slide');
                avartansliderUploadImageElement(slide_parent);
        });

        /**
         * Add image. Receives the slide as object
         * 
         * @param {object} slide_parent parent class object
        */
        function  avartansliderAddImageElement(slide_parent) {
                var area = slide_parent.find('.as-slide-editing-area');
                var settings_div = slide_parent.find('.as-elements .as-elements-list .as-void-text-element-settings');
                var settings = '<div class="as-element-settings as-image-element-settings">' + $('.as-admin .as-slide .as-elements .as-void-image-element-settings').html() + '</div>';

                // Temporarily insert an element with no src and alt
                // Add the image into the editing area.
                area.append('<div class="as-element as-image-element" style="z-index: 1;"><img src="'+ avartanslider_translations.AvartanPluginUrl +'/images/nothing_now.jpg" /></div>');

                // Insert the options
                settings_div.before(settings);

                // Make draggable
                avartansliderDraggableElements();

                // Display settings
                avartansliderSelectElement(area.find('.as-element').last());

                // Upload
                avartansliderUploadImageElement(slide_parent);
                
        }

        /**
         * Upload image element
         * 
         * @param {object} slide_parent parent class object
        */
        function  avartansliderUploadImageElement(slide_parent) {
                var area = slide_parent.find('.as-slide-editing-area');
                var settings_div = slide_parent.find('.as-elements .as-elements-list .as-void-text-element-settings');

                var file_frame;

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: jQuery( this ).data( 'uploader_title' ),
                    button: {
                          text: jQuery( this ).data( 'uploader_button_text' ),
                    },
                    multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame.state().get('selection').first().toJSON();

                    // Do something with attachment.id and/or attachment.url here
                    var image_src = attachment.url;
                    var image_alt = attachment.alt;
                    var image_title = attachment.title;
                    var image_width = attachment.width;
                    var image_height = attachment.height;

                    // Set attributes. If is a link, do the right thing
                    var image = area.find('.as-image-element.active').last();
                    var scale_image = settings_div.parent().find('.as-element-settings.active .as-element-image-scale');

                    image.find('> img').attr('src', image_src);
                    if($.trim(settings_div.parent().find('.as-element-settings.active .as-element-image-alt').val()) == ''){
                        image.find('> img').attr('alt', image_alt);
                    }
                    image.find('> img').attr('title', image_title);
                    image.find('> img').attr('width', image_width);
                    image.find('> img').attr('height', image_height);
                    image.find('> img').css('width', image_width);
                    image.find('> img').css('height', image_height);
                    image.css('width', image_width);
                    image.css('height', image_height);
                    if(scale_image.is(':checked'))
                    {
                        avartansliderResizeImage(image.find('> img'));
                    }    

                    // Set data (will be used in the ajax call)
                    settings_div.parent().find('.as-element-settings.active .as-image-element-upload-button').attr('data-src', image_src);
                    if($.trim(settings_div.parent().find('.as-element-settings.active .as-element-image-alt').val()) == ''){
                        settings_div.parent().find('.as-element-settings.active .as-element-image-alt').val(image_alt);
                    }
                    settings_div.parent().find('.as-element-settings.active .as-image-element-upload-button').attr('data-title', image_title);
                    settings_div.parent().find('.as-element-settings.active .as-image-element-upload-button').attr('data-width', image_width);
                    settings_div.parent().find('.as-element-settings.active .as-image-element-upload-button').attr('data-height', image_height);
                    
                    var total_image_block = slide_parent.find('.as-ele-time').find('.as-ele-image-list').length;
                    var new_image_index = (parseInt(total_image_block)+1);

                    if(slide_parent.find('.as-ele-time tbody').find('tr.as-no-record').length > 0){
                        slide_parent.find('.as-ele-time tbody').html('');
                    }
                    var ele_html = avartansliderGetEleTimingBlock('as-ele-list as-ele-image-list active', 'fa fa-image', avartanslider_translations.text_element_default_image + new_image_index, 300, 300, 300, 1);
                    slide_parent.find('.as-ele-time tbody').append(ele_html);

                    //Enable Delete All Element Button
                    slide_parent.find('.as-elements-actions .as-delete-all-element').removeClass('as-is-disabled');
                });
                
                file_frame.on('close',function() {
                    setTimeout(function(){
                        if(settings_div.parent().find('.as-element-settings.active .as-image-element-upload-button').attr('data-src') == '') {
                            area.find('.as-element.active').remove();
                            settings_div.parent().find('.as-element-settings.active').remove();
                            slide_parent.find('.as-elements-actions .as-delete-element').addClass('as-is-disabled');
                            slide_parent.find('.as-elements-actions .as-duplicate-element').addClass('as-is-disabled');
                            if(slide_parent.find('.as-ele-time tbody').find('tr.as-no-record').length > 0){
                                slide_parent.find('.as-elements-actions .as-delete-all-element').addClass('as-is-disabled');
                            }
                        }
                    },50)
                    
                });

                // Finally, open the modal
                file_frame.open();
        }
            
        //Scalling image based on slider height and width
        $('.as-admin').on('change', '.as-elements .as-elements-list .as-image-element-settings .as-element-image-scale', function () {
            var slide_parent = $(this).closest('.as-slide');
            var area = slide_parent.find('.as-slide-editing-area');
            var settings_div = slide_parent.find('.as-elements .as-elements-list .as-void-text-element-settings');
            var image = area.find('.as-image-element.active').last();
            var img = image.find('img'); // Get my img elem

            if($(this).is(':checked'))
            {
                avartansliderResizeImage($(img));
                settings_div.parent().find('.as-element-settings.active .as-image-element-upload-button').attr('data-width', $(img).attr('width'));
                settings_div.parent().find('.as-element-settings.active .as-image-element-upload-button').attr('data-height', $(img).attr('height'));
            }  
            else
            {
                $("<img/>") // Make in memory copy of image to avoid css issues
                    .attr("src", $(img).attr("src"))
                    .load(function() {
                        $(img).attr('width',this.width);
                        $(img).attr('height',this.height);
                        $(img).css('width',this.width);
                        $(img).css('height',this.height);
                        image.css('width',this.width);
                        image.css('height',this.height);
                        settings_div.parent().find('.as-element-settings.active .as-image-element-upload-button').attr('data-width', this.width);
                        settings_div.parent().find('.as-element-settings.active .as-image-element-upload-button').attr('data-height', this.height);
                    });
            }


        });

        /**
         * Resize image based on slider height and width
         * 
         * @param {object} img_obj image object
        */
        function  avartansliderResizeImage(img_obj)
        {
            //Get current slider's width x height
            var maxWidth = parseFloat($('#as-slider-settings').find('#as-slider-startWidth').val());
            var maxHeight = parseFloat($('#as-slider-settings').find('#as-slider-startHeight').val());

            //Get image original width x height
            var srcWidth = parseFloat($(img_obj).find('img').attr('width'));
            var srcHeight = parseFloat($(img_obj).find('img').attr('height'));

            //Store in resize variable
            var resizeWidth = srcWidth;
            var resizeHeight = srcHeight;

            var aspect = parseFloat(resizeWidth / resizeHeight);

            //if image width greater than current container width then set width and height
            if (resizeWidth > maxWidth)
            {
                resizeWidth = maxWidth;
                resizeHeight = resizeWidth / aspect;
            }
            //if image height greater than current container height the set width and height
            if (resizeHeight > maxHeight)
            {
                aspect = parseFloat(resizeWidth / resizeHeight);
                resizeHeight = maxHeight;
                resizeWidth = resizeHeight * aspect;
            }
            //Set the width and height of image    
            $(img_obj).find('img').attr('width',resizeWidth);
            $(img_obj).find('img').attr('height',resizeHeight);
            $(img_obj).css('width',resizeWidth);
            $(img_obj).css('height',resizeHeight);
        } 
        
        //VIDEO ELEMENTS
        
        //Add video on click button
        $('.as-admin #as-slides').on('click', '.as-slide .as-elements .as-elements-actions .as-add-video-element', function() {
                var slide_parent = $(this).closest('.as-slide');
                slide_parent.find('.as-elements-actions').find('.as-layer-menu').find('ul').hide();
                avartansliderAddVideoElement(slide_parent);
        });
            
        /**
         * Add Video. Receives the slide as object
         * 
         * @param {object} slide_parent parent class object
        */
        function  avartansliderAddVideoElement(slide_parent) {
                var area = slide_parent.find('.as-slide-editing-area');
                var settings_div = slide_parent.find('.as-elements .as-elements-list .as-void-text-element-settings');
                var settings = '<div class="as-element-settings as-video-element-settings">' + $('.as-admin .as-slide .as-elements .as-void-video-element-settings').html() + '</div>';

                // Temporarily insert an element with no src and alt
                // Add the image into the editing area.
                  area.append('<div class="as-element as-video-element as-iframe-element" style="background:#000;z-index: 999;"><img src="'+avartanslider_translations.AvartanPluginUrl+'/images/video_sample.jpg" width="320" height="240" style="z-index: 1;" /></div>');

                // Insert the options
                settings_div.before(settings);

                // Make draggable
                avartansliderDraggableElements();

                // Display settings
                avartansliderSelectElement(area.find('.as-element').last());

                if(slide_parent.find('.as-ele-time tbody').find('tr.as-no-record').length > 0){
                    slide_parent.find('.as-ele-time tbody').html('');
                }
                var ele_html = avartansliderGetEleTimingBlock('as-ele-list active', 'fa fa-video-camera', avartanslider_translations.text_element_default_video, 300, 300, 300, 1);
                slide_parent.find('.as-ele-time tbody').append(ele_html);

                //Enable Delete All Element Button
                slide_parent.find('.as-elements-actions .as-delete-all-element').removeClass('as-is-disabled');

        }
            
        //Change video type
        $('.as-admin').on('click', '.as-elements .as-elements-list .as-element-settings .as-element-video-type', function() {

            $(this).closest('.nav').find('li').removeClass('as-active-type');
            $(this).closest('.as-element-settings-list').find('.as-video-search').hide();
            $(this).closest('.as-element-settings-list').find('.as-video-block').hide();

            if ($(this).hasClass('as-youtube')) {
                $(this).closest('li').addClass('as-active-type');
                $(this).closest('.as-element-settings-list').find('.as-youtube-search').show();
                if ($.trim($(this).closest('.as-element-settings-list').find('.as-element-youtube-video-link').val()) == '')
                {
                    $(this).closest('.as-element-settings-list').find('.as-youtube-option').hide();
                }
                else
                {
                    $(this).closest('.as-element-settings-list').find('.as-youtube-option').show();
                    $(this).closest('.as-element-settings-list').find('.as-search-youtube-video').trigger('click');
                }
            }
            else if ($(this).hasClass('as-vimeo')) {
                $(this).closest('li').addClass('as-active-type');
                $(this).closest('.as-element-settings-list').find('.as-vimeo-search').show();
                if ($.trim($(this).closest('.as-element-settings-list').find('.as-element-vimeo-video-link').val()) == '')
                {
                    $(this).closest('.as-element-settings-list').find('.as-vimeo-option').hide();
                }
                else
                {
                    $(this).closest('.as-element-settings-list').find('.as-vimeo-option').show();
                    $(this).closest('.as-element-settings-list').find('.as-search-vimeo-video').trigger('click');
                }
            }
            else if ($(this).hasClass('as-html5')) {
                $(this).closest('li').addClass('as-active-type');
                $(this).closest('.as-element-settings-list').find('.html5_search').show();
                $(this).closest('.as-element-settings-list').find('.as-html5-option').show();

                var mp4_url = $.trim($(this).closest('.as-element-settings-list').find('.as-element-html5-mp4-video-link').val());
                var webm_url = $.trim($(this).closest('.as-element-settings-list').find('.as-element-html5-webm-video-link').val());
                var ogv_url = $.trim($(this).closest('.as-element-settings-list').find('.as-element-html5-ogv-video-link').val());

                if (mp4_url != '' || webm_url != '' || ogv_url != '') {
                    $(this).closest('.as-element-settings-list').find('.search_html5_video').trigger('click');
                }
            }
        });
            
            
        /**
         * Get youtube video id by video url or id
         * 
         * @param {string} url youtube id or url
         * 
         * @return {string} youtube id
        */
        function  avartansliderGetYoutubeIDFromUrl(url) {
            url = $.trim(url);

            var video_id = url.split('v=')[1];
            if (video_id) {
                var ampersandPosition = video_id.indexOf('&');
                if (ampersandPosition != -1) {
                    video_id = video_id.substring(0, ampersandPosition);
                }
            } else {
                video_id = url;
            }

            return(video_id);
        }
            
        //Search youtube video on click of button
        $('.as-admin').on('click', '.as-elements .as-elements-list .as-element-settings .as-search-youtube-video', function() {
                var url_val = $.trim($(this).closest('.as-content').find('.as-element-youtube-video-link').val());
                var index = $(this).closest('.as-element-settings').index();
                if(url_val!='')
                {
                    avartansliderGetYoutubeInfo($(this),url_val,index);
                }
        });
            
        /**
         * Get youtube information based on id
         * 
         * @param {object} curr object of youtube url/id contain textbox 
         * 
         * @param {string} url_val youtube url/id
         * 
         * @param {integer} index element index
        */
        function  avartansliderGetYoutubeInfo(curr,url_val,index)
        {
            var youtube_block = $(curr).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')');
            var video_width = $.trim($(curr).closest('.as-element-settings').find('.as-youtube-option').find('.as-element-video-width').val());
            var video_height = $.trim($(curr).closest('.as-element-settings').find('.as-youtube-option').find('.as-element-video-height').val());
            var youtubeImg = '';
            var youtubeTitle = '';
            var youtubeHtml = '';
            var youtubeID = '';

            youtubeID = $.trim(url_val);
            youtubeID = avartansliderGetYoutubeIDFromUrl(youtubeID);

            var newUrl = 'https://i.ytimg.com/vi/'+youtubeID+'/hqdefault.jpg';
            youtubeImg = newUrl;
            youtubeTitle = avartanslider_translations.youtube_video_title;
            $('.as-ele-time').find('.as-ele-list:eq('+ index +')').find('.as-ele-title span:eq(1)').html($.trim(youtubeTitle));

            youtubeHtml += '<label class="video_block_title">'+youtubeTitle+'</label>';
            youtubeHtml += '<img src="'+youtubeImg+'" width="'+video_width+'" height="'+video_height+'" />';
            youtubeHtml += '<div class="video_block_icon youtube_icon"></div>';

            $(youtube_block).html(youtubeHtml);
            $(youtube_block).css({
                "width" : video_width,
                "height" : video_height,
            });
            $(curr).closest('.as-element-settings').find('.as-youtube-option').find('.as-preview-image-element-upload-button').attr('data-src', youtubeImg);
            $(curr).closest('.as-element-settings').find('.as-youtube-option').find('.as-preview-image-element-upload-button').attr('data-alt', youtubeTitle);
            $(curr).closest('.as-element-settings').find('.as-youtube-option').find('.as-preview-image-element-upload-button').attr('data-is-preview', 'false');
            $(curr).closest('.as-element-settings').find('.as-youtube-option').show();
        }

        /**
         * Get vimeo video id from video url or id
         * 
         * @param {string} url vimeo id or url
         * 
         * @return {string} vimeo id
        */
        function  avartansliderGetVimeoIDFromUrl(url) {
            url = $.trim(url);

            var video_id = url.replace(/[^0-9]+/g, '');
            video_id = $.trim(video_id);

            return(video_id);
        }
            
        //Search vimeo video on click of button
        $('.as-admin').on('click', '.as-elements .as-elements-list .as-element-settings .as-search-vimeo-video', function() {
                var url_val = $.trim($(this).closest('.as-content').find('.as-element-vimeo-video-link').val());
                var index = $(this).closest('.as-element-settings').index();
                if(url_val!='')
                {
                    avartansliderGetVimeoInfo($(this),url_val,index);
                }
        });
            
        /**
         * Get vimeo video information based on id/url
         * 
         * @param {object} curr object of vimeo url/id contain textbox 
         * 
         * @param {string} url_val vimeo url/id
         * 
         * @param {integer} index element index
        */
        function  avartansliderGetVimeoInfo(curr,url_val,index)
        {
            var vimeo_block = $(curr).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')');
            var video_width = $.trim($(curr).closest('.as-element-settings').find('.as-vimeo-option').find('.as-element-video-width').val());
            var video_height = $.trim($(curr).closest('.as-element-settings').find('.as-vimeo-option').find('.as-element-video-height').val());
            var vimeoID = '';
            var vimeoImg = '';
            var vimeoTitle = '';

            vimeoID = $.trim(url_val);
            vimeoID = avartansliderGetVimeoIDFromUrl(vimeoID);

            $.ajax({
                url: 'http://vimeo.com/api/v2/video/' + vimeoID + '.json',
                dataType: 'jsonp',
                success: function (data) {
                    vimeoImg = data[0].thumbnail_large;
                    vimeoTitle = data[0].title;

                    var vimeoHtml = '';
                    if($.trim(vimeoTitle)!='')
                    {
                        vimeoHtml += '<label class="video_block_title">'+$.trim(vimeoTitle)+'</label>';
                        $('.as-ele-time').find('.as-ele-list:eq('+ index +')').find('.as-ele-title span:eq(1)').html($.trim(vimeoTitle));
                    }  
                    vimeoHtml += '<img src="'+vimeoImg+'" width="'+video_width+'" height="'+video_height+'" />';
                    vimeoHtml += '<div class="video_block_icon vimeo_icon"></div>';
                    $(vimeo_block).html(vimeoHtml);
                    $(vimeo_block).css({
                        "width" : video_width,
                        "height" : video_height,
                    });

                    $(curr).closest('.as-element-settings').find('.as-vimeo-option').show();
                    $(curr).closest('.as-element-settings').find('.as-vimeo-option').find('.as-preview-image-element-upload-button').attr('data-src', vimeoImg);
                    $(curr).closest('.as-element-settings').find('.as-vimeo-option').find('.as-preview-image-element-upload-button').attr('data-alt', vimeoTitle);
                    $(curr).closest('.as-element-settings').find('.as-vimeo-option').find('.as-preview-image-element-upload-button').attr('data-is-preview', 'false');
                }
            });
        }
            
        //Search Html5 video on click of button
        $('.as-admin').on('click', '.as-elements .as-elements-list .as-element-settings .search_html5_video', function() {

            var mp4_url = $.trim($(this).closest('.as-element-settings-list').find('.as-element-html5-mp4-video-link').val());
            var webm_url = $.trim($(this).closest('.as-element-settings-list').find('.as-element-html5-webm-video-link').val());
            var ogv_url = $.trim($(this).closest('.as-element-settings-list').find('.as-element-html5-ogv-video-link').val());
            var poster_url = $.trim($(this).closest('.as-element-settings-list').find('.as-element-html5-poster-url').val());

            var index = $(this).closest('.as-element-settings').index();
            if(mp4_url!='' || webm_url!='' || ogv_url!='')
            {
                var video_block = $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')');
                var video_width = $.trim($(this).closest('.as-element-settings').find('.as-html5-option').find('.as-element-video-width').val());
                var video_height = $.trim($(this).closest('.as-element-settings').find('.as-html5-option').find('.as-element-video-height').val());
                var html5Image = '';
                if(poster_url!=''){
                    html5Image = poster_url;
                }
                else
                {
                    html5Image = avartanslider_translations.AvartanPluginUrl+'/images/html5-video.png';
                }
                var html5Html = '';
                html5Html += '<label class="video_block_title">'+avartanslider_translations.html5_video_title+'</label>';
                html5Html += '<img src="'+html5Image+'" width="'+video_width+'" height="'+video_height+'" />';
                html5Html += '<div class="video_block_icon html5_icon"></div>';
                $(video_block).html(html5Html);
                $(video_block).css({
                    "width" : video_width,
                    "height" : video_height,
                });
            }    
        });

        //Check extension of mp4 video
        $('.as-admin').on('blur', '.as-elements .as-elements-list .as-element-settings .as-element-html5-mp4-video-link', function() {
            var mp4_url = $.trim($(this).val());
            var html5_mp4_ext = mp4_url.split('.').pop();

            if(mp4_url!='' && html5_mp4_ext.toLowerCase()!='mp4'){
                $(this).val('');
                alert('Extension of video must be mp4.');
            }
        });
            
        //Check extension of webm video
        $('.as-admin').on('blur', '.as-elements .as-elements-list .as-element-settings .as-element-html5-webm-video-link', function() {
            var webm_url = $.trim($(this).val());
            var html5_webm_ext = webm_url.split('.').pop();

            if(webm_url!='' && html5_webm_ext.toLowerCase()!='webm'){
                $(this).val('');
                alert('Extension of video must be webm.');
            }
        });
            
        //Check extension of ogv video
        $('.as-admin').on('blur', '.as-elements .as-elements-list .as-element-settings .as-element-html5-ogv-video-link', function() {
            var ogv_url = $.trim($(this).val());
            var html5_ogv_ext = ogv_url.split('.').pop();

            if(ogv_url!='' && html5_ogv_ext.toLowerCase()!='ogv'){
                $(this).val('');
                alert('Extension of video must be ogv.');
            }
        });
            
        //Modify Fullwidth option
        $('.as-admin').on('change', '.as-elements .as-elements-list .as-element-settings .as-element-video-full-width', function() {
            var index = $(this).closest('.as-element-settings').index();
            var video_type = $(this).closest('.as-element-settings').find('.as-active-type').find('.as-element-video-type');

//                var wh_tr_block = $(this).closest('.as-elements-list').find(video_option).find('.as-video-wh');
            var wh_tr_block = $(this).closest('.as-content').find('.as-video-wh');
            var wh_left = $(this).closest('.as-elements-list').find('.as-element-data-left');
            var wh_top = $(this).closest('.as-elements-list').find('.as-element-data-top');
            var iframe_wrapper = $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')');
            var iframe_block = $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').find('img');

            if($(this).is(':checked'))
            {
                $(wh_tr_block).hide();
                $(iframe_block).attr('width',$.trim($('#as-slider-startWidth').val()));
                $(iframe_block).attr('height',$.trim($('#as-slider-startHeight').val()));
                $(iframe_wrapper).css('width',$.trim($('#as-slider-startWidth').val()));
                $(iframe_wrapper).css('height',$.trim($('#as-slider-startHeight').val()));
                $(wh_tr_block).find('.as-element-video-width').val($.trim($('#as-slider-startWidth').val()));
                $(wh_tr_block).find('.as-element-video-height').val($.trim($('#as-slider-startHeight').val()));
                $(iframe_wrapper).css('left','0');
                $(iframe_wrapper).css('top','0');
                $(wh_left).val('0');
                $(wh_top).val('0');
            }
            else
            {
                $(wh_tr_block).show();
                $(iframe_block).attr('width','320');
                $(iframe_block).attr('height','240');
                $(iframe_wrapper).css('width','320');
                $(iframe_wrapper).css('height','240');
                $(wh_tr_block).find('.as-element-video-width').val('320');
                $(wh_tr_block).find('.as-element-video-height').val('240');
            }
        });

        //Modify Width option
        $('.as-admin').on('keyup', '.as-elements .as-elements-list .as-element-settings .as-element-video-width', function() {
                var video_width = $.trim($(this).val());
                var index = $(this).closest('.as-element-settings').index();
                var iframe_block = $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').find('img');
                var iframe_wrapper = $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')');
                if(video_width!='' && video_width!=0)
                {
                    $(iframe_wrapper).css('width',video_width);
                    $(iframe_block).attr('width',video_width);
                }
        });
            
        //Modify Height option
        $('.as-admin').on('keyup', '.as-elements .as-elements-list .as-element-settings .as-element-video-height', function() {
                var video_height = $.trim($(this).val());
                var index = $(this).closest('.as-element-settings').index();
                var iframe_block = $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').find('img');
                var iframe_wrapper = $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')');
                if(video_height!='' && video_height!=0)
                {
                    $(iframe_wrapper).css('height',video_height);
                    $(iframe_block).attr('height',video_height);
                }
        });
            
        //Set preview image for vimeo and youtube
        $('.as-admin').on('click', '.as-elements .as-elements-list .as-video-element-settings .as-preview-image-element-upload-button', function() {
                var video_type = $(this).closest('.as-element-settings').find('.as-active-type').find('.as-element-video-type');
                var video_option = '';

                if (video_type.hasClass('as-youtube')) {
                    video_option = '.as-youtube-option';
                }
                else if (video_type.hasClass('as-vimeo')) {
                    video_option = '.as-vimeo-option';
                }
                var slide_parent = $(this).closest('.as-slide');
                avartansliderUploadPreviewImageElement(slide_parent,video_option);
        });
            
        /**
         * Set preview image
         * 
         * @param {object} slide_parent parent class object
         * 
         * @param {string} video_option string value of video type
        */
        function  avartansliderUploadPreviewImageElement(slide_parent,video_option) {
            var area = slide_parent.find('.as-slide-editing-area');
            var settings_div = slide_parent.find('.as-elements .as-elements-list .as-void-text-element-settings');

            var file_frame;

            // If the media frame already exists, reopen it.
            if (file_frame) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery(this).data('uploader_title'),
                button: {
                    text: jQuery(this).data('uploader_button_text'),
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected, run a callback.
            file_frame.on('select', function () {
                // We set multiple to false so only get one image from the uploader
                attachment = file_frame.state().get('selection').first().toJSON();

                // Do something with attachment.id and/or attachment.url here
                var image_src = attachment.url;
                var image_alt = attachment.alt;
                var image_title = attachment.title;

                // Set attributes. If is a link, do the right thing
                var image = area.find('.as-video-element.active').last();

                image.find('img').attr('src', image_src);
                image.find('img').attr('alt', image_alt);
                image.find('img').attr('title', image_title);

                // Set data (will be used in the ajax call)
                settings_div.parent().find('.as-element-settings.active '+video_option+' .as-preview-image-element-upload-button').attr('data-src', image_src);
                settings_div.parent().find('.as-element-settings.active '+video_option+' .as-preview-image-element-upload-button').attr('data-alt', image_alt);
                settings_div.parent().find('.as-element-settings.active '+video_option+' .as-preview-image-element-upload-button').attr('data-title', image_title);
                settings_div.parent().find('.as-element-settings.active '+video_option+' .as-preview-image-element-upload-button').attr('data-is-preview', 'true');
            });
            // Finally, open the modal
            file_frame.open();
        }
            
        //Remove preview
        $('.as-admin').on('click', '.as-elements .as-elements-list .as-video-element-settings .as-remove-preview-image-element-upload-button', function() {

            var video_type = $(this).closest('.as-element-settings').find('.as-active-type').find('.as-element-video-type');
            var index = $(this).closest('.as-element-settings').index();

            if (video_type.hasClass('as-youtube'))
            {
                var url_val = $.trim($(this).closest('.as-element-settings-list').find('.as-element-youtube-video-link').val());
                if (url_val != '')
                {
                    avartansliderGetYoutubeInfo($(this), url_val, index);
                }
            }
            else if (video_type.hasClass('as-vimeo'))
            {
                var url_val = $.trim($(this).closest('.as-element-settings-list').find('.as-element-vimeo-video-link').val());
                if (url_val != '')
                {
                    avartansliderGetVimeoInfo($(this), url_val, index);
                }
            }
        });
        
        //ELEMENTS ADVANCED PARAMETERS
        
        //onclick on label checked checkbox
        $('.as-admin').on('click', '.as-elements .as-elements-list .as-label-for', function() {
                var labelForChk = $(this).closest('tr').find($(this).attr('data-label-for'));
                if(labelForChk.is(':checked')){
                    labelForChk.prop('checked',false);
                }
                else
                {
                    labelForChk.prop('checked',true);
                }
                labelForChk.trigger('change');
        });

        //Modify delay option
        $('.as-admin').on('keyup change click', '.as-elements .as-element-data-delay', function() {

                var index = $(this).closest('.as-element-settings').index();
                var delay_element = $(this).closest('.as-elements').find('.as-ele-time').find('.as-ele-list:eq('+index+')').find('input.as-delay-ele');
                delay_element.val($(this).val());
        });

        //Modify Ease In option
        $('.as-admin').on('keyup change click', '.as-elements .as-element-data-easeIn', function() {

                var index = $(this).closest('.as-element-settings').index();
                var easein_element = $(this).closest('.as-elements').find('.as-ele-time').find('.as-ele-list:eq('+index+')').find('input.as-easein-ele');
                easein_element.val($(this).val());
        });

        //Modify Ease Out option
        $('.as-admin').on('keyup change click', '.as-elements .as-element-data-easeOut', function() {

                var index = $(this).closest('.as-element-settings').index();
                var easeout_element = $(this).closest('.as-elements').find('.as-ele-time').find('.as-ele-list:eq('+index+')').find('input.as-easeout-ele');
                easeout_element.val($(this).val());
        });

        //Modify left position
        $('.as-admin').on('keyup change click', '.as-elements .as-elements-list .as-element-settings .as-element-data-left', function() {
                var index = $(this).closest('.as-element-settings').index();
                $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').css('left', parseFloat($(this).val()));
                $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').data('left', parseFloat($(this).val()));
        });

        //Modify top position
        $('.as-admin').on('keyup change click', '.as-elements .as-elements-list .as-element-settings .as-element-data-top', function() {
                var index = $(this).closest('.as-element-settings').index();
                $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').css('top', parseFloat($(this).val()));
                $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').data('top', parseFloat($(this).val()));
        });

        //Modify z-index
        $('.as-admin').on('keyup change click', '.as-elements .as-elements-list .as-element-settings .as-element-z-index', function() {
                var index = $(this).closest('.as-element-settings').index();
                var easeout_element = $(this).closest('.as-elements').find('.as-ele-time').find('.as-ele-list:eq('+index+')').find('input.as-z-index-ele');
                easeout_element.val($(this).val());
                $(this).closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').css('z-index', parseFloat($(this).val()));
        });

        //Add / remove link wrapper (fire on textbox edit or on checkbox _target:"blank" edit)
        $('.as-admin').on('keyup', '.as-elements .as-elements-list .as-element-settings .as-element-link', function() {
                avartansliderEditElementsLink($(this));
        });
        $('.as-admin').on('change', '.as-elements .as-elements-list .as-element-settings .as-element-link-new-tab', function() {
                var textbox = $(this).parent().find('.as-element-link');
                avartansliderEditElementsLink(textbox);
        });

        /**
         * Wrap - unwrap elements with an <a href="" target="">
         * 
         * @param {object} textbox_link textbox object
        */
        function  avartansliderEditElementsLink(textbox_link) {
            var index = textbox_link.closest('.as-element-settings').index();
            var copy_attributes = false;
            var reapply_css = false;

            var ele_obj = textbox_link.closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')');

            //!anchor_obj.hasClass('as-element')
            if (textbox_link.val() != '' && !ele_obj.is('a')) {

                var link_new_tab = textbox_link.parent().find('.as-element-link-new-tab').prop('checked') ? 'target="_blank"' : '';
                ele_obj.wrapInner('<a class="as-element" href="' + textbox_link.val() + '"' + link_new_tab + ' />');
                copy_attributes = true;
                reapply_css = true;
            }
            else if (textbox_link.val() != '' && ele_obj.is('a')) {

                var link_new_tab = textbox_link.parent().find('.as-element-link-new-tab').prop('checked') ? true : false;

                ele_obj.attr('href', textbox_link.val());

                if (link_new_tab) {
                    ele_obj.attr('target', '_blank');
                }
                else {
                    ele_obj.removeAttr('target');
                }

                copy_attributes = false;
            }
            else if (textbox_link.val() == '' && ele_obj.is('a')) {

                ele_obj.wrapInner('<div class="as-element"></div>');
                copy_attributes = true;
                reapply_css = true;

            }

            if (copy_attributes) {
                ele_obj.find('.as-element').attr('data-left', ele_obj.attr('data-left'));
                ele_obj.find('.as-element').attr('data-top', ele_obj.attr('data-top'));
                ele_obj.find('.as-element').attr('style', ele_obj.attr('style'));
                ele_obj.find('.as-element').attr('class', ele_obj.attr('class')).removeClass('ui-draggable');

                ele_obj.find('.as-element').unwrap();

            }

            avartansliderDraggableElements();

            if (reapply_css) {
                avartansliderApplyCustomCss(textbox_link.closest('.as-element-settings').find('.as-element-custom-css'));
            }
        }

        //call Apply custom CSS
        $('.as-admin').on('keyup', '.as-elements .as-elements-list .as-element-settings .as-element-custom-css', function() {
                avartansliderApplyCustomCss($(this));
        });

        /**
         * Apply custom CSS
         * 
         * @param {object} textarea textarea object
        */
        function  avartansliderApplyCustomCss(textarea) {
                var index = textarea.closest('.as-element-settings').index();
                // Save current positions
                var left = textarea.closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').css('left');
                var top = textarea.closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').css('top');
                var z_index = textarea.closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').css('z-index');

                // Apply CSS
                textarea.closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').attr('style', textarea.val());
                textarea.closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').css('top', top);
                textarea.closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').css('left', left);
                textarea.closest('.as-elements').find('.as-slide-editing-area .as-element:eq(' + index + ')').css('z-index', z_index);			
        }

            /******************/
            /** LIVE PREVIEW **/
            /******************/

            /**
             * Live preview click
            */
            $('.as-admin #as-slides').on('click', '.as-slide .as-elements .as-elements-actions .as-live-preview', function() {
                    var btn = $(this);
                    var slide_parent = btn.closest('.as-slide');

                    if(! btn.hasClass('as-live-preview-running')) {
                            btn.addClass('as-live-preview-running');
                            btn.html(avartanslider_translations.slide_stop_preview);
                            avartansliderStartLivePreview(slide_parent);
                    }
                    else {
                            btn.removeClass('as-live-preview-running');
//                            btn.text(avartanslider_translations.slide_live_preview);
                            btn.html('<span class="dashicons dashicons-search"></span>');
                            avartansliderStopLivePreview(slide_parent);
                    }
            });
            
            function getSlideSettings() {
                
                    //Get Slide Information
                    var final_options = new Array();
                    
                    var slide_index = $('.as-admin .as-slide-tab').find('li.active').index();
                    var slide = $('.as-admin .as-slider #as-slides .as-slide:eq('+ slide_index +')');
                    var slide_id = slide.find('.as-save-slide').attr('data-slide-id');
                    var i = 0;
                    var j = 0;
                    var final_options = new Array();
                    var slider_parent = parseInt($('.as-admin .as-save-settings').attr('data-id'));
                    
                    slide.each(function() {
                            j=0;
                            var element_arr = new Array();
                            var slide = $(this);
                            var content = slide.find('.as-slide-settings-list');

                            var options = {
                                    background_type_image: slide.find('.as-editor-wrapper').css('background-image') == 'none' ? 'none' : slide.find('.as-editor-wrapper').attr('data-background-image-src') + "",
                                    background_type_color: content.find('.as-slide-background-type-color').val() == '0' ? 'transparent' : $.trim(content.find('.as-slide-background-type-color-picker-input').val()),
                                    background_property_position: content.find('.as-slide-background-position').val(),
                                    background_property_position_x: ($.trim(content.find('.as-slide-background-position').val()) == 'percentage') ? $.trim(content.find('.as-slide-background-position-x').val()) : '0',
                                    background_property_position_y: ($.trim(content.find('.as-slide-background-position').val()) == 'percentage') ? $.trim(content.find('.as-slide-background-position-y').val()) : '0',
                                    background_repeat: $.trim(content.find('.as-slide-background-repeat').val()),
                                    background_property_size: content.find('.as-slide-background-property-size').val(),
                                    background_property_size_x: ($.trim(content.find('.as-slide-background-property-size').val()) == 'percentage') ? $.trim(content.find('.as-slide-background-size-x').val()) : '0',
                                    background_property_size_y: ($.trim(content.find('.as-slide-background-property-size').val()) == 'percentage') ? $.trim(content.find('.as-slide-background-size-y').val()) : '0',
                                    data_in : content.find('.as-slide-data-in').val(),
                                    data_out : content.find('.as-slide-data-out').val(),
                                    data_time : ($.trim(content.find('.as-slide-data-time').val())!='')?parseInt(content.find('.as-slide-data-time').val()):'0',
                                    data_easeIn : ($.trim(content.find('.as-slide-data-easeIn').val())!='')?parseInt(content.find('.as-slide-data-easeIn').val()):'0',
                                    data_easeOut : ($.trim(content.find('.as-slide-data-easeOut').val())!='')?parseInt(content.find('.as-slide-data-easeOut').val()):'0',
                                    custom_css : content.find('.as-slide-custom-css').val(),
                            };
                            var elements = slide.find('.as-elements .as-element-settings');
                            elements.each(function() {
                                    var element = $(this);

                                    // Stop each loop when reach the void element
                                    if(element.hasClass('as-void-element-settings')) {
                                            return;
                                    }
                                    var video_class = element.find('.as-active-type').find('.as-element-video-type');
                                    var video_type = '';
                                    var video_link = '';
                                    var video_id = '';
                                    var video_html5_mp4_video_link = '';
                                    var video_html5_webm_video_link = '';
                                    var video_html5_ogv_video_link = '';
                                    var video_html5_poster_url = '';
                                    var video_width = '';
                                    var video_height = '';
                                    var video_full_width = '';
                                    var video_preview_img_src = '';
                                    var video_preview_img_alt = '';
                                    var video_option = '';
                                    var is_preview = '';
                                    if (video_class.hasClass('as-youtube'))
                                    {
                                        video_type = 'Y';
                                        video_link = element.find('.as-element-youtube-video-link').length > 0 ? element.find('.as-element-youtube-video-link').val() : '';
                                        if (video_link != '') {
                                            video_id = avartansliderGetYoutubeIDFromUrl(video_link);
                                        }
                                        video_option = '.as-youtube-option';
                                        is_preview = element.hasClass('as-video-element-settings') ? element.find(video_option).find('.as-preview-image-element-upload-button').attr('data-is-preview') : '';
                                    }
                                    else if (video_class.hasClass('as-vimeo'))
                                    {
                                        video_type = 'V';
                                        video_link = element.find('.as-element-vimeo-video-link').length > 0 ? element.find('.as-element-vimeo-video-link').val() : '';
                                        if (video_link != '') {
                                            video_id = avartansliderGetVimeoIDFromUrl(video_link);
                                        }
                                        video_option = '.as-vimeo-option';
                                        is_preview = element.hasClass('as-video-element-settings') ? element.find(video_option).find('.as-preview-image-element-upload-button').attr('data-is-preview') : '';
                                    }
                                    else if (video_class.hasClass('as-html5'))
                                    {
                                        video_type = 'H';
                                        video_option = '.as-html5-option';
                                        video_html5_mp4_video_link = element.find('.as-element-html5-mp4-video-link').length > 0 ? element.find('.as-element-html5-mp4-video-link').val() : '';
                                        video_html5_webm_video_link = element.find('.as-element-html5-webm-video-link').length > 0 ? element.find('.as-element-html5-webm-video-link').val() : '';
                                        video_html5_ogv_video_link = element.find('.as-element-html5-ogv-video-link').length > 0 ? element.find('.as-element-html5-ogv-video-link').val() : '';
                                        video_html5_poster_url = element.find('.as-element-html5-poster-url').length > 0 ? element.find('.as-element-html5-poster-url').val() : '';
                                        is_preview = 'false';
                                        if ($.trim(video_html5_poster_url) != '')
                                        {
                                            is_preview = 'true';
                                        }
                                    }

                                    video_width = element.find(video_option).find('.as-element-video-width').length > 0 ? element.find(video_option).find('.as-element-video-width').val() : '';
                                    video_height = element.find(video_option).find('.as-element-video-height').length > 0 ? element.find(video_option).find('.as-element-video-height').val() : '';
                                    video_full_width = (element.find(video_option).find('.as-element-video-full-width').length > 0 && element.find(video_option).find('.as-element-video-full-width').is(':checked')) ? element.find(video_option).find('.as-element-video-full-width').val() : '';
                                    video_preview_img_src = element.hasClass('as-video-element-settings') ? element.find(video_option).find('.as-preview-image-element-upload-button').attr('data-src') : '';
                                    video_preview_img_alt = element.hasClass('as-video-element-settings') ? element.find(video_option).find('.as-preview-image-element-upload-button').attr('data-alt') : '';
                                    var layers = {	
                                            position : element.index(),
                                            type : element.hasClass('as-text-element-settings') ? 'text' : element.hasClass('as-image-element-settings') ? 'image' : element.hasClass('as-video-element-settings') ? 'video':'',
                                            inner_html : element.hasClass('as-text-element-settings') ? element.find('.as-element-inner-html').val() : '',
                                            image_src : element.hasClass('as-image-element-settings') ? element.find('.as-image-element-upload-button').attr('data-src') : '',
                                            image_alt : (element.find('.as-element-image-alt').length > 0 && $.trim(element.find('.as-element-image-alt').val())!='') ? $.trim(element.find('.as-element-image-alt').val()) : element.find('.as-image-element-upload-button').attr('data-alt'),
                                            image_width : element.hasClass('as-image-element-settings') ? element.find('.as-image-element-upload-button').attr('data-width') : '',
                                            image_height : element.hasClass('as-image-element-settings') ? element.find('.as-image-element-upload-button').attr('data-height') : '',
                                            image_scale : (element.find('.as-element-image-scale').length > 0 && element.find('.as-element-image-scale').is(':checked')) ? element.find('.as-element-image-scale').val() : '',
                                            data_left : parseInt(element.find('.as-element-data-left').val()),
                                            data_top : parseInt(element.find('.as-element-data-top').val()),
                                            z_index : parseInt(element.find('.as-element-z-index').val()),
                                            data_delay : parseInt(element.find('.as-element-data-delay').val()),
                                            data_time : element.find('.as-element-data-time').val(),
                                            data_in : element.find('.as-element-data-in').val(),
                                            data_out : element.find('.as-element-data-out').val(),
                                            data_ignoreEaseOut : element.find('.as-element-data-ignoreEaseOut').prop('checked') ? 1 : 0,
                                            data_easeIn : parseInt(element.find('.as-element-data-easeIn').val()),
                                            data_easeOut : parseInt(element.find('.as-element-data-easeOut').val()),
                                            custom_css : element.find('.as-element-custom-css').val(),
                                            attr_id : (element.find('.as-element-attr-id').length > 0)?element.find('.as-element-attr-id').val():'',
                                            attr_class : (element.find('.as-element-attr-class').length > 0)?element.find('.as-element-attr-class').val():'',
                                            attr_title : (element.find('.as-element-attr-title').length > 0)?element.find('.as-element-attr-title').val():'',
                                            attr_rel : (element.find('.as-element-attr-rel').length > 0)?element.find('.as-element-attr-rel').val():'',
                                            link : (element.find('.as-element-link').length > 0)?element.find('.as-element-link').val():'',
                                            link_id : (element.find('.as-element-link-id').length > 0)?element.find('.as-element-link-id').val():'',
                                            link_class : (element.find('.as-element-link-class').length > 0)?element.find('.as-element-link-class').val():'',
                                            link_title : (element.find('.as-element-link-title').length > 0)?element.find('.as-element-link-title').val():'',
                                            link_rel : (element.find('.as-element-link-rel').length > 0)?element.find('.as-element-link-rel').val():'',
                                            link_new_tab : ( element.find('.as-element-link-new-tab').length > 0 && element.find('.as-element-link-new-tab').prop('checked') ) ? 1 : 0,
                                            video_type : video_type,
                                            video_link : video_link,
                                            video_id : video_id,
                                            video_html5_mp4_video_link : video_html5_mp4_video_link,
                                            video_html5_webm_video_link : video_html5_webm_video_link,
                                            video_html5_ogv_video_link : video_html5_ogv_video_link,
                                            video_html5_poster_url : video_html5_poster_url,
                                            video_width : video_width,
                                            video_height : video_height,
                                            video_full_width : video_full_width,
                                            video_preview_img_src : video_preview_img_src,
                                            video_preview_img_alt : video_preview_img_alt,
                                            video_is_preview_set : is_preview,
                                    };
                                    
                                    element_arr.push(layers);
                                    j++;
                            });
                            final_options.push({"slider_parent":slider_parent,"position":slide_index,"slide":options,"slide_id":slide_id,"layers":JSON.stringify(element_arr)});
                            i++;
                    });
                    
                    return final_options;
            }
            
            function addVideoApi(slide_parent) {		
                var httpprefix = location.protocol === 'https:' ? "https" : "http";

                //INTIALIZE YOUTUBE VIDEO API
                if (slide_parent.find(".as-video-layer[data-video-type='youtube']").length > 0){
                        var s_tag = document.createElement("script");								
                        s_tag.src = "https://www.youtube.com/iframe_api"; /* Load Player API*/
                        var before = document.getElementsByTagName("script")[0],
                                loadsrc = true;

                        jQuery('head').find('*').each(function(){
                            if (jQuery(this).attr('src') == "https://www.youtube.com/iframe_api")
                            {
                               loadsrc = false;
                            }
                        });
                        if (loadsrc) 
                        {
                            before.parentNode.insertBefore(s_tag, before);
                        }

                }

                //INTIALIZE VIMEO VIDEO API
                if (slide_parent.find(".as-video-layer[data-video-type='vimeo']").length > 0){
                        var f = document.createElement("script"),
                                before = document.getElementsByTagName("script")[0],
                                loadVsrc = true;
                        f.src = httpprefix+"://f.vimeocdn.com/js/froogaloop2.min.js"; /* Load Player API*/							

                        jQuery('head').find('*').each(function(){
                            if (jQuery(this).attr('src') == httpprefix+"://a.vimeocdn.com/js/froogaloop2.min.js")
                            {
                               loadVsrc = false;
                            }
                        });
                        if (loadVsrc)
                        {
                            before.parentNode.insertBefore(f, before);
                        }
                }

            }
            
            
            /**
             * Start single slide preview
             * 
             * @param {object} slide_parent parent class object
            */
            function  avartansliderStartLivePreview(slide_parent) {
                    avartansliderDeselectElements();
                    var isMobile = false;
                    var final_options = new Array();
                    
                    
                    //Get Json Array of settings
                    final_options = getSlideSettings();
                    
                    var area = slide_parent.find('.as-editor-wrapper');
                    var slider = $('.as-admin .as-slider #as-slider-settings');
                    
                    var sliderwidth = parseInt(slider.find('#as-slider-startWidth').val());
                    var sliderheight = parseInt(slider.find('#as-slider-startHeight').val());
                    
                    area.clone().addClass('as-slide-live-preview-area').insertAfter(area);
                    var prev = slide_parent.find('.as-slide-live-preview-area');

                    area.css('display', 'none');
                    prev.html('');
                    jQuery.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : ajaxurl,
                            data : {
                                    action: 'avartanslider_getSlidePreview',
                                    nonce: avartanslider_translations.default_nonce,
                                    datas : final_options,
                            },
                            success: function(response) {
                                    if(response !== false && response!='') {
                                            prev.html(response);
                                            addVideoApi(prev);
                                            // Set slide data and styles
                                            prev.removeClass('fixed');
                                            prev.css('width',parseInt(sliderwidth));

                                            var ewp = $('.as-wrapper').width();
                                            if(!isMobile && sliderwidth < ewp) {
                                                prev.css('width','100%');
                                            }

                                            prev.css('height',parseInt(sliderheight));
                                            
                                            setTimeout(function(){
                                                prev.find('ul').css('display', 'block');

                                                //Run Avartan Slider
                                                prev.avartanSlider({
                                                        layout : slider.find('#as-slider-layout').val(),
                                                        startWidth : parseInt(slider.find('#as-slider-startWidth').val()),
                                                        startHeight : parseInt(slider.find('#as-slider-startHeight').val()),
                                                        automaticSlide : true,
                                                        enableSwipe: false,
                                                        showShadowBar: false,
                                                        pauseOnHover: false,
                                                        navigation: {
                                                            arrows: {
                                                                enable: false,
                                                            },
                                                            bullets: {
                                                                enable: false,
                                                            }
                                                        },
                                                });
                                            },50);

                                                
                                    }
                                    else {
                                        avartansliderShowMsg(avartanslider_translations.slide_error,'danger');
                                    }
                            },

                            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                avartansliderShowMsg('Error getting slide!<br>Status:'+textStatus+' <br>Error:'+errorThrown,'danger');
                            }
                    });
            }

            /**
             * Stop single slide preview
             * 
             * @param {object} slide_parent parent class object
            */
            function  avartansliderStopLivePreview(slide_parent) {
                    var area = slide_parent.find('.as-editor-wrapper');
                    var prev = slide_parent.find('.as-slide-live-preview-area');

                    prev.remove();
                    area.css('display', 'block');
            }

            /****************/
            /** AJAX CALLS **/
            /****************/

            /**
             * Save or update the new slider in the database
            */
            $('.as-admin .as-slider .as-save-settings').click(function() {
                if($.trim($(this).closest('.as-slider').find('#as-slider-name').val())!='')
                {
                    $(this).closest('.as-slider').find('#as-slider-name').css('border','1px solid #ddd');
                    avartansliderSaveSlider();
                }
                else
                {
                    $(this).closest('.as-slider').find('#as-slider-name').css('border','1px solid red');
                    avartansliderShowMsg(avartanslider_translations.slider_name,'danger')
                }
            });
            
            /**
             * Save or update the slide in the database
            */
           $('.as-admin #as-slides').on('click', '.as-slide .as-save-slide', function() {
                var slide_id = $(this).attr('data-slide-id');
                avartansliderSaveSlide();
            });
            
            /**
             * Reset Slider settings
            */
            $('.as-admin .as-slider .as-reset-slider-settings').click(function() {
                avartansliderResetSlider($(this).attr('data-reset-block'));
            });

            /**
             * Delete slider
            */
            $('.as-admin .as-home .as-sliders-list .as-delete-slider').click(function() {
                    var confirm = window.confirm(avartanslider_translations.slider_delete_confirm);
                    if(!confirm) {
                            return;
                    }

                    avartansliderDeleteSlider($(this));
            });
            
            /**
            * Reset the slider
            * 
            * @param {object} resetBlock parent class object
            */
            function avartansliderResetSlider(resetBlock){
                var content = $('.as-admin .as-slider #as-slider-settings');
                if(resetBlock == '#as-slider-general'){
                    content.find('#as-slider-layout').val('fixed');
                    content.find('.as-full-width-block').hide();
                    content.find('#as-slider-startWidth').val('1280');
                    content.find('#as-slider-startHeight').val('650');
                    content.find('#as-slider-automaticSlide, #as-slider-pauseOnHover').val(1);
                    content.find('#as-slider-forcefullwidth, #as-slider-mobileCustomSize, #as-slider-randomSlide, #as-slider-background-type-color, #as-slider-shadow-type').val(0);
                    content.find('.wp-color-result').css('background-color','');
                    content.find('.as-slider-background-type-color-picker-input').val('');
                    content.find('.as-slider-default-shadow').attr('data-shadow-class','shadow1');
                    content.find('.as-shadow-list-wrapper').hide();
                    content.find('.as-shadow-list td').removeClass('active');
                    content.find('.as-shadow-list td:eq(0)').addClass('active');
                }
                else if(resetBlock == '#as-slider-loader'){
                    content.find('#as-slider-enableLoader').val(1);
                    content.find('#as-slider-loaderType').val(0);
                    content.find('.as-loader-def-block').css('display','table-row');
                    content.find('.as-loader-img-block').hide();
                    content.find('.as-slider-default-loader').attr('data-loader-style','loader1');
                    content.find('.as-loader-list-wrapper').hide();
                    content.find('.as-loader-list td').removeClass('active');
                    content.find('.as-loader-list td:eq(0)').addClass('active');
                }
                else if(resetBlock == '#as-slider-navigation'){
                    //Submenu settings
                    content.find('#as-slider-navigation').find('.as-inner-tab').removeClass('as-active');
                    content.find('#as-slider-navigation').find('.as-inner-tab:eq(0)').addClass('as-active');
                    content.find('#as-slider-navigation').find('.as-inner-full').hide();
                    content.find('#as-slider-navigation').find('#as-slider-arrows').css('display','table');
                    
                    //Arrows
                    content.find('#as-slider-arrows').find('#as-slider-enableArrows').val(1);
                    content.find('#as-slider-arrows').find('.as-arrows-block').show();
                    content.find('.as-slider-default-arrows').attr('data-arrows-style','control1');
                    content.find('.as-arrows-list-wrapper').hide();
                    content.find('.as-arrows-list td').removeClass('active');
                    content.find('.as-arrows-list td:eq(0)').addClass('active');
                    
                    
                    //Bullets
                    content.find('#as-slider-bullets').find('#as-slider-enableBullets').val(1);
                    content.find('#as-slider-bullets').find('.as-navbullets-block').show();
                    content.find('#as-slider-bullets').find('#as-slider-bulletsHOffset').val(0);
                    content.find('#as-slider-bullets').find('.as-navbullets-block').find('.btn-primary').removeClass('active');
                    content.find('#as-slider-bullets').find('input[name=bulletsHPosition][value="center"]').prop('checked',true);
                    content.find('#as-slider-bullets').find('input[name=bulletsHPosition][value="center"]').closest('.btn').addClass('active');
                    content.find('.as-slider-default-bullets').attr('data-bullets-style','navigation1');
                    content.find('.as-bullets-list-wrapper').hide();
                    content.find('.as-bullets-list td').removeClass('active');
                    content.find('.as-bullets-list td:eq(0)').addClass('active');
                    
                    //Swipe
                    content.find('#as-slider-misc').find('#as-slider-enableSwipe').val(1);
                    
                }
            }
            
            /**
             * Sends an array with the new or current slider options
            */
            function  avartansliderSaveSlider() {
                    var content = $('.as-admin .as-slider #as-slider-settings');
                    var final_options = new Array();
                    var loader_type = '';
                    var loader_style = '';
                    
                    if(content.find('#as-slider-loaderType').val() == 0){
                        loader_type = 'default';
                        loader_style = content.find('.as-slider-default-loader').attr('data-loader-style');
                    }
                    else
                    {
                        loader_type = 'none';
                    }
                    var control_style = content.find('.as-slider-default-arrows').attr('data-arrows-style');
                    var navigation_style = content.find('.as-slider-default-bullets').attr('data-bullets-style');
                    var options = {
                            layout : content.find('#as-slider-layout').val(),
                            startWidth : parseInt(content.find('#as-slider-startWidth').val()),
                            startHeight : parseInt(content.find('#as-slider-startHeight').val()),
                            automaticSlide : parseInt(content.find('#as-slider-automaticSlide').val()),
                            background_type_color : parseInt(content.find('#as-slider-background-type-color').val()) == 0 ? 'transparent' : content.find('.as-slider-background-type-color-picker-input').val() + "",
                            loader: {
                                            type: loader_type,
                                            style: loader_style,
                                    },
                            navigation : {
                                    arrows: {
                                        enable: parseInt(content.find('#as-slider-enableArrows').val()),
                                        style: control_style,
                                    },
                                    bullets: {
                                            enable: parseInt(content.find('#as-slider-enableBullets').val()),
                                            style: navigation_style,
                                            hPos:content.find('input[name="bulletsHPosition"]:checked').val(),
                                    }
                            },
                            enableSwipe : parseInt(content.find('#as-slider-enableSwipe').val()),
                            showShadowBar : content.find('#as-slider-shadow-type').val(),
                            shadowClass : parseInt(content.find('#as-slider-shadow-type').val()) == 1 ? content.find('.as-slider-default-shadow').attr('data-shadow-class') : '' ,
                            pauseOnHover : parseInt(content.find('#as-slider-pauseOnHover').val()),
                    };
                    final_options.push({"id":parseInt($('.as-admin .as-slider .as-save-settings').attr('data-id')),"name":$.trim(content.find('#as-slider-name').val()),"alias":$.trim(content.find('#as-slider-alias').val()),"slider_option":JSON.stringify(options)});
                    // Do the ajax call
                    jQuery.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : ajaxurl,
                            data : {
                                    // Is it saving or updating?
                                    action: $('.as-admin .as-slider').hasClass('as-add-slider') ? 'avartanslider_addSlider' : 'avartanslider_editSlider',
                                    nonce:avartanslider_translations.default_nonce,
                                    datas : final_options,
                            },
                            success: function(response) {
                                    // If adding a new slider, response will be the generated id, else will be the number of rows modified
                                    if(response !== false && response!='duplicate' && response!='') {
                                            // If is adding a slider, redirect
                                            if($('.as-admin .as-slider').hasClass('as-add-slider')) {
                                                    avartansliderShowMsg(avartanslider_translations.slider_generate,'success');
                                                    window.location.href = '?page=avartanslider&view=edit&id=' + response;
                                            }
                                            else
                                            {
                                                $('.as-slider-title').html(response);
                                                avartansliderShowMsg(avartanslider_translations.slider_save,'success');
                                            }    
                                    }
                                    else {
                                        if(response === false || response == '')
                                        {
                                            avartansliderShowMsg(avartanslider_translations.slider_error,'danger');
                                        }
                                        else if(response == 'duplicate'){
                                            avartansliderShowMsg(avartanslider_translations.slider_already_find+' "'+ $.trim(content.find('#as-slider-alias').val()) +'" '+avartanslider_translations.slider_exists,'danger');
                                        }
                                    }
                            },

                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    avartansliderShowMsg('Error saving slider!<br>Status:'+textStatus+' <br>Error:'+errorThrown,'danger');
                            }
                    });
            }

            /**
             * Sends an array with all the slides options
             * 
             * @param {integer} slide_id slide id
            */
            function  avartansliderSaveSlide() {
                    var slide_index = $('.as-admin .as-slide-tab').find('li.active').index();
                    var slide = $('.as-admin .as-slider #as-slides .as-slide:eq('+ slide_index +')');
                    var final_options = new Array();
                    
                    var content = slide.find('.as-slide-settings-list');
                    
                    final_options = getSlideSettings();

                    jQuery.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : ajaxurl,
                            data : {
                                    action: 'avartanslider_editSlide',
                                    nonce:avartanslider_translations.default_nonce,
                                    datas : final_options,
                            },
                            success: function(response) {
                                    if(response !== false && response!='') {
                                            if(response != 'update')
                                            {
                                                slide.find('.as-save-slide').attr('data-slide-id',response);
                                            }    
                                            avartansliderShowMsg(avartanslider_translations.slide_save,'success');
                                            avartansliderUpdateSlidePos()
                                                
                                    }
                                    else {
                                        avartansliderShowMsg(avartanslider_translations.slide_error,'danger');
                                    }
                            },

                            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                avartansliderShowMsg('Error saving slide!<br>Status:'+textStatus+' <br>Error:'+errorThrown,'danger');
                            }
                    });
            }

            /**
             * Delete Slide
             * 
             * @param {integer} del_slide_id slide id
            */
            function avartansliderDeleteSlide(del_slide_id){
                if(del_slide_id!='' && del_slide_id!=0 && del_slide_id!='0')
                {
                    // Get options
                    var options = {
                            id : parseInt(del_slide_id),
                    };
                    jQuery.ajax({
                        type : 'POST',
                        dataType : 'json',
                        url : ajaxurl,
                        data : {
                                action: 'avartanslider_deleteSlide',
                                nonce:avartanslider_translations.default_nonce,
                                datas : options,
                        },
                        success: function(response) {
                                if(response !== false && response!='') {
                                        avartansliderShowMsg(avartanslider_translations.slide_delete,'success');
                                        avartansliderUpdateSlidePos();
                                }
                                else {
                                    avartansliderShowMsg(avartanslider_translations.slide_delete_error,'danger');
                                }
                        },

                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                            avartansliderShowMsg('Error deleting slide!<br>Status:'+textStatus+' <br>Error:'+errorThrown,'danger');
                        }
                });
                }
                else
                {
                    avartansliderShowMsg(avartanslider_translations.slide_delete,'success');
                    avartansliderUpdateSlidePos();
                }
            }
            
            /**
             * Update all slide position
            */
            function avartansliderUpdateSlidePos(){
                var slide_postion = new Array();
                //to reset position of all slides
                var slides = $('.as-admin .as-slider #as-slides .as-slide');
                var i=0;
                slides.each(function(){
                    var slide_pos = $(this);
                    var slide_id_pos = slide_pos.find('.as-save-slide').attr('data-slide-id');
                    if(slide_id_pos!='' && slide_id_pos!=0 && slide_id_pos!='0'){
                        slide_postion.push({"position_pos":i,"slide_id_pos":slide_id_pos});
                        i++;
                    }
                });
                
                jQuery.ajax({
                        type : 'POST',
                        dataType : 'json',
                        url : ajaxurl,
                        data : {
                                action: 'avartanslider_updateSlidePos',
                                nonce:avartanslider_translations.default_nonce,
                                slide_pos_datas : (slide_postion.length > 0)?slide_postion:'',
                        },
                        success: function(response) {
                                if(response !== false && response!='') {
//                                        avartansliderShowMsg('Slides Position have been updated successfully.','success');
                                }
                                else {
                                    avartansliderShowMsg(avartanslider_translations.slide_update_position_error,'danger');
                                }
                        },

                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                            avartansliderShowMsg('Error updating slides position!<br>Status:'+textStatus+' <br>Error:'+errorThrown,'danger');
                        }
                });
            }
           
            /**
             * Delete particular slider
             * 
             * @param {object} content object of slider anchor
            */
            function  avartansliderDeleteSlider(content) {
                    // Get options
                    var options = {
                            id : parseInt(content.attr('data-delete')),
                    };

                    // Do the ajax call
                    jQuery.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : ajaxurl,
                            data : {
                                    action: 'avartanslider_deleteSlider',
                                    nonce:avartanslider_translations.default_nonce,
                                    datas : options,
                            },
                            success: function(response) {
                                    if(response !== false && response!='') {
                                        avartansliderShowMsg(avartanslider_translations.slider_delete,'success');
                                        window.location.href = '?page=avartanslider';
                                    }
                                    else {
                                        avartansliderShowMsg(avartanslider_translations.slider_delete_error,'danger');
                                    }
                            },

                            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                      avartansliderShowMsg('Error deleting slider!<br>Status:'+textStatus+' <br>Error:'+errorThrown,'danger');
                            },
                    });
            }
            
    });
})(jQuery);

jQuery(window).load(function(){
   jQuery('#subscribe_thickbox').trigger('click');
   jQuery("#TB_closeWindowButton").click(function() {
        jQuery.post(ajaxurl,
        {
            'action': 'close_tab'
        });
   });
});