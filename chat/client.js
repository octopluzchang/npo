var users = [];
var self = {};
var ws = new WebSocket("ws://127.0.0.1:8080/");
var buffer = [];
ws.onopen = function(evt){
	send = function(method, data){
		data = JSON.stringify({
			m: method,
			d: data
		});
		ws.send(data);
	}
	for (var i in buffer){
		send(buffer[i][0], buffer[i][1]);
	}
};

//傳送封包
function send(method, data){
	buffer.push([method, data]);
}

ws.onmessage = function(message){
	message = JSON.parse(message.data);
	var method = message.m;
	var data = message.d;
	switch (method.toUpperCase()){
		case "SUCCESSLOGIN":
			send("LIST");
			break;

		case "LIST":
			data.map(addUser);
			break;

		case "HEARTBEAT":
			res = {
				m: "HEARTBEAT"
			};
			setTimeout(heartbeat, 1000);
			break;

		case "LOGIN":
			addUser(data);
			break;

		case "LOGOUT":
			$("[data-id=" + data.id + "]").remove();
			break;

		case "SEND":
			$chatbox = getChatbox(data.sender == self.id ? data.receiver : data.sender);
			$message = $("<div>")
				.addClass("message")
				.html(data.message);
			$message.wrapInner("<div class='" + (data.sender == self.id ? "send" : "receive") + "'></div>")
			$chatbox.find(".messages").append($message);
			break;
	}
}

//心跳包(用來評估使用者是否斷線)
function heartbeat(){
	ws.send(JSON.stringify(res));
}

//取得/建立聊天視窗
function getChatbox(id, title){
	id = id * 1;
	if ($(".chatbox[data-id="+id+"]").length){
		return $(".chatbox[data-id="+id+"]");
	}

	$chatbox = $(".chatbox.template")
		.clone()
		.removeClass("template");

	$chatbox.attr("data-id", id)
	$chatbox.appendTo(".chatbox-list");
	$chatbox.find(".title").html(users[id] ? users[id].name : title);
	$chatbox.find("input").on('keydown', function(e){
		if (e.keyCode == 13 && $(this).attr('data-last-key-code') == "13"){
			$this = $(this).parents(".chatbox");
			sendMessage(
				$this.attr("data-id"),
				$this.find("input").val()
			);
			$this.find("input").val("");	
		} else {
			$(this).attr('data-last-key-code', e.keyCode);
		}
	})
	$chatbox.find("button").on('click', function(e){
		$this = $(this).parent(".chatbox");
		sendMessage(
			$this.attr("data-id"),
			$this.find("input").val());
		$this.find("input").val("");
	});
	return $chatbox;
}

function sendMessage(receiver, message){
	if (message == ""){
		return;
	}
	send("SEND", {
		sender: self.id,
		receiver: receiver,
		message: message
	});
}

//建立使用者
function addUser(user){
	users[user.id] = user;
	$user = $(".user.template")
				.clone()
				.removeClass("template");
	$user.attr("data-id", user.id);
	$user.find(".name").html(user.name);
	$user.insertAfter($(".user.template"));
	$user.on('click', function(e){
		startChat($(this).attr("data-id"));
	});
}

//開始聊天
function startChat(id, title){
	$chatbox = getChatbox(id, title);
	$chatbox.find("input").focus();
}

//連線
function login(user){
	self = user;
	users[self.id] = self;
	send("LOGIN", self);
}