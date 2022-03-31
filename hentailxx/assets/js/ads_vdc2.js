var list_catfish1 = [
    {
        link: "http://bit.ly/hentailx-sunwin-mobile-catfish",
        image: "https://3.bp.blogspot.com/-7ma6ClthwM8/XMMjHrpfG2I/AAAAAAAACm0/yO-VPCXJ7O4zhkMSaH2UViuogHBz7acSgCLcBGAs/s1600/320x50.gif"
    }
];
var list_catfish2 = [
    {
        link: "http://bit.ly/hentailx-hee-mobile-catfish-2",
        image: "https://4.bp.blogspot.com/-MiTQk4YiWio/XKtunQXzXAI/AAAAAAAAJSM/WdCLYFcn9lcD9f6A0spG2H7Gx3YBQR5SACLcBGAs/s1600/mobile-catfish-2-320x50.gif"
    }
];

var lst_topbanner1 = [
    {
        link: "http://bit.ly/hentailx-one88-mobile-top-banner",
        image: "https://2.bp.blogspot.com/-UD7tYfqcM1s/XJCHJsVUydI/AAAAAAAAIxo/Xv0Uy2jvjsIsjGKoTHzyXWhhHp_qeRblACLcBGAs/s1600/320x50.gif"
    }];
var lst_topbanner2=[
{
    link: "http://bit.ly/hentailx-hee-mobile-top-banner-2",
    image: "https://3.bp.blogspot.com/-hnqmxw9t_FM/XKtunXaH-9I/AAAAAAAAJSI/GRmBG7QxhnAXZOs1Ttsx6fzyJg4vL0SawCLcBGAs/s1600/mobile-top-banner-2-320x50.gif"
}];
var lst_topbanner3 =
[{
    link: "http://11bet.tv/vn#utm_source=truyensieuhay&utm_medium=m-topbanner1",
    image: "https://4.bp.blogspot.com/-hw4CqzTPEsM/XEaHmcBn2hI/AAAAAAAAG14/C_5GSLR75C8ETJ7zmIUeDAhzeVGt6iqmQCLcBGAs/s1600/320x70-11b.gif"
},
{
    link: "https://one88.fun/vi/khuyen-mai.aspx?utm_source=truyensieuhay.com&utm_medium=banner&utm_campaign=truyensieuhay.com.m-top.banner.320x70",
    image: "https://1.bp.blogspot.com/-C0eWRGsqOck/XGeFnwG8UHI/AAAAAAAAImg/mI74r8dOv7cTyamxorCRMHfaDr_e56qxQCLcBGAs/s1600/320x70.gif"
}
]
function closeCatfish() {
    $('.catfish1').remove()
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
    //sinteru += getQuangCao(stemplate, lst_topbanner3);
    
    top.innerHTML = sinteru;
}
function getQuangCao(stem, adobj) {
    var index = getRandomCatfish(adobj.length);
    return stem.replace("XX_LINK_XX", adobj[index].link).replace("XX_IMAGE_XX", adobj[index].image);;
}
function setQcCatfish() {
    var stemplate = '<div class="span">' +
            '<span onclick="closeCatfish()"  class="text_content">Đóng</span>' +
        '</div>' +
        '<a href="XX_LINK2_XX" target="_blank" style="margin-bottom:3px;display: block;">' +
           '<img style="width:100%;height:50px;" src="XX_IMAGE_2_XX" />' +
        '</a>' +
        '<a href="XX_LINK1_XX" target="_blank">' +
            '<img style="width:100%;height:50px;"  src="XX_IMAGE_1_XX" />' +
        '</a>';
    var cat1 = list_catfish1[getRandomCatfish(list_catfish1.length)];
    var cat2 = list_catfish2[getRandomCatfish(list_catfish2.length)];

    var stemplate2 = stemplate.replace("XX_LINK1_XX", cat1.link)
        .replace("XX_IMAGE_1_XX", cat1.image).replace("XX_LINK2_XX", cat2.link)
            .replace("XX_IMAGE_2_XX", cat2.image);

    var cats = document.getElementById("catfish1");
    cats.innerHTML = stemplate2;
    var templace = '<iframe src="/images/ads_300_1.html" width="300" height="250" frameborder="0" scrolling="no"></iframe>';
    $("#truyenhot").append(templace);
}
setQuangCaoTopBanner();
setQcCatfish();