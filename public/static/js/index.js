function scroll() {
    console.log('scroll');
    var top = $(document.body).scrollTop();
    let h = $("#header").height() / 7;
    let headerD = $("#header").css("display");
    let header2D = $("#header_2").css("display");
    console.log("top:"+top);
    console.log("h:"+h);
    if (top > h) {
        if (headerD != "none") {
            $("#header").slideUp();
        }
        if (header2D == "none") {
            $("#header_2").fadeIn();
        }
    } else if (top < h) {
        if (header2D != "none") {
            $("#header_2").slideUp();
        }
        if (headerD == "none") {
            $("#header").fadeIn();
        }
    }
};

// 提示
function tips() {
    $('#tips').modal("show");
}
