var list_pop = [];
/*
list_pop = [{
		link: 'https://bit.ly/lxhentai-maxgid-mobile-pop',
		cookie: 'popupmobile1'
	}];
*/
var list_catfish2 = [
    {
        link: "https://bit.ly/lxhentai-maxgid-mobile-catfish-1",
        image: "//lxhentai.com/assets/banners/zo-320x50.gif"
    }
];
var list_catfish1 = [
{
        link: "https://gamezo.win/?utm_source=lxhentai.com&utm_medium=mobiletop&utm_campaign=ken&re=1",
        image: "https://images2.imgbox.com/d6/ee/sGkIRPiF_o.gif"
    }
    
];
var list_catfish3 = [
    {
        link: "http://bit.ly/lxhentai-hee-mobile-catfish-v3",
        image: "//lxhentai.com/assets/images/catfish3.gif"
    }
];
var list_catfish4 = [
    {
        link: "http://bit.ly/lxhentai-bongdax-tructiep",
        image: "//lxhentai.com/assets/hentai/mobile-catfish-2.gif"
    }
];
var lst_topbanner1 = [
    {
        link: "http://bit.ly/hentailx-go88-mobile-top-v1",
        image: "//lxhentai.com/assets/images/1st_topbanner1.gif"
    }];
var lst_topbanner2=[
{
    link: "http://bit.ly/hentailx-hee-mobile-top-banner-2",
    image: "//lxhentai.com/assets/images/1st_topbanner2.gif"
}];
var lst_topbanner3 =
[{
    link: "http://bit.ly/lxhentai-fabet-mobile-top-3-v1",
    image: "//lxhentai.com/assets/images/1st_topbanner3.gif"
}
];
var cookiepopup = "popuptab";
var lst_preload = [
{
    link: "https://bit.ly/lxhentai-gaixinh18-mobile-preload",
    image: "https://images2.imgbox.com/f5/06/v3Agpljw_o.gif",
    cookie: "mobilepreload2"
}
]
function closepreload(cookie) {
    $("#preload_banner").remove();
	window.open('http://bit.ly/lxhentai-bongdax-hotgirl', '_blank');
	window.focus();
	// btpop();
    setCookie(cookie, true, 20);
}
function closeCatfish() {
    $('.catfish1').remove();
    setCookie("closecatfish1", "true", 0.5);
}
function getRandomCatfish(max) {
    return Math.floor(Math.random() * Math.floor(max));
}
function setQuangCaoTopBanner() {
    var stemplate = '<a href="XX_LINK_XX" target="_blank">' +
		'<img style="width:94%;height:70px;" src="XX_IMAGE_XX"/>' +
	'</a>';
    var top = document.getElementById("topbanner");
    var sinteru = getQuangCao(stemplate, lst_topbanner1);
    sinteru += getQuangCao(stemplate, lst_topbanner2);
    sinteru += getQuangCao(stemplate, lst_topbanner3);
    
    top.innerHTML = sinteru;
}
function getQuangCao(stem, adobj) {
    var index = getRandomCatfish(adobj.length);
    return stem.replace("XX_LINK_XX", adobj[index].link).replace("XX_IMAGE_XX", adobj[index].image);;
}
var tmp_preload = '<div id="preload_banner" style=" position: fixed;max-width: 80%;top: 15%; left: 10%;"><div id="close" onclick="closepreload(\'XX_COOKIE_XX\')" style=" position: absolute;right: 5px;top: 0px;font-size: 35px;height: 40px;color: #efefef;"> <strong style="color:red">X</strong></div><a href="XX_LINK_XX" target="_blank"><img style=" max-width: 100%;" src="XX_IMAGE_XX" /></a></div>';

function getAds(tmp, adsObjct) {
    var index = getRandomCatfish(adsObjct.length);
    var shtml = "";

    if (getCookie(adsObjct[index].cookie) == "") {
        shtml = tmp.replace('XX_LINK_XX', adsObjct[index].link).replace('XX_IMAGE_XX', adsObjct[index].image).replace("XX_COOKIE_XX", adsObjct[index].cookie);
        if (adsObjct[index].cookie.indexOf("preload") > -1) {
            
        }
    } else {
        for (var i = 0; i < adsObjct.length; i++) {
            if (getCookie(adsObjct[index].cookie) == "") {
                shtml = tmp.replace('XX_LINK_XX', adsObjct[index].link).replace('XX_IMAGE_XX', adsObjct[index].image).replace("XX_COOKIE_XX", adsObjct[index].cookie);
                
                break;
            }
        }
    }

    return shtml;
}
function setQuangCaoPreLoad() {
    var url = window.location.href;
    if (url.indexOf(".html") > 0) {
        return;
    }

    if (lst_preload.length == 0) return;

    var htmlproload = getAds(tmp_preload, lst_preload);
    setCookie(cookiepopup, "true", (1 / 360));
    $("body").append(htmlproload);
}
function setQcCatfish() {
    //if (getCookie("closecatfish1") == "") {
        var stemplate = '<div class="span">' +
            '<span onclick="closeCatfish()"  class="text_content">Đóng</span>' +
        '</div>' +
        '<a href="XX_LINK2_XX" target="_blank" style="margin-bottom:3px;display: block;">' +
            '<img style="width:100%;height:50px;" src="XX_IMAGE_2_XX" />' +
        '</a>' +
		'<a href="XX_LINK25_XX" target="_blank" class="">' +
            '<img style="width:100%;height:50px;"  src="XX_IMAGE_25_XX" />' +
        '</a>' +
        '<a href="XX_LINK1_XX" target="_blank" class="d-none">' +
            '<img style="width:100%;height:50px;"  src="XX_IMAGE_1_XX" />' +
        '</a>' +
        '<a href="XX_LINK3_XX" target="_blank" class="d-none">' +
            '<img style="width:100%;height:50px;"  src="XX_IMAGE_3_XX" />' +
        '</a>';
        var cat1 = list_catfish1[getRandomCatfish(list_catfish1.length)];
        var cat2 = list_catfish2[getRandomCatfish(list_catfish2.length)];
var cat3 = list_catfish3[getRandomCatfish(list_catfish3.length)];
var cat4 = list_catfish4[getRandomCatfish(list_catfish4.length)];
        var stemplate2 = stemplate.replace("XX_LINK1_XX", cat1.link)
            .replace("XX_IMAGE_1_XX", cat1.image).replace("XX_LINK2_XX", cat2.link)
            .replace("XX_IMAGE_2_XX", cat2.image).replace("XX_LINK3_XX", cat3.link)
            .replace("XX_IMAGE_3_XX", cat3.image).replace("XX_LINK25_XX", cat4.link)
            .replace("XX_IMAGE_25_XX", cat4.image);

        var cats = document.getElementById("catfish1");
        cats.innerHTML = stemplate2;
   // }

    var templace = '<iframe src="/images/ads_300_1.html" width="300" height="250" frameborder="0" scrolling="no"></iframe>';
    $("#truyenhot").append(templace);
}
function popunder1(stt) {

    if (getCookie(list_pop[stt].cookie) == "" && getCookie(cookiepopup) == "") {
        setCookie(list_pop[stt].cookie, 'dapopup', 23);
        pop = window.open(list_pop[stt].link, '_blank');
        // pop.blur();
        window.focus();
    }
}

function btpop() {
    var x = getRandomCatfish(list_pop.length);
    // popunder1(x);
}
$(function () {

    $('body').click(function (e) {
        // btpop();
    });
    setQuangCaoTopBanner();
    setQcCatfish();
    setQuangCaoPreLoad();
});
