
jQuery( function($){
    iniPusher();
});
 

var iniPusher = function(){
    Pusher.logToConsole = true;

    var pusher = new Pusher(PUSHER_APP_KEY, { cluster: 'ap1' });

    var messageClient = pusher.subscribe('messages');
    var userNotification = pusher.subscribe('notifications');
    
    
    messageClient.bind('ALL', function(data) {
        processMessage(data);
    });

    userNotification.bind('ALL',function(data){
        processMessage(data);
    });
    
}


processMessage = (msgJSON) => {
    console.log(msgJSON);
    if( typeof window[msgJSON.command] == 'function' ){
        window[msgJSON.command](msgJSON.msg);
    }
}

// Message Chat Update
MCU = (data) => {
    if( data[0].sender != UCI ){
        displayMessages(data);
    }
}

//  User Log Status
ULS = (data) => {

}