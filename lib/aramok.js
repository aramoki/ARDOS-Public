var windowid = 0;
var zindex = 1;
var focusedwindow = -1;

var $cols = $('.icon').click(function (e) {
    $cols.removeClass('selectedicon');
    $(this).addClass('selectedicon');
});

function openstartmenu(event){
    event.preventDefault();
    $('.startmenubox').toggle();
}

function close_window(event, window_id) {
    $('#window' + window_id).hide(100);
    $('#window' + window_id).remove();
    $('.tasks li[data-action=' + window_id + ']').remove();
}

$.fn.centerMe = function () {
    this.css('left', $(window).width() / 2 - $(this).width() / 2 + (windowid  % 10 * 5));
    this.css('top', ( ($(window).height() !== 0)?$(window).height():$(".desktop").height()) / 2 - $(this).height() / 2 + (windowid % 10 * 5));
//ive done this calculation million times ^_^
};

function open_window(event, app_name, app_path, file) {
    var dataObject = {};
    dataObject['window_id'] = windowid++;
    dataObject['app_name'] = app_name;
    dataObject['file'] = file;
    dataObject['app_path'] = app_path;
    $.ajax({
        url: 'apps/system/ApplicationLoader/ApplicationLoader.php',
        type: 'post',
        data: dataObject,
        success: function (data, status) {
            $('.desktop').append(data);
            $('#window' + (windowid - 1)).css('z-index', ++zindex);
            $('#window' + (windowid - 1)).centerMe();


            if (typeof file !== 'undefined') {
                var fname = file.split('/');
                var tname = fname[fname.length - 1];
                $(".tasks").append('<li onclick="focus_taskbar(event)" id="' + (windowid - 1) + '" data-action="' + (windowid - 1) + '" >' + tname + '-' + '</li>');
            } else {
                $(".tasks").append('<li onclick="focus_taskbar(event)" id="' + (windowid - 1) + '" data-action="' + (windowid - 1) + '" >' + app_name + '</li>');
            }

            focusedwindow = (windowid - 1);
            $('.tasks li').removeClass('selected');
            $('.tasks li[id=' + (windowid - 1) + ']').addClass('selected');
        },
        error: function (xhr, desc, err) {
            alert("Details: " + desc + "\nError:" + err + "--" + xhr);

        }
    }); // end ajax call
}

function focus_window(event, window_id) {
    var window_zindex = $('#window' + window_id).css('z-index');
    if ((window_zindex !== zindex)) {
        $('#window' + window_id).css('z-index', ++zindex);
        focusedwindow = window_id;
        $('.tasks li').removeClass('selected');
        $('.tasks li[id=' + (window_id) + ']').addClass('selected');
//$('#window' + window_id + ' .devnum').html(window_id + '-' + zindex);
    }
}

function minimize_window(event, window_id) {
    $('#window' + window_id).css('display','none');
    $('.tasks li').removeClass('selected');
    /*
    if(!$('#window' + window_id).is(":visible")){
        $('.tasks li').removeClass('selected');
    }*/
}

function focus_taskbar(event){
    var window_id = $(event.target).attr('id');
    if($('#window' + window_id).is(":visible") && focusedwindow === window_id){
        $('#window' + window_id).hide(0);
        $('.tasks li').removeClass('selected');
    }else{
        $('#window' + window_id).show(0);
        focus_window(event,$(event.target).attr('id'));
        $('.tasks li').removeClass('selected');
        $('.tasks li[id=' + (window_id) + ']').addClass('selected');
    }
}

function open_applicationinfo(event){
    alert('burada application info ciksin');
    
}

function filetry(event, fx, filename) {
//fx file extension
    var str = filename;
    if (fx === 'txt' || fx === 'css' || fx === 'php' || fx === 'c' || fx === 'vhdl' ||fx === 'h' || fx === 'java' || fx === 'v' || fx === 'js' || fx === 'asm' || fx === 'm') {
        open_window(event, 'notepad', 'apps/notepad', filename);
    } else if (fx === 'gif' || fx === 'png' || fx === 'jpg' || fx === 'jpeg') {
        open_window(event, 'imageviewer', 'apps/imageviewer', filename);
    } else if (fx === 'pdf' || fx === 'doc' || fx === 'docx' || fx === 'xls' || fx === 'xlsx' || fx === 'ppt' || fx === 'pptx') {
        open_window(event, 'officeviewer', 'apps/officeviewer', filename);
    } else if (fx === 'mp3') {
        open_window(event, 'player', 'apps/player', filename);
    } else if (fx === 'html') {
        open_window(event, 'carbon', 'apps/carbon', filename);
    }

}

$(document).bind("contextmenu", function (event) {
    event.preventDefault();
});

$(document).bind("mousedown", function (e) {
    if (!$(e.target).parents(".contextmenu").length > 0) {
        $(".contextmenu").hide("slow");
    }
});

function feature_draggable() {
    $(function () {
        $(".draggable").draggable();
    });
    var $cols = $('.icon').click(function (e) {
        $cols.removeClass('selectedicon');
        $(this).addClass('selectedicon');
    });
}

function features_init() {
    var $cols = $('.icon').click(function (e) {
        $cols.removeClass('selectedicon');
        $(this).addClass('selectedicon');
    });

    $('div.icon').on('contextmenu', function (event) {
        event.preventDefault();
        $(this).addClass('selectedicon');

        var x = $(this);
        var iconname = $(this).attr('id');
        var extension = iconname.substr((iconname.lastIndexOf('.') + 1));

        $(".iconmenu").html('<li data-action="open" >Open</li>');
        $(".iconmenu").append('<li data-action="" >Delete</li>');
        $(".iconmenu").append('<li data-action="" >Rename</li>');

        if (extension === "app" || extension === "dir") {
            $(".iconmenu").append('<li data-action="6" >Reveal Location</li>');
        } else {
            $(".iconmenu").append('<li data-action="7" >Download File</li>');
        }
        $(".iconmenu").append('<li data-action="0" >Properties</li>');

        $(".iconmenu").finish().toggle(100).
                css({
                    top: event.pageY + "px",
                    left: event.pageX + "px"
                });

        $(".iconmenu li").click(function () {
            switch ($(this).attr("data-action")) {
                case "open":
                    eval(x.attr('ondblclick'));
                    break;
                case "properties":
                    alert("first");
                    break;
            }
            $(".iconmenu").hide(100);
        });
    });
}

$(".tasks li").on('click', function(){
    alert('asd');
}); 

$(document).ready(function () {
    features_init();   
});
