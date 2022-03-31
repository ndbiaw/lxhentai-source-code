	<hr>
	Liên hệ quảng cáo: <a href="mailto:adsmediasun@gmail.com">adsmediasun@gmail.com</a>. <a href="//www.dmca.com/Protection/Status.aspx?ID=851fb2a4-378b-4888-8c9f-941aa82a9f58" title="DMCA.com Protection Status" class="dmca-badge"> <img src ="https://images.dmca.com/Badges/dmca-badge-w100-5x1-08.png?ID=851fb2a4-378b-4888-8c9f-941aa82a9f58" alt="DMCA.com Protection Status" /></a>  <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
 </div>
</main>
<div class="mt-4"></div>
<div id="goTop"><i class="fa fa-chevron-circle-up"></i></div>
<div id="topbanner" class="topbanner d-none" style="text-align:center;"></div>
<div id="catfish1" class="catfish1"></div>
<div id="anchor"></div>

<script id="_wauybh">var _wau = _wau || []; _wau.push(["tab", "iuduq6m3q9", "ybh", "bottom-right"]);</script><script async src="//waust.at/t.js"></script>
<!--<script type="text/javascript">
(function (d, s, id) {
  if (d.getElementById(id)) { return; }

  var is_mobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
  var ads = is_mobile ? "/assets/js/ads_vdc.js" : "/assets/js/ads.js";
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.6/js/swiper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.10/jquery.autocomplete.min.js"></script>
<script>
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
<script src="/assets/js/hentai.js?cachex=19"></script>
<script src="/assets/js/old.js?cachex=1"></script>
<script src="/assets/js/index.js?cachex=2"></script>
<?php 
	echo $script;
  $fp = @fopen(ROOT.'/dashboard/script.txt', 'r');  
  if($fp){
    echo fread($fp, filesize(ROOT.'/dashboard/script.txt'));
  }
  fclose($fp);

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

function pcPopUnder() {
    if (getCookie("htxxpcpop") == "") {
        setCookie('htxxpcpop', 'popthatshit', 23);
        pop = window.open("http://bit.ly/lxhentai-bongdax-hotgirl", '_blank');
        window.focus();
    }
}

function pcPopUnder2() {
    if (getCookie("htxxpcpop2") == "") {
        setCookie('htxxpcpop2', 'popthatshit', 23);
        pop = window.open("http://bit.ly/lxhentai-gaixinh18-home", '_blank');
        window.focus();
    }
}

var pop1 = getCookie('popcount2') || 0;
$('body').click(function(evt) {
	if (evt.target.id == "banner_preload") return false;
    if($(evt.target).closest('#banner_preload').length) return;
    if (pop1 < 4) {
	    pop1++;
	    setCookie('popcount2', pop1, 23);
	    if (getCookie('popcount2') == 1) {
	    	pcPopUnder();
	    }
	    if (getCookie('popcount2') == 3) {
	    	pcPopUnder2();
	    }
	}
});

$(document).ready(function() {
    if (getCookie('gxpreload2') == "") {
        $('#preload-modal').modal({backdrop:'static',keyboard:false});
    }

    $('#preload-modal').on('hidden.bs.modal', function() {
        setCookie('gxpreload2', 'pang', 23);
    });

    $('#content_chap img:nth-child(5)').after('<div class="text-center"><a href="http://bit.ly/lxhentai-gaixinh18-home" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/gaixinh3.gif" alt="Right Balloon"></a></div>');
});
</script>
<div id="b29-pc-catfish" class="sticky-footer pc-sticky-footer">
    <div class="sticky-footer-content sticky-pc-footer-content"><a href="http://bit.ly/lxhentai-b29" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/728x90-b29.gif" alt="PC CatFish"></a><span class="sticky-x-button" onclick="$('#b29-pc-catfish').remove();">X</span></div>
</div>
<div id="float-left" class="float-left">
    <a href="https://rebrand.ly/66htlx" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/120x600-rio.gif" alt="Float Left"></a>
    <span class="x-float-left" onclick="$('#float-left').remove();">Đóng</span>
</div>
<div id="float-right" class="float-right">
    <a href="https://rebrand.ly/66htlx" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/120x600-rio.gif" alt="Float Right"></a>
    <span class="x-float-right" onclick="$('#float-right').remove();">Đóng</span>
</div>
<div id="left-balloon" class="left-balloon">
    <a href="http://bit.ly/lxhentai-gaixinh18-home" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/gaixinh2.gif" alt="Left Balloon"></a>
    <span class="x-left-balloon" onclick="$('#left-balloon').remove();">Đóng</span>
</div>
<div id="right-balloon" class="right-balloon">
    <a href="http://bit.ly/lxhentai-gaixinh18-home" target="_blank" rel="nofollow"><img src="//lxhentai.com/banners/gaixinh3.gif" alt="Right Balloon"></a>
    <span class="x-right-balloon" onclick="$('#right-balloon').remove();">Đóng</span>
</div>
<div id="preload-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog preload-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hot Hot!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <a id="modal-link" href="http://bit.ly/lxhentai-bongdax-nhan-dinh" target="_blank"><img src="//lxhentai.com/banners/preload-soi-keo.gif" alt="Preload"></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
