var windowid = 0;
var zindex = 1;
var focusedwindow = -1;
var $cols = $('.icon').click(function (e) {
    $cols.removeClass('selectedicon');
    $(this).addClass('selectedicon');
});

function bootloader(){
     document.body.innerHTML += '<br>loading...';
    //var dataObject = {};
    $.ajax({
        url: 'apps/system/desktop/bootloader.php',
        type: 'post',
        //data: dataObject,
        xhr: function () {
            var xhr = new window.XMLHttpRequest();

            // Upload progress
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    //Do something with upload progress
                    //console.log(percentComplete);
                    $("html").css('cursor', 'wait');
                    $(".loading").show();
                }
            }, false);

            // Download progress
            xhr.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    // Do something with download progress
                    //console.log(percentComplete);
                    $("html").css('cursor', 'wait');
                    $(".loading").show();
                }
            }, false);


            //Done progress
            xhr.addEventListener("load", function (evt) {
                $("html").css('cursor', 'auto');
                $(".loading").hide();
            }, false);


            return xhr;
        },
        success: function (data, status) {
            document.body.innerHTML = data;
        },
        error: function (xhr, desc, err) {
            alert("Details: " + desc + "\nError:" + err + "--" + xhr);
        }
    }); // end ajax call
}
function open_app(event, apploc,data) {
    var arr = apploc.split('/');
    var appname = arr[arr.length - 1];
    open_window(event, appname, apploc,data); 
}
/*
function readCookie_depleted(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}*/

function readCookie(name) {
    var dataObject = {};
    dataObject['name'] = name;
    return $.ajax({
        url: 'apps/system/logon/readcookie.php',
        type: 'post',
        data: dataObject
    });
}
function eraseCookie(name) {
    var dataObject = {};
    dataObject['name'] = name;
    return $.ajax({
        url: 'apps/system/logon/deletecookie.php',
        type: 'post',
        data: dataObject
    }); // end ajax call
}


function close_window(event, window_id) {
    //$('#window' + window_id).hide(100);
    //$('#window' + window_id).remove();
    //$('.tasks li[data-action=' + window_id + ']').remove();
    $('#window' + window_id).fadeOut(300, function () {
        $(this).remove();
    });
    $('.tasks li[data-action=' + window_id + ']').fadeOut(300, function () {
        $(this).remove();
    });
}
$.fn.centerMe = function () {
    this.css('left', $(window).width() / 2 - $(this).width() / 2 + (windowid % 10 * 5));
    this.css('top', (($(window).height() !== 0) ? $(window).height() : $(".desktop").height()) / 2 - $(this).height() / 2 + (windowid % 10 * 5));
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
        xhr: function () {
            var xhr = new window.XMLHttpRequest();

            // Upload progress
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    //Do something with upload progress
                    //console.log(percentComplete);
                    $("html").css('cursor', 'wait');
                    $(".loading").show();
                }
            }, false);

            // Download progress
            xhr.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    // Do something with download progress
                    //console.log(percentComplete);
                    $("html").css('cursor', 'wait');
                    $(".loading").show();
                }
            }, false);


            //Done progress
            xhr.addEventListener("load", function (evt) {
                $("html").css('cursor', 'auto');
                $(".loading").hide();
            }, false);


            return xhr;
        },
        /*xhrFields: {
         onprogress: function (e) {
         if (e.lengthComputable) {
         var pct = (e.loaded / e.total) * 100;
         $("html").css('cursor', 'wait');
         $(".loading").show();
         //$(".loading .progress").css('width', pct + '%');
         }
         }
         },*/
        success: function (data, status) {
            //$("html").css('cursor', 'auto');
            //$(".loading").hide();
            $('.desktop').append(data);
            $('#window' + (windowid - 1)).css('z-index', ++zindex);
            $('#window' + (windowid - 1)).centerMe();


            if (typeof file !== 'undefined') {
                var fname = file.split('/');
                var tname = fname[fname.length - 1];
                if (tname.length === 0) {
                    tname = 'root';
                }
                $(".tasks .taskscontainer").append('<li onclick="focus_taskbar(event)" id="' + (windowid - 1) + '" data-action="' + (windowid - 1) + '" ><img   src="' + app_path + '/' + app_name + '.png"><p class="info">' + app_name + ':' + tname + '</p></li>');
            } else {
                $(".tasks .taskscontainer").append('<li onclick="focus_taskbar(event)" id="' + (windowid - 1) + '" data-action="' + (windowid - 1) + '" ><img  src="' + app_path + '/' + app_name + '.png"><p class="info">' + app_name + '</p></li>');
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
function appinfo_window(event, window_id) {
    $('#window' + window_id + ' .appinfobox').toggle();
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
    $('#window' + window_id).css('display', 'none');
    $('.tasks li').removeClass('selected');
    /*
     if(!$('#window' + window_id).is(":visible")){
     $('.tasks li').removeClass('selected');
     }*/
}
function showhidetasks(event) {
    event.preventDefault();
    $('.taskscontainer').toggle();
    $('.showhidetasks').toggleClass('showhide');
}
function focus_taskbar(event) {
    var chield = $(event.target);
    var parent = $(event.target).parent();
    var window_id;

    if (chield.attr('id')) {
        window_id = chield.attr('id');
    } else {
        window_id = parent.attr('id');
    }

    if ($('#window' + window_id).is(":visible") && focusedwindow === window_id) {
        $('#window' + window_id).hide(0);
        $('.tasks li').removeClass('selected');
    } else {
        $('#window' + window_id).show(0);
        focus_window(event, window_id);
        $('.tasks li').removeClass('selected');
        $('.tasks li[id=' + (window_id) + ']').addClass('selected');
    }
}
function filedelete(event, fx, filename) {
    var dataObject = {};
    dataObject['file'] = filename;
    //open dialog for delete approve
    $.ajax({
        url: 'apps/system/FIO/deletefile.php',
        type: 'post',
        data: dataObject,
        xhr: function () {
            var xhr = new window.XMLHttpRequest();

            // Upload progress
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    //Do something with upload progress
                    //console.log(percentComplete);
                    $("html").css('cursor', 'wait');
                    $(".loading").show();
                }
            }, false);

            // Download progress
            xhr.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    // Do something with download progress
                    //console.log(percentComplete);
                    $("html").css('cursor', 'wait');
                    $(".loading").show();
                }
            }, false);


            //Done progress
            xhr.addEventListener("load", function (evt) {
                $("html").css('cursor', 'auto');
                $(".loading").hide();
            }, false);


            return xhr;
        },
        success: function (data, status) {

        },
        error: function (xhr, desc, err) {
            alert("Details: " + desc + "\nError:" + err + "--" + xhr);

        }
    }); // end ajax call


}
function filerename(event, fx, filename) {
    var newfilename = window.prompt('Rename file', 'filename');
    if (newfilename !== null) {
        var dataObject = {};
        if (filename === '0') {
            //if folder
            dataObject['file'] = fx;
            dataObject['newfilename'] = newfilename;
        } else {
            //if file
            dataObject['file'] = filename;
            dataObject['newfilename'] = newfilename + '.' + fx;
        }

        //open dialog for delete approve
        $.ajax({
            url: 'apps/system/FIO/renamefile.php',
            type: 'post',
            data: dataObject,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();

                // Upload progress
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        //Do something with upload progress
                        //console.log(percentComplete);
                        $("html").css('cursor', 'wait');
                        $(".loading").show();
                    }
                }, false);

                // Download progress
                xhr.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        // Do something with download progress
                        //console.log(percentComplete);
                        $("html").css('cursor', 'wait');
                        $(".loading").show();
                    }
                }, false);


                //Done progress
                xhr.addEventListener("load", function (evt) {
                    $("html").css('cursor', 'auto');
                    $(".loading").hide();
                }, false);


                return xhr;
            },
            success: function (data, status) {
                //$(event.target).find('p.name').html(data);
                //refresh folder here
                //if dekstop refresh dekstop here
            },
            error: function (xhr, desc, err) {
                alert("Details: " + desc + "\nError:" + err + "--" + xhr);

            }
        }); // end ajax call
        return newfilename + '.' + fx;
    } else {
        return null;
    }

}
function filetry(event, fx, filename) {
//fx file extension
    var str = filename;
    if (fx === 'txt' || fx === 'css' || fx === 'php' || fx === 'c' || fx === 'vhdl' || fx === 'h' || fx === 'java' || fx === 'v' || fx === 'js' || fx === 'asm' || fx === 'm') {
        open_window(event, 'notepad', 'apps/notepad', filename);
    } else if (fx === 'gif' || fx === 'png' || fx === 'jpg' || fx === 'jpeg') {
        open_window(event, 'imageviewer', 'apps/imageviewer', filename);
    } else if (fx === 'pdf' || fx === 'doc' || fx === 'docx' || fx === 'xls' || fx === 'xlsx' || fx === 'ppt' || fx === 'pptx') {
        open_window(event, 'officeviewer', 'apps/officeviewer', filename);
    } else if (fx === 'zip') {
        open_window(event, 'pascal', 'apps/pascal', filename);
    } else if (fx === 'mp3' || fx === 'mp4' ) {
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
        $(".draggable").draggable({
            handle: '.titlebar , .infobar , .icon'
        });

        $(".resizable").resizable({
            handles: 'n, e, s, w, ne, se, sw, nw'
        });
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

        var item = $(this);
        var iconname = $(this).attr('id');
        var extension = iconname.substr((iconname.lastIndexOf('.') + 1));

        $(".iconmenu").html('<li data-action="open" >Open</li>');
        $(".iconmenu").append('<li data-action="delete" >Delete</li>');
        $(".iconmenu").append('<li data-action="rename" >Rename</li>');

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
                    eval(item.attr('ondblclick'));
                    break;
                case "delete":
                    var icmd = item.attr('ondblclick');
                    var cmd = (icmd.split('(')[1]).split(')')[0];
                    var delcmd = 'filedelete(' + cmd + ')';
                    eval(delcmd);
                    item.remove();
                    break;
                case "rename":
                    var icmd = item.attr('ondblclick');
                    var cmd = (icmd.split('(')[1]).split(')')[0];
                    var renamecmd = 'filerename(' + cmd + ')';
                    var renamedfilename = eval(renamecmd);
                    //[!] bunu yaptiktan sonra komutunuda degistirmek gerekiyor yoksa acilmiyor dosya
                    if (renamedfilename !== null) {
                        item.find('p.name').html(renamedfilename);
                    }
                    break;
            }
            $(".iconmenu").hide(100);
        });
    });
}
function sliderusermenu(e) {
    $('.user').toggleClass('rotateimg');
    $('.usermenu').toggle("slide", {direction: "right"}, 1000);
}
function check_user_login() {
    readCookie('username').success(
            function (data) {
                if (data !== '') {
                    $('.user').show('slow');
                } else {
                    $('.user').hide('slow');
                }
                $('.user p.username').html(data);
    });
}
$(".tasks li").on('click', function () {
    alert('asd');
});
$(document).ready(function () {
    features_init();
    check_user_login();
});
function getAverageRGB(imgEl) {

    var blockSize = 5, // only visit every 5 pixels
            defaultRGB = {r: 0, g: 0, b: 0}, // for non-supporting envs
    canvas = document.createElement('canvas'),
            context = canvas.getContext && canvas.getContext('2d'),
            data, width, height,
            i = -4,
            length,
            rgb = {r: 0, g: 0, b: 0},
    count = 0;

    if (!context) {
        return defaultRGB;
    }

    height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height;
    width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width;

    context.drawImage(imgEl, 0, 0);

    try {
        data = context.getImageData(0, 0, width, height);
    } catch (e) {
        /* security error, img on diff domain */
        return defaultRGB;
    }

    length = data.data.length;

    while ((i += blockSize * 4) < length) {
        ++count;
        rgb.r += data.data[i];
        rgb.g += data.data[i + 1];
        rgb.b += data.data[i + 2];
    }

    // ~~ used to floor values
    rgb.r = ~~(rgb.r / count);
    rgb.g = ~~(rgb.g / count);
    rgb.b = ~~(rgb.b / count);

    return rgb;

}




