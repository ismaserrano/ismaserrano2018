var IsmaserranoPortfolioBundle = IsmaserranoPortfolioBundle || {};

IsmaserranoPortfolioBundle = (function($, window, undefined) {

    var init;
    var self = this;
    var $loader = '<div class="loader"><svg version="1.1" id="loader" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"><path opacity="0.2" fill="#FFF" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/><path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0C22.32,8.481,24.301,9.057,26.013,10.047z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"/></path></svg></div>';

    var queue = new createjs.LoadQueue(),
        // queueProjects = new createjs.LoadQueue(),
        $mainLoader = $('#main-loader'),
        $bgContainer = $('#image-bg');
        // $bgContainerTemp = $('#image-bgTemp');

    var checkDomain = function(url) {
        if ( url.indexOf('//') === 0 ) { url = location.protocol + url; }
        return url.toLowerCase().replace(/([a-z])?:\/\//,'$1').split('/')[0];
    };

    var isExternal = function(url) {
        return ( ( url.indexOf(':') > -1 || url.indexOf('//') > -1 ) && checkDomain(location.href) !== checkDomain(url) );
    };

    var isAjax = false;
    var currentSlide = 0, timer, slideTime = 5000;

    var projectLoaded = false;
    var documentTitle = document.title;

    init = function() {
        // cargobay.videolink.init();
        // cargobay.scrollToTop.init();
        IsmaserranoPortfolioBundle.cookieConsent.init();

        if (typeof resourceMediaBg!=='undefined' && resourceMediaBg != '') {
            replaceBgByAjax(resourceMediaBg);
        }

        $('#menu-icon').on('click', function(e){
            var $this = $(this);
            var $menuOverlay = $('#overlay-menu');
            var liItems = $menuOverlay.find('li');
            $this.toggleClass('open');
            $menuOverlay.toggleClass('active');
            if ($this.hasClass('open')) {
                liItems.each(function (index, el) {
                    $(el).velocity({'margin-left': 0, opacity: 1}, {delay: (100*index)}, "easeInSine");
                });
            } else {
                liItems.each(function (index, el) {
                    $(el).velocity({'margin-left': 400, opacity: 0}, {delay: (100*index)}, "easeInSine");
                });
            }
            e.preventDefault();
        });

        $('#volume').on('click', function(e){
            var $this = $(this);
            var $icon = $this.find('i');
            if ($icon.hasClass('fa-volume-up')) {
                $icon.removeClass('fa-volume-up').addClass('fa-volume-off');
                IsmaserranoPortfolioBundle.bgEffect.setMusicVolume(0);
            } else {
                $icon.addClass('fa-volume-up').removeClass('fa-volume-off');
                IsmaserranoPortfolioBundle.bgEffect.setMusicVolume(1);
            }
            e.preventDefault();
        });
        
        $('a.enjoy').on('click', function(e){
            var $this = $(this);
            var $container = $('main[role="main"]');
            var $menuIcon = $('#menu-icon');
            if ($menuIcon.hasClass('open')) $menuIcon.click();
            if (!$container.hasClass('hidden')) {
                $container.velocity(
                    "transition.slideDownOut",
                    {
                        opacity: 0,
                        stagger: 250,
                        drag: false,
                        complete: function(){
                            $this.text($this.attr('data-text-active'));
                        }
                    }
                );
                $container.addClass('hidden');
            } else {
                $container.velocity(
                    "transition.slideUpIn",
                    {
                        opacity: 0,
                        stagger: 250,
                        drag: false,
                        complete: function(){
                            $this.text($this.attr('data-text-default'));
                        }
                    }
                );
                $container.removeClass('hidden');
            }
            e.preventDefault();
        });

        // $('main[role="main"]').niceScroll();
        /* If not is AJAX request */
        // if(document.readyState === 'complete') {
        //     console.log("AJAX request");
        // } else {
        //     self.loadPageImgs();
        // }
        // $('body a').each(function(el){
        //     var $this = $(this);
        //     if (isExternal($this.attr('href'))) {
        //         $this.attr('target', '_blank');
        //         $this.addClass('external');
        //     }
        // });
        // $('nav a:not(".external"), main[role="main"] a:not(".external")').on('click', function(e){
        //     var $this = $(this);
        //     self.requestUrl($this);
        //     e.preventDefault();
        // });
        // showContainer();
        // if (typeof projectImages === 'undefined') {
        if ($('#project-detail').length > 0) {
            setProjectBg(function(){
                loadPageImgs(true);
            });
        } else {
            loadPageImgs();
        }

        $(window).on('popstate', function (event) {
            // var state = e.originalEvent.state;
            // if (state !== null) {
            //     console.log(state);
            // }
            requestUrl(null, document.location.href);
        });
        // } else {
        //     loadProjectBg();
        // }
    };

    addToQueue = function(el){
        var $image = $(el).find('img');
        var bgUrl = $(el).css('background-image').replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
        var imgSrc = $image.attr('data-src') ? $image.attr('data-src') : bgUrl;
        var $obj = $image.attr('data-src') ? $image : $(el);
        var temp = {
            id: (manifiest.length - 1),
            src: imgSrc,
            obj: $obj,
            idHtml: $(el).attr('id')
        };
        manifiest.push(temp);
    };

    replaceBgByAjax = function(src){
        $bgContainer.attr('data-background-image', src);
    };

    showContainer = function(action, callback) {
        if (typeof action === 'undefined') action = 'show';
        var $container = $('main[role="main"]');
        if (action === 'show') {
            $container.velocity(
                "transition.slideUpIn",
                {
                    opacity: 1,
                    stagger: 250,
                    drag: false,
                    complete: function () {
                        // $('main[role="main"] a').each(function (el) {
                        //     var $this = $(this);
                        //     if (isExternal($this.attr('href'))) {
                        //         $this.attr('target', '_blank');
                        //         $this.addClass('external');
                        //     }
                        // });
                        // $container.find('a:not(".external")').on('click', function (e) {
                        //     var $this = $(this);
                        //     self.requestUrl($this);
                        //     e.preventDefault();
                        // });
                        $('body a').each(function (index, el) {
                            var $this = $(el);
                            if (typeof $this.attr('href') !== 'undefined') {
                                if (isExternal($this.attr('href'))) {
                                    $this.attr('target', '_blank');
                                    $this.addClass('external');
                                }
                            }
                        });
                        $('nav a:not(".external, .no-nav"), main[role="main"] a:not(".external, .no-nav")').off('click');
                        $('nav a:not(".external, .no-nav"), main[role="main"] a:not(".external, .no-nav")').on('click', function (e) {
                            var $this = $(this);
                            var $menuIcon = $('#menu-icon');
                            if ($menuIcon.hasClass('open')) $menuIcon.click();
                            self.requestUrl($this);
                            e.preventDefault();
                        });
                    }
                }
            );
        } else if (action === 'hide') {
            $container.velocity(
                "transition.slideDownOut",
                {
                    opacity: 0,
                    stagger: 250,
                    drag: false,
                    complete: function () {
                        callback();
                    }
                }
            );
        }
        // loadPageImgs();
    };

    showLoader = function(action, callback) {
        if (typeof action === 'undefined') action = 'show';
        if (action === 'show') {
            $mainLoader.css('width', '0');
            $mainLoader.css('left', '0px').velocity('fadeIn', { duration: 300 });
        } else {
            $mainLoader.velocity('fadeOut', { duration: 300, complete: function(el){ $(el).css('left', '-9999px'); callback(); } });
        }
    };

    requestUrl = function(el, type) {
        if (typeof type === 'undefined') type = '';
        var ajaxUrl = $(el).attr('href');
        var ajaxTitle = $(el).attr('title');
        if (type !== '') {
            ajaxUrl = type;
            ajaxTitle = '';
        }
        // stopSlidesAndClear();
        showLoader('show', null);
        showContainer('hide', function() {
            $.ajax({
                type: "GET",
                url: ajaxUrl,
                cache: false,
                async: true,
                // dataType: 'html',
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    //Upload progress
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            //Do something with upload progress
                            console.log(percentComplete);
                        }
                    }, false);
                    //Download progress
                    xhr.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            //Do something with download progress
                            // console.log(percentComplete);
                            $mainLoader.velocity({width: percentComplete + '%'}, {duration: 100});
                        }
                    }, false);
                    return xhr;
                },
                success: function (html) {
                    $mainLoader.velocity({width: '100%'}, {duration: 100});
                    self.replaceContent(html, function (html) {
                        // if (typeof projectImages === 'undefined') {
                        //     if ($bgContainer.find('canvas').css('opacity') === '0') {
                        //         $bgContainer.find('canvas').velocity("fadeIn", {duration: 300});
                        //         IsmaserranoPortfolioBundle.bgEffect.animate();
                        //     }
                            if ($('#project-detail').length > 0) {
                                setProjectBg(function(){
                                    loadPageImgs(true);
                                });
                            } else {
                                loadPageImgs();
                            }
                        // } else {
                        //     $bgContainer.find('canvas').velocity("fadeOut", {duration: 300});
                        //     IsmaserranoPortfolioBundle.bgEffect.stopAnimate();
                        //     loadProjectBg();
                        // }
                        if (type === '') {
                            var tempDocumentTitle = documentTitle.split(' - ');
                            history.pushState({path: this.path}, tempDocumentTitle[0]+' - '+$(el).attr('title'), $(el).attr('href'));
                            document.title = tempDocumentTitle[0]+' - '+$(el).attr('title');
                            documentTitle = document.title;
                        }
                        // showLoader('hide');
                        // showContainer();
                    });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                },
                complete: function (html) {
                    // self.replaceContent(html, function(html) {
                    //     history.pushState({path: this.path}, '', $(el).attr('href'));
                    //     showLoader('hide');
                    //     // $('main[role="main"]').html(html);
                    //     showContainer();
                    // });
                }
            });
        });

        // queue.on('complete',     onComplete);
        // queue.on('error',        onError);
        // queue.on('fileload',     onFileLoad);
        // queue.on('fileprogress', onFileProgress);
        // queue.on('progress',     onProgress);

        // queue.loadManifest([
        //     {
        //         id:   '1',
        //         src:  $(el).attr('href')
        //     }
        // ]);



        // function onComplete(event) {
        //     console.log('Complete', event);
        //     $state.text( $state.text() + '[All loaded]' );
        //     $progressbar.addClass('complete');
        //     console.log(event)
        //
        //     history.pushState({ path: this.path }, '', $(el).attr('href'));
        // }

        // function onError(event) {
        //     console.log('Error', event);
        //     $state.text( $state.text() + '[' + event.item.id + ' errored] ');
        // }

        // function onFileLoad(event) {
        //     // console.log('File loaded', event);
        //     // $state.text( $state.text() + '[' + event.item.id + ' loaded] ');
        //     setTimeout(function(){
        //         document.write(event.result);
        //         document.close();
        //     }, 500);
        // }
        //
        // function onFileProgress(event) {
        //     // console.log('File progress', event);
        // }
        //
        // function onProgress(event) {
        //     var progress = Math.round(event.loaded * 100);
        //
        //     console.log('General progress', Math.round(event.loaded) * 100, event);
        //     $progress.text(progress + '%');
        //     $progressbar.css({
        //         'width': progress + '%'
        //     });
        // }

    };

    setProjectBg = function(callback) {
        // $bgContainer.attr('data-background-image', $('#project-detail').attr('data-project-bg'));
        callback();
    };

    replaceContent = function(html, callback){
        $('main[role="main"]').html(html);
        // document.write(html);
        // document.close();
        callback(html);
    };

    loadPageImgs = function(projectLoadBool){
        if (typeof projectLoadBool === 'undefined') projectLoadBool = false;
        var manifiest = [];
        queue.destroy();

        projectLoaded = projectLoadBool;

        showLoader('hide', function(){
            showContainer('show', null);
        });

        $.each($('.img-preload'), function (index, el) {
            // if (src.indexOf('http://')!=-1) {
            var $image = $(el).find('img');
            var bgUrl = $(el).attr('data-background-image') ? $(el).attr('data-background-image') : ''; //$(el).css('background-image').replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
            // var bgUrl = ($(el).attr('data-background-image')!='') ? $(el).css('background-image').replace(/^url\(["']?/, '').replace(/["']?\)$/, '') : '';
            var imgSrc = $image.attr('data-src') ? $image.attr('data-src') : bgUrl;
            var $obj = $image.attr('data-src') ? $image : $(el);
            if ($image.attr('data-src')){
                if ($image.closest('.img-preload').find('.loader').length <= 0){
                    $image.closest('.img-preload').prepend($loader);
                }
                $image.closest('.img-preload').find('.loader').velocity('fadeIn', {duration: 300});
            } else {
                if ($obj.find('.loader').length <= 0){
                    $obj.prepend($loader);
                }
            }
            // $loader.css('opacity', 1);
            // $loader.css('width', $image.width()+'px');
            // $loader.css('height', $image.height()+'px');
            if (imgSrc!='') {
                var temp = {
                    id: index,
                    src: imgSrc,
                    obj: $obj,
                    idHtml: $(el).attr('id') ? $(el).attr('id') : ''
                };
                manifiest.push(temp);
            }
            // }
        });

        // queue.on('complete', function (event) {
        //     console.log(event);
        // });
        queue.on('fileload', function (event) {
            // $(event.item.obj).attr('src', event.item.src);
            if (typeof event.item.idHtml !== 'undefined') {
                if (event.item.idHtml != 'image-bg') {
                    $(event.item.obj).closest('.img-preload').find('img').attr('src', event.item.src);
                } else {
                    if (!isAjax) {
                        IsmaserranoPortfolioBundle.bgEffect.setBgFile(event.item.src, function () {
                            IsmaserranoPortfolioBundle.bgEffect.init(function() {
                                IsmaserranoPortfolioBundle.bgEffect.loadMusic();
                                if (projectLoaded) {
                                    IsmaserranoPortfolioBundle.bgEffect.projectTexture();
                                }
                                IsmaserranoPortfolioBundle.bgEffect.animate();
                                isAjax = true;
                            });
                        });
                    } else {
                        IsmaserranoPortfolioBundle.bgEffect.setBgFile(event.item.src, function () {
                            if (projectLoaded) {
                                IsmaserranoPortfolioBundle.bgEffect.projectTexture();
                            } else {
                                IsmaserranoPortfolioBundle.bgEffect.updateTexture();
                            }
                        });
                    }
                    // setTimeout(function(){ IsmaserranoPortfolioBundle.bgEffect.stopAnimate(); }, 3000);

                    // $(event.item.obj).css('background-image', 'url("' + event.item.src + '")');
                }
            }
            $(event.item.obj).closest('.img-preload').find('.loader').velocity("fadeOut", { duration: 300, complete: function(el){ $(el).remove(); } });
            $(event.item.obj).closest('.img-preload').find('.img-inside-container').velocity("fadeIn", { duration: 1000, delay: (200*event.item.id) });
            // console.log(event.item);
        });
        // queue.on('complete', function(event){
        //     showLoader('hide', function(){
        //         showContainer('show', null);
        //     });
        // });
        queue.loadManifest(manifiest);
    };

    // loadProjectBg = function() {
    //     var manifiest = [];
    //     queueProjects.destroy();
    //     currentSlide = 0;
    //
    //     if ($bgContainer.find('.loader').length <= 0){
    //         $bgContainer.prepend($loader);
    //     }
    //
    //     $.each(projectImages, function (index, el) {
    //         var temp = {
    //             id: index,
    //             src: el
    //         };
    //         manifiest.push(temp);
    //     });
    //
    //     queueProjects.on('fileload', function (event) {
    //         if (event.item.id === 0) {
    //             showLoader('hide', function(){
    //                 showContainer('show', null);
    //                 loadSlides();
    //             });
    //         }
    //         $bgContainer.find('.loader').velocity("fadeOut", { duration: 300, complete: function(el){ $(el).remove(); } });
    //         $bgContainerTemp.find('.loader').velocity("fadeOut", { duration: 300, complete: function(el){ $(el).remove(); } });
    //     });
    //     queueProjects.loadManifest(manifiest);
    // };
    //
    // loadSlides = function() {
    //     $bgContainer.css('background-image', 'url("' + projectImages[currentSlide] + '")');
    //     if (projectImages.length > 1) {
    //         timer = setInterval(function () {
    //             currentSlide++;
    //             if (currentSlide == projectImages.length) {
    //                 currentSlide = 0;
    //             }
    //             if (currentSlide % 2 !== 0) {
    //                 $bgContainerTemp.css('background-image', 'url("' + projectImages[currentSlide] + '")');
    //                 $bgContainerTemp.velocity("fadeIn", {
    //                     duration: 2000
    //                 });
    //                 $bgContainer.velocity("fadeOut", {
    //                     duration: 2000
    //                 });
    //             } else {
    //                 $bgContainer.css('background-image', 'url("' + projectImages[currentSlide] + '")');
    //                 $bgContainer.velocity("fadeIn", {
    //                     duration: 2000
    //                 });
    //                 $bgContainerTemp.velocity("fadeOut", {
    //                     duration: 2000
    //                 });
    //             }
    //         }, slideTime);
    //     }
    // };
    //
    // stopSlidesAndClear = function() {
    //     $bgContainer.find('.loader').remove();
    //     $bgContainerTemp.find('.loader').remove();
    //     projectImages = undefined;
    //     $bgContainer.css('background-image', '');
    //     $bgContainer.css('opacity', 1);
    //     $bgContainerTemp.css('background-image', '');
    //     clearInterval(timer);
    //     timer = null;
    // };

    return {
        init: init,
        replaceBgByAjax: replaceBgByAjax
    };

}(jQuery, window));

$(function() {
    IsmaserranoPortfolioBundle.init();
});