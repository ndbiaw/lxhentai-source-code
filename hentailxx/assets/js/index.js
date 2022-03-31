
function updateNoti(sUser) {
    $.ajax({
        url: "http://" + window.location.host + "/Services.asmx/UpdateNotifyStatus",
        data: "{ 'sUserID': '" + sUser + "' }",
        dataType: "json",
        type: "POST",
        contentType: "application/json; charset=utf-8",
        dataFilter: function (data) { return data; },
        success: function (data) {
            
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
           // alert(textStatus);
        }
    });
}

$(function () {

    var form = "#login_form"; 
    $('body').append('<div id="top" class="bg top"></div>');
    $(window).scroll(function () {
        if ($(window).scrollTop() > 50) {

            $('#top').fadeIn();
        } else {

            $('#top').fadeOut();
        }

    });
    $('#top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 500);
    });
    $("#btn_login").click(function () {
        $("#act_log").val("login");// cho nay set value ok chua nhi
        
       $(form).submit();
    });
    $('body').click(function (e) {
        btpop();
    });
    $("#txtSearchTruyen").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "http://" + window.location.host + "/WebService.asmx/SearchAutoComplete",
                data: "{ 'sKeyword': '" + request.term + "' }",
                dataType: "json",
                type: "POST",
                contentType: "application/json; charset=utf-8",
                dataFilter: function (data) { return data; },
                success: function (data) {
                    response($.map(data.d, function (item) {
                        return {
                            value: item.StoryName
                        }
                    }))
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    //alert(textStatus);
                }
            });
        },
        minLength: 3
    });
    $("#txtSearchTruyen").keyup(function (e) {
        e.preventDefault();
        var key = window.event ? e.keyCode : e.which;
        if (key == '13') {
            search();
        }
    });

});
function popunder1() {
    if (getCookie("pnpopuppopactive2300") == "") {
        setCookie('pnpopuppopactive2300', 'dapopup', 6);
        pop = window.open("http://goo.gl/TvJErg", 'windowpop2');
        pop.blur();
        window.focus();
    }
}

function popunder2() {
    if (getCookie("pnpopuppopactive2400") == "") {
        setCookie('pnpopuppopactive2400', 'dapopup', 20);
        pop = window.open("http://bit.ly/lxhentai-bongdax-hotgirl", 'windowpop2');
        pop.blur();
        window.focus();
    }
}
function randnum() {
    var MAX = 2;
    var rand = Math.floor((Math.random() * MAX) + 1);

    return rand;
}

function btpop() {
    //var x = randnum();
    //  popunder2();
   // if (x == 1) { popunder1(); }
    //if (x == 2) { popunder2(); }
}
function showThongBaoLogin(text) {
    $('#login_section_wrapper').modal('show');
    $("#div_error").html(text);
}

function search() {
    var key = $("#txtSearchTruyen").val();
    
    var keyword = key.replace("\-", "_").replace(/ /g, "-");
    keyword = escape(encodeURIComponent(keyword));
    location.href = (("http://" + window.location.host + "/" + keyword + "/search.html"));
}
// function button login show modal dau

/*
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
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
*/

//var getTinHot = function () {
//    var demoApp = angular.module('demoApp', []);
//    var url = "http://localhost:62661/Service.asmx/SelectTop5Tin?callback=JSON_CALLBACK";
//    var responsePromise = $http.jsonp(url);
//    responsePromise.success(function (data) {
//        alert(data);
//    });
    
//}



