if (process.env.MIX_SOCKET_ENABLE === 'true') {

    // listen for broadcast events
    Echo.private('app.events')
        .notification((e) => {
            notifyBroadcastMessage(e, 'success');
        })
        .listen('UserWasLoggedIn', (e) => {
            notifyBroadcastMessage(e, 'info');
        })
        .listen('UserWasLoggedOut', (e) => {
            notifyBroadcastMessage(e, 'warning');
        });
}

function notifyBroadcastMessage(event, type) {
    const message = event.message + '<br><small>' + event.time + '</small>';

    new Noty({
        text: message,
        type: type || 'info',
        layout: 'bottomRight',
        theme: 'metroui',
        timeout: false,
        progressBar: true,
        closeWith: ['button', 'click'],
        animation: {
            open: 'animated bounceInRight',
            close: 'animated bounceOutRight'
        },
        maxVisible: 10
    }).show();
}
