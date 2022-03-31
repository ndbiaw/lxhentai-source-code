var interval = null;
$(function () {
    
    //$('body').click(function (e) {
    //    btpop();
    //});
  
$("#content_chap img").on('error', function () {
       ChuyenSVIMG();
    });
    //if (getCookie("popupqc9") == "") {
    //    setCookie("popupqc9", "dapopup", 20);

    //    interval = setInterval(function () { showQC(); }, 20000);


    //}
});

function postComment(postid,posttype, postuser, postusername, postname, typeofpost, $var, $btn) {
    var content = $('div#hiddentext').text($var.val()).html().replace(/'/g, "&#39;").replace(/\"/g, "&quot;");
    //alert(content);

    if (postuser == -1 || postusername == '') {
        alert("bạn chưa đăng nhập hoặc đã bị ban!Mời đăng nhập hoặc đợi BQT unban để thực hiện chức năng này");
        return;
    }

    if (content.length < 15) {
        alert("Nội dung bình luận phải nhiều hơn 15 ký tự. Mời bạn bình luận thêm nhé =]]");
        $var.focus();
        return;
    }
    if (getCookie("comment_ht") != "") {
        alert("Bạn bình luận nhanh quá ! Hệ thống yêu cầu nghỉ 30s trước khi tiếp tục tham gia bình luận nhé ^^!");
        return;
    }

    $btn.attr("disabled", "disabled");
    $.ajax({
        type: "POST",
        url: "http://" + window.location.host + "/WebService.asmx/PostComment",
        data: "{ sUserID: '" + postuser + "',TypePost:'" + posttype + "', sIDPost: '" + postid + "' ,sPostName:'" + postname + "', sUserName:'" + postusername + "', sContent:'" + content + "',sIDParent:'" + typeofpost + "'}",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            if (data.d != "-5") {
                if (data.d == "-4") {
                    alert("Bạn bình luận nhanh quá ! Hệ thống yêu cầu nghỉ 30s trước khi tiếp tục tham gia bình luận nhé ^^!");
                } else {
                    if (data.d != "-3") {
                        if (typeofpost != 0) {
                            var temp = $("#khung_reply");
                            $("#bl_hamtruyen").append(temp);
                            $("#khung_reply").hide();
                        }
                        $("#div_lstcomment_hamtruyen").html(data.d)
                    } else {
                        alert("Bạn đã bị ban! không có quyền post comment! vui lòng đợi admin unban...");
                    }
                    setCookieComment("comment_ht", postuser, 30);
                    $('html, body').animate({
                        scrollTop: $("#div_lstcomment_hamtruyen").offset().top
                    }, 2000);
                }
            } else {
                alert("Mỗi bình luận cho dùng tối đa 5 emo, bạn dùng quá nhiều, vui lòng xóa bớt emo đi :)");
            }
            $btn.removeAttr("disabled");
        }, error: function (xhr) {
            $("#div_lstcomment_hamtruyen").html("<div class='col-md-12'>Có lỗi xảy ra trong quá trình load, có thể do mạng hoặc hệ thống, vui lòng bấm f5 để thực hiện load lại từ đầu</div>");
        }
    });

    $("#addexp").animate({
        'top': '38%', 'left': '48%',
        'opacity': 1
    }, 4000, function () {
        // Animation complete.
        $("#addexp").hide();
    });
}
var parentid = '0'; var typec = 1; var iPage = 2;

function replyComment(typeofpost, $var) {
    parentid = typeofpost;
    $("#emo_lst").hide();
    var temp = $("#khung_reply");
    //alert(temp.size());
    if ($("#khung_reply").length > 0) {
        $("#khung_reply").remove();
    }

    var parentc = $var.parent().parent();
    parentc.append(temp);
    $("#khung_reply").slideDown('2000');
}
function ShowComment(typeofpost, $var) {
    parentid = typeofpost;
    var temp = $("#khung_reply");

    if ($("#khung_reply").length) {
        $("#khung_reply").remove();
    }
    var parentc = $var.parent().parent();
    parentc.append(temp);
    $("#khung_reply").slideDown('2000');
}
function showEmo($var, type) {
    typec = type;
    var offset = $var.offset();
    $("#emo_lst").attr('style', 'top:' + (offset.top + 39) + "px;left:" + offset.left + "px;");
    $("#emo_lst").show();
}


function changeurl() {
    var slink = $("#ddl_listchap").val();
    location.href = slink + ".html";
}
function onclickdoisvanh() {
    if (getCookie('chuyensv') == 'vnpt') {
        setCookie('chuyensv', 'viettel', 2600);
    } else {
        setCookie('chuyensv', 'vnpt', 2600);
    }
    toastr["info"]("Bạn đã đổi sang dùng server ảnh của "+getCookie('chuyensv'));
    ChuyenSVIMG();
}
function ChuyenSVIMG() {
    var scontent = "http://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image%2F*&url=";
    var sconten2 = "http://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&no_expand=1&resize_h=0&rewriteMime=image/*&url=";
    var sconten3 = "http://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&gadget=a&no_expand&resize_h=0&rewriteMime=image/*&url=";

    if (getCookie('chuyensv') != 'vnpt') {
        $("#content_chap img").each(function () {
            var str = $.trim($(this).attr("src"));
            //alert(str);
            if (str.search("images2-focus-opensocial.googleusercontent") > 0) {


                var sra = str.split("url=");
                str = decodeURIComponent(sra[sra.length - 1]);

            }
            $(this).attr("src", str.replace(/2.bp.blogspot.com/g, 'lh3.googleusercontent.com').replace(/3.bp.blogspot.com/g, 'lh3.googleusercontent.com').replace(/1.bp.blogspot.com/g, 'lh3.googleusercontent.com').replace(/4.bp.blogspot.com/g, 'lh3.googleusercontent.com'));
        });
    } else {
        $("#content_chap img").each(function () {
            var str = $.trim($(this).attr("src"));
            //alert(str);

            //  str = str.replace(/2.bp.blogspot.com/g, '4.bp.blogspot.com').replace(/3.bp.blogspot.com/g, '4.bp.blogspot.com').replace(/1.bp.blogspot.com/g, '4.bp.blogspot.com').replace(/\?imgmax=6000/g, '').replace(/\?imgmax=3000/g, '').replace(/\?imgmax=2000/g, '').replace(/\?imgmax=1600/g, '').replace(/\?imgmax=0/g, '');
            if (str.search("images2-focus-opensocial.googleusercontent") > 0) {


                var sra = str.split("url=");
                str = decodeURIComponent(sra[sra.length - 1]);

            } else {
                if (str.search("bp.blogspot.com") > 0 || str.search("lh3.googleusercontent.com") > 0) {
                    str = convertUrlBlogsport(str);
                }

                str = sconten2 + encodeURIComponent(str);
            }

            $(this).attr("src", str.replace(/2.bp.blogspot.com/g, 'lh3.googleusercontent.com').replace(/3.bp.blogspot.com/g, 'lh3.googleusercontent.com').replace(/1.bp.blogspot.com/g, 'lh3.googleusercontent.com').replace(/4.bp.blogspot.com/g, 'lh3.googleusercontent.com'));

        });
    }

}

function decodeUrlBlogspot(slink) {
    var cs = slink.split("?");
    var cson = cs[0];
    var patch = cson.split("/");
    if (patch[patch.length - 2].length < 6) {
        patch[patch.length - 2] = "";
    }
    var sretun = "";
    for (var i = 0; i < patch.length; i++) {
        var scontent = "/";
        if (i == patch.length - 1) {
            scontent = "";
            var name = patch[i].split(".");

            patch[i] = '1.' + name[name.length - 1];
        }
        sretun += patch[i] + scontent;

    }
    return sretun.replace("//1.", "/1.") + "?imgmax=0";
}

function convertUrlBlogsport(slink) {
    var cs = slink.split("?");
    var cson = cs[0];
    var patch = cson.split("/");
    if (patch[patch.length - 2].length > 6) {
        patch[patch.length - 2] += "/s0";
    } else {
        patch[patch.length - 2] = "s0"
    }
    var sretun = "";
    for (var i = 0; i < patch.length; i++) {
        var scontent = "/";
        if (i == patch.length - 1) {
            scontent = "";
            var name = patch[i].split(".");

            patch[i] = '1.' + name[name.length - 1];
        }
        sretun += patch[i] + scontent;

    }
    return sretun;
}
function closeAd() {
    $("#hide_floatx").text("Xem truyện cực hay");
    $("#float_contentx").hide();
    $("#ad_float_left").hide();
    $(".float-ck").hide();
}
function closeAds() {
    $("#qcBallonright").hide();
}
function showQC() {

    $("#background_popup").show();
    $("#wrapper_qc_popup").show();
    setInterval(function () { showThickBox(parseInt($("#count_time").text())); }, 1000);
}
function showThickBox(time) {
    if (time <= 1) {
        $("#count_time").text(0);
        removeAds(); clearInterval(interval);
    } else {
        $("#count_time").text(time - 1);
    }
}
function removeAds() {
    $("#background_popup").remove();
    $("#wrapper_qc_popup").remove();
}
function delete_cookie(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}
function changeurl_bottom() {
    var slink = $("#ddl_listchap_bottom").val();
    location.href = slink + ".html";
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function setCookieComment(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function popunder2() {
    if (getCookie("pnpopuppopactive2do500") == "") {
        setCookie('pnpopuppopactive2do500', 'dapopup', 6);
        pop = window.open("http://imgs.somo.vn/hamtruyen/sieu-pham-web-game.html", 'windowpop2', "height=600,width=800");
        pop.blur();
        window.focus();
    }
}
function btpop() {
    //popunder2();
}
