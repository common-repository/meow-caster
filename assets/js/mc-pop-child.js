//console.log('Popin Child load');

// & is for the add from the
var iframe_full_origin = window.location.href + '&';

window.addEventListener("message", receiveMeowFrame, false);

window.parent.postMessage(getMeowMessageBase(), iframe_full_origin);

function getMeowMessageBase() {
    var iframe_full_origin = window.location.href + '&';
    return {
        "message": '',
        "action": "loaded",
        "fullorigin": iframe_full_origin
    };
}

// Sync action
function receiveMeowFrame(event) {
    var data = event.data,
        source = event.source,
        action = data.action,
        message = data.message;
    //console.log(action);
    if (action === 'meow-video-listing') {
        meow_video_listing_action();
        meow_video_listing_already_check(message);
    }
    if (action === 'meow-video-gallery-add') {
        meow_video_gallery_add(message);
    }
    if (action === 'meow-shortcode') {
        meow_shortcode_action();
    }
}

// Action
function meow_shortcode_action() {
    var submitbtn = document.getElementById('mcss-embed-tunnel-validator');

    submitbtn.onclick = function (ev) {
        ev.preventDefault();
        var message = getMeowMessageBase();
        message.message = meow_generate_shortcode();

        message.action = 'add_shortcode';
        window.parent.postMessage(message, iframe_full_origin);
        self.parent.tb_remove();
    };
}

function meow_video_listing_action() {
    //console.log('vle-add-binding');
    $addBtn = meowqa('.mcjs-vle-add');
    $addBtn.forEach(function (elem) {
        elem.addEventListener('click', function (evt) {
            var data = getMeowMessageBase();
            data.action = 'add_video_to_gallery';
            data.message = this.getAttribute('data-item');
            window.parent.postMessage(data, iframe_full_origin);
        });
    });
}

function meow_video_listing_already_check(listIds) {
    if (listIds.length === 0) {
        return false;
    }
    listIds.forEach(function (a) {
        meow_video_gallery_add(a);
    });
}

function meow_video_gallery_add(ytid) {
    var item = meowq('[data-ytid="' + ytid + '"]');
    if (null === item) {
        return false;
    }
    var overlay = meowq('.mcss-overlay', item);
    item.classList.add('mcss-video-list-elem-added');
    item.removeChild(overlay);
}

// Function
function meow_generate_shortcode() {
    var sc = '',
        name = 'meow_yt_',
        basename = 'mcss-widgetform-',
        param = '';

    //get all information

    embedType = document.querySelector('[name="' + basename + 'embedtype"]:checked').value;

    if (embedType === 'player' || embedType === 'playlist') {

        name += embedType;
        used = document.querySelector('[name="' + basename + 'use"]:checked').value;
        if (used === 'url') {
            url = document.querySelector('[name="' + basename + 'content-url"]').value;
            param += 'url="' + url + '" ';
            ;
        } else {
            content_id = document.querySelector('[name="' + basename + 'content-id"]').value;
            //console.log(content_id);
            param += 'content_id="' + content_id + '" ';
        }
    }

    if (embedType === 'gallery') {
        name += 'gallery';
        post_id = document.querySelector('[name="' + basename + 'gallery-selector"]').value;
        col = document.querySelector('[name="' + basename + 'gallery-col"]').value;
        title = document.querySelector('[name="' + basename + 'gallery-title"]');
        param += 'id=' + post_id + ' ';
        param += 'col=' + col + ' ';

        if (title.checked) {
            param += 'title="on" ';
        }
    }

    if (embedType === 'live' || embedType === 'channel') {
        name += embedType;
        viewName = embedType === 'live' ? 'type' : 'view';
        view = document.querySelector('[name="' + basename + embedType + '-' + viewName + '"]').value;
        theme = document.querySelector('[name="' + basename + embedType + '-theme"]').value;

        param += 'view="' + view + '" ';
        param += 'theme="' + theme + '" ';

        if (embedType === 'channel') {
            nbVid = document.querySelector('[name="' + basename + embedType + '-nbVid"]').value;
            param += 'nb_vid=' + nbVid + ' ';
        }
    }

    sc = '[' + name + ' ';
    sc += param;

    sc += ']';
    return sc;
}