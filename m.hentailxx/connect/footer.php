    </div>
  </div>
</div>
<div class="mt-4"></div>
<div id="goTop"><i class="fa fa-chevron-circle-up"></i></div>
<div id="topbanner" class="topbanner d-none" style="text-align:center;"></div>
<div id="catfish1" class="catfish1"></div>
<div id="anchor"></div>

<!--<script type="text/javascript">
(function (d, s, id) {
  if (d.getElementById(id)) { return; }

  var ads = "//lxhentai.com/assets/js/ads_vdc.js";
  var js, fjs = d.getElementsByTagName(s)[0];
  
  js = d.createElement(s); 
  js.type = "text/javascript";
  js.async = false;
  js.id = id;
  js.src = ads+"?t=" + new Date().getTime();
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "ads-banner"));
</script>-->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.10/jquery.autocomplete.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
</script>
<script type="text/javascript">
	var $chapterImgs = $('#content_chap img');
	$chapterImgs.eq(Math.floor(Math.random() * $chapterImgs.length)).after('<div><a href="http://bit.ly/lxhentai-gaixinh18-bottom-chapter-mobile" target="_blank"><img src="https://images2.imgbox.com/fd/3e/mLNbT6IN_o.gif" alt="Gai Xinh 18"></a></div>');
</script>
<script src="//lxhentai.com/assets/js/hentai.js?cachex=24"></script>
<script src="//lxhentai.com/assets/js/old.js?cachex=1"></script>
<script src="//lxhentai.com/assets/js/index.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.6/js/swiper.min.js"></script>
<script>
$(function(){
	var mySwiper = new Swiper ('.swiper-container', {
    // Optional parameters
    loop: true,
	autoplay: true,
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },

    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
  })
	 var lastScrollTop = 0, delta = 5;
	 $(window).scroll(function(){
		 var nowScrollTop = $(this).scrollTop();
		 if(Math.abs(lastScrollTop - nowScrollTop) >= delta){
		 	if (nowScrollTop > lastScrollTop){
				$('.header').css('position', 'relative');
		 		// ACTION ON
		 		// SCROLLING DOWN 
		 	} else {
				$('.header').css({'position': 'sticky', 'top' : 0});
		 		// ACTION ON
		 		// SCROLLING UP 
			}
		 lastScrollTop = nowScrollTop;
		 }
	 });
 });
 </script>
<?php 
	echo $script;
  
  close_mysql();
  close_redis();
?>
<script type="text/javascript">
    function deleteCookie(name) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }
    
    function getCookie(cname) {
        var name = cname + '=';
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return '';
    }

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 60 * 60 * 1000));
        var expires = 'expires=' + d.toGMTString();
        document.cookie = cname + '=' + cvalue + '; ' + expires + '; path=/';
    }

    function htxxPopUnder1() {
        if (getCookie("htxxpop1") == "") {
            setCookie('htxxpop1', 'hit', 23);
            window.open("http://bit.ly/lxhentai-bongdax-hotgirl", '_blank');
            window.focus();
        }
    }

    function htxxPopUnder2() {
        if (getCookie("htxxpop2") == "") {
            setCookie('htxxpop2', 'hit', 23);
            window.open("https://bit.ly/lxhentai-vbis-mobile-pop-2-v5", '_blank');
            window.focus();
        }
    }

    var pop1 = getCookie('popcount3') || 0;
    $('body').click(function(evt) {
      if (evt.target.id == "preload_banner") return false;
        if($(evt.target).closest('#preload_banner').length) return;
        if (pop1 < 4) {
          pop1++;
          setCookie('popcount3', pop1, 23);
          if (getCookie('popcount3') == 1) {
            htxxPopUnder1();
          }
          if (getCookie('popcount3') == 3) {
            htxxPopUnder2();
          }
        }
    });

$(document).ready(function() {
    if (getCookie('gxpreloadmobile') == "") {
        $('#preload-modal').modal({backdrop:'static',keyboard:false});
    }

    $('#preload-modal').on('hidden.bs.modal', function() {
        setCookie('gxpreloadmobile', 'pang', 23);
    });

    $('#content_chap img:nth-child(5)').after('<div class="text-center"><a href="http://bit.ly/lxhentai-gaixinh18-home" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/gaixinh3.gif" alt="Right Balloon"></a></div>');
});
</script>
<div id="float-top-1" class="sticky-footer top-sticky-one">
    <div class="sticky-footer-content"><a href="http://bit.ly/lxhentai-gaixinh18-home" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/gaixinh-320x50.gif" alt="Float Top"></a><span class="sticky-x-button sticky-x-button-top" onclick="$('#float-top-1').remove();">X</span></div>
</div>
<div id="mobile-catfish-1" class="sticky-footer visible-xs visible-sm">
    <div class="sticky-footer-content"><a href="https://bit.ly/hentai24h-vbis-mobile-catfish-2-v1" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/320x50-8live.gif" alt="Mobile CatFish 1"></a><span class="sticky-x-button" onclick="$('#mobile-catfish-1').remove();">X</span></div>
</div>
<div id="mobile-catfish-2" class="sticky-footer visible-xs visible-sm second-sticky-footer">
    <div class="sticky-footer-content"><a href="https://www.ysb3666.com/signup" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/banner-320x50-bet365.gif" alt="Mobile CatFish 2"></a><span class="sticky-x-button" onclick="$('#mobile-catfish-2').remove();">X</span></div>
</div>
<div id="mobile-catfish-3" class="sticky-footer visible-xs visible-sm third-sticky-footer">
    <div class="sticky-footer-content"><a href="https://rebrand.ly/66htlx" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/320x50-rio.gif" alt="Mobile CatFish 3"></a><span class="sticky-x-button" onclick="$('#mobile-catfish-3').remove();">X</span></div>
</div>
<div id="preload-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog preload-modal mobile-preload-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hot Hot!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <a id="modal-link" href="http://bit.ly/lxhentai-gaixinh18-home" target="_blank"><img src="//lxhentai.com/banners/gaixinh1.gif" alt="Preload"></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
