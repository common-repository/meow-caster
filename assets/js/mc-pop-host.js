console.log('Popin Host load');

window.addEventListener("message", receiveMeowFrame, false);

var meow_tb_btn = meowqa('.mcjs-tb-button');

meow_tb_btn.forEach(function (element) {
    element.addEventListener("click", function (ev) {
        document.body.classList.add('mcss-form-popin');
        var action = this.getAttribute('data-meow-action');

        setTimeout(function () {
            var tb = document.getElementById('TB_window');
            tb.classList.add('meow-tb');
            tb.setAttribute('data-meow-action', action);
        }, 300);

        document.body.addEventListener('thickbox:removed', function (evt) {
            if (document.body.classList.contains('mcss-form-popin')) document.body.classList.remove('mcss-form-popin');
        });
    });
});

function receiveMeowFrame(event) {
    var data = event.data,
        source = event.source,
        tb = document.getElementById('TB_window'),
        message = {
        "message": '',
        "action": ''
    };

    console.log(data);
    if (data['fullorigin'] !== document.getElementById('TB_iframeContent').src && data['fullorigin'] == null || document.getElementById('TB_iframeContent') == null || data['fullorigin'].indexOf('meow-caster-embed-tunnel') < 0 && document.getElementById('TB_iframeContent').src.indexOf('meow-caster-embed-tunnel') < 0 && data['fullorigin'].indexOf('meow-caster-video-listing') < 0 && document.getElementById('TB_iframeContent').src.indexOf('meow-caster-video-listing') < 0 && data['fullorigin'].indexOf('meow-caster-premium-embed-tunnel') < 0 && document.getElementById('TB_iframeContent').src.indexOf('meow-caster-premium-embed-tunnel') < 0 && data['fullorigin'].indexOf('meow-caster-premium-video-listing') < 0 && document.getElementById('TB_iframeContent').src.indexOf('meow-caster-premium-video-listing') < 0) {

        if (data['fullorigin'].indexOf('meow-caster-video-listing') < 0 && document.getElementById('TB_iframeContent').src.indexOf('meow-caster-video-listing') < 0) console.log('fall condition 2 ');

        return;
    }
    if (data['action'] === 'add_shortcode') {
        meow_shortcode_to_editor(data['message']);
        // console.log( tinymce.activeEditor );
        //tinymce.activeEditor.execCommand('mceInsertRawHTML', true, " "+data['message'] );
        document.body.classList.remove('mcss-form-popin');
    }
    if (data['action'] === 'add_video_to_gallery') {

        // On load ready
        var meow_video_data = JSON.parse(window.atob(data['message']));
        meow_caster_vgl_add(meow_video_data, true);

        message.message = meow_video_data.id;
        message.action = 'meow-video-gallery-add';
        event.source.postMessage(message, window.location);
    }
    if (data['action'] === 'loaded') {
        // On load ready demand the good action
        message.action = tb.getAttribute('data-meow-action');
        console.log(tb.getAttribute('data-meow-action'));
        if (message.action === 'meow-video-listing') {
            message.message = meow_caster_vgl_get_ids();
        }
        event.source.postMessage(message, window.location);
    }
}

function meow_shortcode_to_editor(shortcode) {
    if (window.tinyMCE !== null && window.tinyMCE.activeEditor !== null && !window.tinyMCE.activeEditor.isHidden()) {
        if (typeof window.tinyMCE.execInstanceCommand !== 'undefined') {
            window.tinyMCE.execInstanceCommand(window.tinyMCE.activeEditor.id, 'mceInsertRawHTML', false, shortcode);
        } else {
            send_to_editor(shortcode);
        }
    } else {
        send_to_editor(shortcode);
    }
}