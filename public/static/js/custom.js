$(function () {
    NProgress.start();
    $('#side-menu').metisMenu();
    reply();
    vote();
    follow();
    extra();
    voteComment();
    voteReply();
    deleteComment();
    deleteReply();
    var time = $('abbr.timeago');
    time.timeago();
    $("a.embed").oembed();
    $('div.flash_message').not('.flash_important').delay(2000).slideUp();
    ckeditor();
    scroll();
    $("img.display-image").lazyload({threshold: 200});
    $(".video-embed").fitVids({customSelector: "iframe[src^='https://vine.co']"});
});

$(window).load(function () {
    NProgress.done();
});

function follow() {
    $(".follow").on("click", function () {
        var c = $(this);
        var data = c.attr("data-id");
        var b = "id=" + data;
        $.ajax({
            type: "POST", url: "../../follow", data: b, success: function (a) {
                $.when(c.fadeOut(300).promise()).done(function () {
                    if (c.hasClass("btn")) {
                        c.removeClass("btn-info").addClass("btn-success").prop('disabled', true).text(a).fadeIn();
                    } else {
                        c.replaceWith(a).attr("disabled", false);
                    }
                });
            }
        });
        return false;
    });
}
function ckeditor() {
    if ($('#editor').length > 0) {
        CKEDITOR.replace('editor', {
            toolbar: [
                ['Bold', 'Italic'],
                ['NumberedList', 'BulletedList', 'Outdent', 'Indent'],
                ['Link', 'Unlink']
            ]
        });
    }
}

function reply() {
    var c = $(".replybutton");
    var b = $(".closebutton");
    var a = $(".replytext");
    c.on("click", function () {
        var d = $(this).attr("id");
        $(this).hide();
        $("#open" + d).show();
        a.focus();
    });
    b.on("click", function () {
        var d = $(this).attr("id");
        $("#open" + d).hide();
        c.show();
    });
    $(".replyMainButton").click(function () {
        var e = $(this).attr("id");
        var f = $("#textboxcontent" + e).val();
        var d = "textcontent=" + f + "&reply_msgid=" + e;
        if (f === "") {
            a.stop().css("background-color", "#FFFF9C");
        } else {
            $.ajax({
                type: "POST",
                url: "../../reply",
                data: d,
                success: function (h) {
                    var transform = [
                        {"tag": "hr", "html": ""},
                        {
                            "tag": "div", "class": "media", "children": [
                            {
                                "tag": "a", "class": "pull-left", "href": "${profile_link}", "children": [
                                {"tag": "img", "class": "media-object img-circle", "src": "${profile_avatar}", "alt": "${fullname}", "html": ""}
                            ]
                            },
                            {
                                "tag": "div", "class": "media-body", "children": [
                                {
                                    "tag": "h4", "class": "media-heading", "children": [
                                    {"tag": "a", "href": "${profile_link}", "html": "${fullname}"},
                                    {
                                        "tag": "span", "class": "pull-right", "children": [
                                        {"tag": "i", "class": "comment-time fa fa-clock-o fa-fw", "html": ""},
                                        {"tag": "abbr", "class": "timeago comment-time", "title": "${time}", "html": "${time}"}
                                    ]
                                    }
                                ]
                                },
                                {"tag": "p", "html": "${reply}"}
                            ]
                            }
                        ]
                        }
                    ];
                    var data = [h];
                    $(".reply-add-" + e).json2html(data, transform);
                    $("#openbox-" + e).hide(300);
                }
            });
        }
        return false;
    });
}

function vote() {
    $(".vote-btn").on("click", function () {
        var c = $(this);
        var data = c.attr("data-id");
        var b = "id=" + data;
        var txt = $("#data-number-" + data);
        $.ajax({
            type: "POST",
            url: "../../vote",
            data: b,
            success: function (a) {
                $.when(c.fadeOut()).done(function () {
                    if (c.hasClass("voted")) {
                        c.removeClass("voted");
                    } else {
                        c.removeClass('vote-btn').addClass('voted');
                    }
                    c.fadeIn();
                    txt.text(a);
                });
            }
        });
        return false;
    });
}

function deleteComment() {
    var a = $("button.delete-comment");
    a.on("click", function () {
        var c = $(this);
        var e = c.attr("data-content");
        var b = "id=" + e;
        $.ajax({
            type: "POST", url: "../../deletecomment", data: b, success: function (d) {
                $("#comment-" + e).hide(500);
            }
        });
    });
}

function deleteReply() {
    var a = $("button.delete-reply");
    a.on("click", function () {
        var c = $(this);
        var e = c.attr("data-content");
        var b = "id=" + e;
        $.ajax({
            type: "POST", url: "../../deletereply", data: b, success: function (d) {
                $("#reply-" + e).hide(500);
            }
        });
    });
}

function extra() {
    var displayImage = $('img.display-image');
    var galleryFigure = $('div.gallery-display figure');
    var galleryShares = $('div.gallery-display .shares');
    displayImage.lazyload({threshold: 200});
    galleryFigure.add(galleryShares).on('mouseover', function () {
        $(this).parent().find('.shares').css({'opacity': 1, 'top': '10px'});
    });
    galleryFigure.add(galleryShares).on('mouseout', function () {
        $(this).parent().find('.shares').css({'opacity': 0, 'top': '-1px'});
    });

    var navBar = $('.navbar');
    var sideBar = $('div.sidebar-collapse');
    if ($(window).width() < 768) {
        navBar.removeClass('navbar-fixed-top').addClass('navbar-static-top');
    }

    $(window).bind("load resize", function () {
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            sideBar.addClass('collapse');
            navBar.removeClass('navbar-fixed-top').addClass('navbar-static-top');
        } else {
            sideBar.removeClass('collapse');
            navBar.removeClass('navbar-static-top').addClass('navbar-fixed-top');
        }
    });
}

function scroll() {
    $('.gallery').infinitescroll({
        navSelector: "ul.pagination",
        nextSelector: "ul.pagination a:first",
        itemSelector: ".row .post",
        debug: false,
        dataType: 'html',
        bufferPx: 900
    }, function (newElements, data, url) {
        extra();
        rrsb();
    });
}

function voteComment() {
    $(".vote-comment").on("click", function () {
        var c = $(this);
        var data = c.attr("data-id");
        var b = "id=" + data;
        var txt = $("#data-comment-" + data);
        $.ajax({
            type: "POST",
            url: "../../votecomment",
            data: b,
            success: function (a) {
                $.when(c.fadeOut()).done(function () {
                    if (c.hasClass("comment-voted")) {
                        c.removeClass("comment-voted");
                    } else {
                        c.removeClass('vote-comment').addClass('comment-voted');
                    }
                    c.fadeIn();
                    txt.text(a);
                })
            }
        });
        return false
    })
}

function voteReply() {
    $(".vote-reply").on("click", function () {
        var c = $(this);
        var data = c.attr("data-id");
        var b = "id=" + data;
        var txt = $("#data-reply-" + data);
        $.ajax({
            type: "POST",
            url: "../../votereply",
            data: b,
            success: function (a) {
                $.when(c.fadeOut()).done(function () {
                    if (c.hasClass("comment-voted")) {
                        c.removeClass("comment-voted");
                    } else {
                        c.removeClass('vote-comment').addClass('comment-voted');
                    }
                    c.fadeIn();
                    txt.text(a);
                })
            }
        });
        return false
    })
}