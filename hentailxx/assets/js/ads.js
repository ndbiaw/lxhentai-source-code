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

function closeAds() {
    $('#floatleft').remove();
    $('#floatright').remove();
    $('#ballon_left').remove();
    $('#ballon_right').remove();
}
function closeAdFloatLeft(cookie) {
    $('#floatleft').remove();
    setCookie(cookie, "true", 1);
}
function closeAdFloatRight(cookie) {
    $('#floatright').remove();
    console.log(cookie);
    setCookie(cookie, "true", 1);
}
function closeAdBalloonLeft(cookie) {
    $('#ballon_left').remove(); console.log(cookie);
    setCookie(cookie, "true", 1);
}
function closeAdBalloonRight(cookie) {
    $('#ballon_right').remove(); console.log(cookie);
    setCookie(cookie, "true", 1);
}
function closebannerpreload(cookie) {
    $('#banner_preload').remove();
    setCookie(cookie, "true", 2);
}
var lst_qc_float_left = [{
    link: "http://bit.ly/2PlBCtv",
    image: "//lxhentai.com/assets/banners/120x600-sbo.gif",
    cookie: "floatleft1_2"
}
];
var lst_qc_float_right = [{
    link: "http://bit.ly/2PlBCtv",
    image: "//lxhentai.com/assets/banners/120x600-sbo.gif",
    cookie: "floatright1_2"
}
];
var lst_qc_ballon_left = [{
    link: "https://bit.ly/lxhentai-maxgid-balloon-left",
    image: "//lxhentai.com/assets/banners/300x250-vic.gif",
    cookie: "blleft1_1"
}];
var lst_qc_ballon_right = [{
    link: "https://bit.ly/lxhentai-maxgid-balloon-right",
    image: "//lxhentai.com/assets/banners/300x250-vic.gif",
    cookie: "blright1_1"
}];
var lst_qc_topbanner1 = [{
    link: "http://bit.ly/lxhentai-gaixinh18-top-pc",
    image: "https://4.bp.blogspot.com/-4DxPKwY6m9I/XSxR0OhLTGI/AAAAAAAACpY/KzrXD_W1_Eo23ewytNxalIYHCqCbBM4nACLcBGAs/s1600/gaixinh728x90.gif",
    cookie: "topbanner1_1"
}];
var lst_qc_topbanner3 = [];
var lst_qc_topbanner2 = [{
    link: "http://bit.ly/hentailx-go88-pc-top-v1",
    image: "https://1.bp.blogspot.com/-UAlbavVwkUg/XaXd3cCJ7dI/AAAAAAAACd8/sEt1MFnqTv4Udg8UCU4Y5ijRQ8peJLXzgCLcBGAsYHQ/s1600/728x90.gif",
    cookie: "topbanner1_1"
}];
var lst_qc_preload= [{
    link: "https://bit.ly/hentaixx-maxgid-preload-pc",
    image: "//lxhentai.com/assets/banners/600x400-ric.gif",
    cookie: "preload1_1"
}];
var tmp_qc_float_left = '<div id="floatleft" style="position: fixed;top: 0px;z-index:5;left: 0;"><div style="background: #3f94d5;color: #fff;padding: 2px;text-align: center;" onclick="closeAdFloatLeft(\'XX_COOKIE_XX\');">Đóng quảng cáo</div><a href="XX_LINK_XX" target="_blank"><img src="XX_IMAGE_XX"> </a>  </div>';
var tmp_qc_float_right = '<div id="floatright" style="position: fixed;top: 0px;z-index:5;right: 0;"><div style="background: #3f94d5;color: #fff;padding: 2px;text-align: center;" onclick="closeAdFloatRight(\'XX_COOKIE_XX\');">Đóng quảng cáo</div><a href="XX_LINK_XX" target="_blank"><img src="XX_IMAGE_XX"></a></div>';
var tmp_qc_ballon_left = '<div id="ballon_left" style="position: fixed;bottom: 0;z-index:6;left: 0;"><div style="position:relative;"><span onclick="closeAdBalloonLeft(\'XX_COOKIE_XX\');" style="position: absolute;top: -30px;right: 0;background: #18434e;color: #fff;width: 30px;height: 30px;text-align: center;font-size: 22px;cursor: pointer;line-height: 30px;">×</span></div><a href="XX_LINK_XX" target="_blank"><img src="XX_IMAGE_XX"></a></div>';
var tmp_qc_ballon_right = '<div id="ballon_right" style="position: fixed;bottom: 0;z-index:6;right: 0;"><div style="position:relative;"><span onclick="closeAdBalloonRight(\'XX_COOKIE_XX\')" style="position: absolute;top: -30px;right: 0;background: #18434e;color: #fff;width: 30px;height: 30px;text-align: center;font-size: 22px;cursor: pointer;line-height: 30px;">×</span></div><a href="XX_LINK_XX"><img src="XX_IMAGE_XX"></a></div>';
var tmp_qc_topbanner = '<a href="XX_LINK_XX" target="_blank"><img src="XX_IMAGE_XX"> </a> ';
var tmp_qc_bannerpreload = '<div id="banner_preload" style="position: fixed;top: calc(50% - 240px);left: calc(50% - 320px); z-index: 10;"><div class="button_x" onclick="closebannerpreload(\'XX_COOKIE_XX\')" style="position: absolute; right: 10px;font-size: 27px;color: #eee;border: solid 2px #eee;height: 40px; width: 40px; text-align: center;line-height: 40px; cursor: pointer; z-index: 11; top: 10px;"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></div><a target="_blank" href="XX_LINK_XX"><img src="XX_IMAGE_XX" /></a></div>';

function getAds(tmp, adsObjct) {
    var index = getRandommax(adsObjct.length);
    var shtml = "";
    if(adsObjct.length==0) return "";
    if (getCookie(adsObjct[index].cookie) == "") {
        shtml=  tmp.replace('XX_LINK_XX', adsObjct[index].link).replace('XX_IMAGE_XX', adsObjct[index].image).replace("XX_COOKIE_XX",adsObjct[index].cookie);
        if (adsObjct[index].cookie.indexOf("preload") > -1) {
            $("body").click(function () {
                closebannerpreload(adsObjct[index].cookie);
            });
        }
    } else {
        for (var i = 0; i < adsObjct.length; i++) {
            if (getCookie(adsObjct[index].cookie) == "") {
                shtml = tmp.replace('XX_LINK_XX', adsObjct[index].link).replace('XX_IMAGE_XX', adsObjct[index].image).replace("XX_COOKIE_XX", adsObjct[index].cookie);
                if (adsObjct[index].cookie.indexOf("preload") > -1) {
                    $("body").click(function () {
                        closebannerpreload(adsObjct[index].cookie);
                    });
                }
                break;
            }
        }
    }
     
    return shtml;
}

function setupads() {
    var shtml = getAds(tmp_qc_ballon_left, lst_qc_ballon_left);
    shtml += getAds(tmp_qc_ballon_right, lst_qc_ballon_right);
    
    var url = window.location.href;
   // if (url.indexOf("/doc-truyen/")<0) {
        shtml += getAds(tmp_qc_float_left, lst_qc_float_left);
        shtml += getAds(tmp_qc_float_right, lst_qc_float_right);
    //}
    //chỉ hiển thị ở trang chủ
    //if(url.indexOf(".html")<0){
       shtml+=getAds(tmp_qc_bannerpreload,lst_qc_preload);
 	//setCookie("popupdelay", "true", (12 / 3600));
    //}
    var stopbanner = getAds(tmp_qc_topbanner, lst_qc_topbanner1);
    stopbanner += getAds(tmp_qc_topbanner, lst_qc_topbanner2);
stopbanner += getAds(tmp_qc_topbanner, lst_qc_topbanner3);

    $("body").append(shtml);
    $("#topbanner").html(stopbanner);
    
}
function getRandommax(max) {
    return Math.floor(Math.random() * Math.floor(max));
}
setupads();
