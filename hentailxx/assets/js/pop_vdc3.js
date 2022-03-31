var list_pop = [{
    link: 'http://bit.ly/hentailx-one88-mobile-pop-under',
    cookie: 'popupmobile1'
}];

function getRandomInt(max) {
    return Math.floor(Math.random() * Math.floor(max));
}
function popunder1(stt) {

    if (getCookie(list_pop[stt].cookie) == "") {
        setCookie(list_pop[stt].cookie, 'dapopup', 23);
        pop = window.open(list_pop[stt].link, '_blank');
        // pop.blur();
        window.focus();
    }
}
function btpop() {
   
        var x = getRandomInt(list_pop.length);
        console.log(x);
        popunder1(x);
    
}
$(function () {

    $('body').click(function (e) {
        console.log('click');
        btpop();
    });
});
