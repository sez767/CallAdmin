
let phone;

window.onload = function() {
	var enterParams = {
		accountId: '7245',
		accountName: '',
		accountPassword: '5993293',
		accountHost: 'shop.lendos.biz',
		extension: ext,
		accountRegister: true
	}
    createButtons()
	createModal();

	function findMediaView(parent, stream) {
		let nodes = parent.childNodes;

		for (let i = 0; i < nodes.length; ++i) {
			if (nodes[i].id == stream.id) {
				return nodes[i];
			}
		}

		return null;
	}

    function createButtons(){
        let buttonsDiv = document.createElement("div");
        buttonsDiv.className = "connection";

        let connectButton = document.createElement("input");
        connectButton.type = 'button'
        connectButton.value = 'Connect';
        connectButton.id = 'connect';
        connectButton.className = "connect";

        let callButton = document.createElement("input");
        callButton.type = 'button'
        callButton.value = 'Call';
        callButton.id = 'call';
        callButton.className = "call";
        callButton.disabled = true;

        buttonsDiv.appendChild(connectButton);
        buttonsDiv.appendChild(callButton);

        let docBody = document.querySelector("body");
        docBody.appendChild(buttonsDiv);   //?????
    }

	function createModal(){
		var modalBorder = document.createElement("div");
		modalBorder.classList.add("modall");
		modalBorder.id = "mod";
		let modalDialog = document.createElement("div");
		modalDialog.classList.add("modall-dialog");
		let modalContent = document.createElement("div");
		modalContent.classList.add("modall-content");
		let modalHeader = document.createElement("div");
		modalHeader.classList.add("modall-header");
		let modalBody = document.createElement("div");
		modalBody.classList.add("modall-body");
		modalBody.id = "body";
		let modalControls = document.createElement("div");
		modalControls.classList.add("media-controls");
		modalControls.id = "mcontrols";
		let modalTitle = document.createElement("h3");
		modalTitle.classList.add("modall-title");
		modalTitle.innerHTML = "Видеозвонок"
		let close = document.createElement("div");
		let showm = document.querySelector("body");	
		modalHeader.appendChild (modalTitle)
		modalHeader.appendChild(close)
		modalBody.appendChild (modalControls)
		modalContent.appendChild (modalHeader)
		modalContent.appendChild (modalBody)
		modalDialog.appendChild (modalContent)
		modalBorder.appendChild (modalDialog)
		showm.appendChild (modalBorder)
	
	
	}
	function showModal() {
		let mod = document.getElementById("mod")
		mod.classList.add("show");
	}

	function createMediaControls(video) {
		let controls = document.getElementById("mcontrols")
		let audioTracks = video.srcObject.getAudioTracks();
		if (audioTracks.length > 0) {
			let muteAudio = document.createElement("input");
			muteAudio.type = "button";
			muteAudio.value = 'Звук';
			muteAudio.className = "audio-out-btn";
			muteAudio.classList.add("allButtons");
			muteAudio.setAttribute("state", "Unmute");
			
			muteAudio.onclick = function() {
				let state = this.getAttribute("state");
				this.setAttribute("state", state == "Mute" ? "Unmute" : "Mute");
				this.classList.toggle("line");
				mute(video.srcObject, {audio: this.getAttribute("state") == "Mute"});
			};
			controls.appendChild(muteAudio);
		}
			let exit= document.createElement("input");
			exit.type = "button";
			exit.value = "Выход";
			exit.className = "exit-btn";
			exit.classList.add("allButtons");
			controls.appendChild(exit);
			exit.onclick = function() {
				phone.terminate();
				let mod = document.getElementById("mod")
				mod.classList.remove("show")
				mod.remove()
			};
		return controls;
	}
	function createMediaControlsLocal(video) {
		let controls = document.getElementById("mcontrols")
        let audioTracks = video.srcObject.getAudioTracks();
		if (audioTracks.length > 0) {
			let muteAudio = document.createElement("input");
			muteAudio.type = "button";
			muteAudio.value = 'Микрофон';
			muteAudio.className = "audio-btn";
			muteAudio.classList.add("allButtons");
			muteAudio.setAttribute("state", "Unmute");
			
			muteAudio.onclick = function() {
				let state = this.getAttribute("state");
				this.setAttribute("state", state == "Mute" ? "Unmute" : "Mute");
				this.classList.toggle("line");
				mute(video.srcObject, {audio: this.getAttribute("state") == "Mute"});
			};
			controls.prepend(muteAudio);
		}
		let videoTracks = video.srcObject.getVideoTracks();
		if (videoTracks.length > 0) {
			let muteVideo = document.createElement("input");
			muteVideo.type = "button";
			muteVideo.value = "Камера";
			muteVideo.className = "video-btn";
			muteVideo.classList.add("allButtons");
			muteVideo.setAttribute("state", "Unmute");
			muteVideo.onclick = function() {
				let state = this.getAttribute("state");
				this.setAttribute("state", state == "Mute" ? "Unmute" : "Mute");
				this.classList.toggle("line");
				mute(video.srcObject, {video: this.getAttribute("state") == "Mute"});
			};
			controls.prepend(muteVideo);
		}
			return controls;
	}

	function createMediaView(stream) {

		let mediaView = document.createElement("div");
		mediaView.className = "media-view";
		mediaView.id = stream.id;
		let videoView = document.createElement("div");
		let videoOverlay = document.createElement("div");
		videoOverlay.classname = "media-overlay";

		if (stream.local == false) {
			let audioTracks = stream.getAudioTracks();
			let videoTracks = stream.getVideoTracks();
			let videoText = document.createTextNode("Видео не доступно");
			if (audioTracks.length > 0) {
				videoText = document.createTextNode("Только звук");
			} else if (videoTracks.length > 0) {
				videoText = document.createTextNode("Ждем видео");
			}
			videoOverlay.appendChild(videoText);

			function checkForVideo() {
				if (video.videoWidth < 10 || video.videoHeight < 10) {
					videoView.style.display = 'none';
					return;
				}

				videoOverlay.removeChild(videoText);

				videoText = document.createTextNode("");
				videoOverlay.appendChild(videoText);

				videoView.style.display = 'inline-block';
			}

			setInterval(checkForVideo, 1000);
		} else {
			mediaView.classList.add("localvid");
		}

		mediaView.appendChild(videoOverlay);
		let video = document.createElement("video");
		video.autoplay = true;
		video.srcObject = stream;
		video.onloadedmetadata = function() {
			let tracks = stream.getVideoTracks();

			for (let i = 0; i < tracks.length; ++i) {
				tracks[i].enabled = true;
			}
		};
		if (stream.local == true) {
			video.muted = true;
		} else {
			videoView.style.display = 'none';
		}

		videoView.appendChild(video);
		mediaView.appendChild(videoView);
		if (stream.local == true) {
			createMediaControlsLocal(video);
		}else{
			createMediaControls(video);	
		}
		return mediaView;
	}

	function removeMediaView(parent, stream) {
		let node = findMediaView(parent, stream);
		if (node) {
			parent.removeChild(node);
		}
	}

	function getValue(id) {
		let obj = document.getElementById(id);
		return obj.value ? obj.value : obj.placeholder;
	}

	document.getElementById("connect").addEventListener("click", function() {
		if (document.getElementById("connect").value == "Disconnect") {
			document.getElementById("call").value = "Call";
			document.getElementById("call").disabled = true;
			document.getElementById("connect").value = "Disconnecting";
			document.getElementById("connect").disabled = true;
			phone.disconnect();
			return;
		}

		phone = new CyberMegaPhone(
			enterParams.accountId,
			enterParams.accountName,
			enterParams.accountPassword,
			enterParams.accountHost,
			enterParams.accountRegister
		);						

		phone.handle("connected", function () {
			if (document.getElementById("connect").value != "Disconnect") {
				document.getElementById("connect").value = "Registering";
			} else {
				document.getElementById("connect").value = "Disconnect";
				document.getElementById("connect").disabled = false;
				document.getElementById("call").disabled = false;
			}
		});

		phone.handle("disconnected", function () {
			document.getElementById("connect").value = "Connect";
			document.getElementById("connect").disabled = false;
			document.getElementById("call").value = "Call";
			document.getElementById("call").disabled = true;
		});

		phone.handle("registered", function () {
			document.getElementById("connect").value = "Disconnect";
			document.getElementById("connect").disabled = false;
			document.getElementById("call").disabled = false;
		});

		phone.handle("registrationFailed", function () {
			phone.disconnect();
		});

		phone.handle("incoming", function (reason) {
			document.getElementById("call").value = "Answer";
		});

		phone.handle("failed", function (reason) {
			document.getElementById("call").value = "Call";
			document.getElementById("call").disabled = false;
		});

		phone.handle("ended", function (reason) {
			document.getElementById("call").value = "Call";
			document.getElementById("call").disabled = document.getElementById("connect").value == "Connect";
		});

		phone.handle("streamAdded", function (stream) {
			if(!document.getElementById("mod")){
				createModal();
			}
			let mod = document.getElementById("mod")
			let body = document.getElementById("body")
			let elem = body.appendChild(createMediaView(stream));
			elem.parentNode.insertBefore(elem, elem.parentNode.firstChild)
			document.getElementById("call").value = "Hangup";
			document.getElementById("call").disabled = false;
			mod.classList.add("show");
		});

		phone.handle("streamRemoved", function (stream) {
			let modal = document.getElementById("mod")
			removeMediaView(modal, stream);
		});

		phone.connect();

		document.getElementById("connect").disabled = true;
		document.getElementById("connect").value = "Connecting";
	});

	document.getElementById("call").addEventListener("click", function() {
		let node = document.getElementById("call");

		if (node.value == "Call") {
			phone.call(enterParams.extension);
			node.disabled = true;
			node.value = "Ringing";
		} else if (node.value == "Answer") {
			node.disabled = true;
			node.value = "Hangup";
		} else {
			node.value = "Call";
			phone.terminate();
		}
	});

}; // window.onload

window.onunload = function() {
	if (phone) {
		phone.disconnect();
	}
}; 
// window.onunload