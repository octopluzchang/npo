//伺服器端

//目前所有在線的使用者列表
var users = [];

//建立websocket server
var WebSocketServer = require('ws').Server,
    wss = new WebSocketServer({
        port: 8080
    });


//對某個client傳送訊息(每個ws是個別client的實體)
function send(ws, method, data){
    try {
        ws.send(JSON.stringify({m: method, d: data}));
    } catch (e){}
    return;
}


//當 websocket 收到新連線時(有使用者登入)
wss.on('connection', function connection(ws) {
	var self;

    //登出的method
	function logout(){
		users.splice(users.indexOf(self), 1);
        if (users.filter(function(user){
            return user.id == self.id;
        }).length == 0){
            users.map(function(user){
                send(user.ws, "LOGOUT", {id: self.id});
            });
        }
	};

    //當接收到訊息時
    ws.on('message', function (message) {
        //訊息格式統一使用json 並將 m 為method name/ d 為傳輸的資料
    	var message = JSON.parse(message);
    	var method = message.m;
        var data = message.d;

        switch (method.toUpperCase()) {
            //使用者登入
            case "LOGIN":
                self = data;
                self.ws = ws;
                users.push(self);
                //通知其他使用者, 有新的使用者登入了
                users.map(function(user){
                	if (user.id != self.id){
                		send(user.ws, "LOGIN", {id: self.id, name: self.name});
                	}
                });
                send(ws, "SUCCESSLOGIN");

            //心跳包(每秒在server/client中傳輸訊息)
            case "HEARTBEAT":
            	self.activeTime = new Date().getTime();
            	if (self.timeout){
            		clearTimeout(self.timeout);
            	}
                //如果5秒內都沒有心跳包再度傳入(clearTimeout沒有被執行)，就是為斷線了
            	self.timeout = setTimeout(logout, 5000);
            	send(ws, "HEARTBEAT");
                break;

            //取得伺服器上所有的使用者清單
            case "LIST":
            	var list = users.map(function(user){
            		return {
            			id: user.id,
            			name: user.name
            		};
            	});
            	send(ws, "LIST", list);
            	break;

            //使用者傳送訊息
            case "SEND":
            	var receiver = data.receiver;
            	var sender = data.sender;
                //從全部的使用者內挑選出要傳送的對象, 並傳送給他
            	users.map(function(user) {
					if (user.id == receiver || user.id == sender){
						send(user.ws, "SEND", {
							receiver: receiver,
							sender: sender,
							datetime: new Date().getTime(),
							message: data.message
						});
					}
            	});
        }
    });
});