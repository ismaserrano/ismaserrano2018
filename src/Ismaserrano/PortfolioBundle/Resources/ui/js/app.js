var IsmaserranoPortfolioBundle = IsmaserranoPortfolioBundle || {};

IsmaserranoPortfolioBundle = (function($, window, undefined) {

    var init;
    var self = this;

    var queue = new createjs.LoadQueue(),
        $mainLoader = $('#main-loader');

    var checkDomain = function(url) {
        if ( url.indexOf('//') === 0 ) { url = location.protocol + url; }
        return url.toLowerCase().replace(/([a-z])?:\/\//,'$1').split('/')[0];
    };

    var isExternal = function(url) {
        return ( ( url.indexOf(':') > -1 || url.indexOf('//') > -1 ) && checkDomain(location.href) !== checkDomain(url) );
    };

    init = function() {
        cargobay.videolink.init();
        cargobay.scrollToTop.init();
        IsmaserranoPortfolioBundle.cookieConsent.init();

        // $('main[role="main"]').niceScroll();
        /* If not is AJAX request */
        // if(document.readyState === 'complete') {
        //     console.log("AJAX request");
        // } else {
        //     self.loadPageImgs();
        // }
        $('body a').each(function(el){
            var $this = $(this);
            if (isExternal($this.attr('href'))) {
                $this.attr('target', '_blank');
                $this.addClass('external');
            }
        });
        $('nav a:not(".external"), main[role="main"] a:not(".external")').on('click', function(e){
            var $this = $(this);
            self.requestUrl($this);
            e.preventDefault();
        });
        showContainer();
    };

    showContainer = function() {
        var $container = $('main[role="main"]');
        $container.velocity(
            "transition.slideUpIn",
            {
                opacity: 1,
                stagger: 250,
                drag: false,
                complete: function(){
                    $('main[role="main"] a').each(function (el) {
                        var $this = $(this);
                        if (isExternal($this.attr('href'))) {
                            $this.attr('target', '_blank');
                            $this.addClass('external');
                        }
                    });
                    $container.find('a:not(".external")').on('click', function (e) {
                        var $this = $(this);
                        self.requestUrl($this);
                        e.preventDefault();
                    });
                }
            }
        );
        loadPageImgs();
    };

    showLoader = function(action) {
        if (typeof action === 'undefined') action = 'show';
        if (action === 'show') {
            $mainLoader.css('left', '0px').velocity('fadeIn', { duration: 300 });
        } else {
            $mainLoader.velocity('fadeOut', { duration: 300 }, function(el){
                $(el).css('left', '-9999px');
            });
        }
    };

    requestUrl = function(el) {
        showLoader();
        $.ajax({
            url: $(el).attr('href'),
            // dataType: 'html',
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                //Upload progress
                xhr.upload.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with upload progress
                        console.log(percentComplete);
                    }
                }, false);
                //Download progress
                xhr.addEventListener("progress", function(evt){
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        //Do something with download progress
                        console.log(percentComplete);
                        $mainLoader.velocity({ width: percentComplete+'%' }, { duration: 100, delay: 50 });
                    }
                }, false);
                return xhr;
            },
            success:function(html){
                self.replaceContent(html, function(html) {
                    history.pushState({path: this.path}, '', $(el).attr('href'));
                    showLoader('hide');
                    // $('main[role="main"]').html(html);
                    showContainer();
                });
            },
            error: function(XMLHttpRequest,textStatus,errorThrown){
                alert(textStatus);
            },
            complete: function(html){
                // self.replaceContent(html, function(html) {
                //     history.pushState({path: this.path}, '', $(el).attr('href'));
                //     showLoader('hide');
                //     // $('main[role="main"]').html(html);
                //     showContainer();
                // });
            }
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

    replaceContent = function(html, callback){
        $('main[role="main"]').html(html);
        // document.write(html);
        // document.close();
        callback(html);
    };

    loadPageImgs = function(){
        var manifiest = [];
        queue.destroy();

        $.each($('.img-preload'), function (index, el) {
            // if (src.indexOf('http://')!=-1) {
            var $image = $(el).find('img');
            var $loader = $(el).find('.loader');
            $loader.css('opacity', 1);
            $loader.css('width', $image.width()+'px');
            $loader.css('height', $image.height()+'px');
            var temp = {
                id: index,
                src: $image.attr('src'),
                obj: $image,
                idHtml: $(el).attr('id')
            };
            manifiest.push(temp);
            // }
        });
        // queue.on('complete', function (event) {
        //     console.log(event);
        // });
        queue.on('fileload', function (event) {
            // $(event.item.obj).attr('src', event.item.src);
            $(event.item.obj).closest('.img-preload').find('.loader').velocity("fadeOut", { duration: 300 });
            $(event.item.obj).closest('.img-preload').velocity("fadeIn", { duration: 1000, delay: (200*event.item.id) });
        });
        queue.loadManifest(manifiest);
    };

    return {
        init: init
    };

}(jQuery, window));

$(function() {
    IsmaserranoPortfolioBundle.init();
});