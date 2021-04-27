
jQuery(document).ready(function () {
        show_videoframe();
        // onloadStatus();
        configButtons();
});

function show_videoframe() {
    var easy_vid = `
    <div class="content">
        <div id="media-view" class="media-view">
            <div id="info-input" class="info-div">
                <input type="text" readonly class="info-input" id="callInfoText" value="Секундочку..."/>
            </div>
            <div id="media-overlay" class="media-overlay">
                <video id="video" class="incvideo" autoPlay></video>
                <video id="lvideo" class="localvideo" autoPlay></video>
                <input type="button" class="hide" id="answerButton" onclick="answerC()" value="&#128222;"></input>
            </div>
            <div id="buttons-div" class="buttons-div">
            
            <input type="button" id="audio-out-btn" class="allButtons audio-out-btn" value="Звук"></input>
            <input type="button" id="audio-btn" class="allButtons audio-btn" value="Микрофон"></input>
            <input type="button" id="video-btn" class="allButtons video-btn" value="Камера"></input>
            <input type="button" id="exit-btn" class="allButtons exit-btn" value="Выход"></input>
            </div>
        </div>    
    </div>    
  `;

    $('body').append(easy_vid);
}

// function onloadStatus(){
//     var getStatus = localStorage.getItem('autoAnswer');
//     if (getStatus === "true"){
//         document.getElementById("autoAnswer").checked = true;
//     }    
// }
// function autoCheck(){
//     if(document.getElementById('autoAnswer').checked) {
//         localStorage.setItem('autoAnswer', "true");
//     } else {
//         localStorage.setItem('autoAnswer', "false");
//     }
// };

/////////////////jsSIP

// const accountIdName = '10011';// FILL USERNAME HERE
// const accountPassword = '10011'; // FILL PASSWORD HERE,
const socket = new JsSIP.WebSocketInterface('wss://shop.lendos.biz:8089/ws'); //WSS SERVER
var configuration = {
  sockets: [socket],
  'uri': `sip:${accountIdName}@shop.lendos.biz`,
  'password': accountPassword, //SS
  'username': accountIdName,  //$2y$10$AGneb6DT7WgEo4td4znpB.U998xgbV1R0hOi5x5F8bkEYuvm3X6q6
  'register': true
};

var incomingCallAudio = document.getElementById('insounds');
incomingCallAudio.crossOrigin="anonymous";
incomingCallAudio.loop = true;

var outcomingCallAudio = document.getElementById('outsounds');;
outcomingCallAudio.crossOrigin="anonymous";
outcomingCallAudio.loop = true;

var remoteAudio = new window.Audio();
remoteAudio.crossOrigin="anonymous";
remoteAudio.autoplay = true;

function mute(stream, options) {
	function setTracks(tracks, val) {
		if (!tracks) {
			return;
		}
		for (let i = 0; i < tracks.length; ++i) {
			if (tracks[i].enabled == val) {
				tracks[i].enabled = !val;
			}
		}
	};
	options = options || { audio: true, video: true };
	if (typeof options.audio != 'undefined') {
		setTracks(stream.getAudioTracks(), options.audio);
	}
	if (typeof options.video != 'undefined') {
		setTracks(stream.getVideoTracks(), options.video);
	}
}

function unmute(stream, options) {
	let opts = options || { audio: false, video: false };
	mute(stream, opts);
}

function configButtons(){
    let lvideo = document.getElementById("lvideo");
    let video = document.getElementById("video");
    let muteAudio = document.getElementById("audio-btn");
    muteAudio.setAttribute("state", "Unmute");
    
    muteAudio.onclick = function() {
        if(lvideo.srcObject){
        let state = this.getAttribute("state");
        this.setAttribute("state", state == "Mute" ? "Unmute" : "Mute");
        this.classList.toggle("line");
        mute(lvideo.srcObject, {audio: this.getAttribute("state") == "Mute"});   
        }
    };

    let muteVideo = document.getElementById("video-btn"); 
    muteVideo.setAttribute("state", "Unmute");
    muteVideo.onclick = function() {
        if(lvideo.srcObject){
        let state = this.getAttribute("state");
        this.setAttribute("state", state == "Mute" ? "Unmute" : "Mute");
        this.classList.toggle("line");
        mute(lvideo.srcObject, {video: this.getAttribute("state") == "Mute"});
        }
    }  
    let muteSound = document.getElementById("audio-out-btn");
    muteSound.setAttribute("state", "Unmute");
    muteSound.onclick = function() {
        if(video.srcObject){
        let state = this.getAttribute("state");
        this.setAttribute("state", state == "Mute" ? "Unmute" : "Mute");
        this.classList.toggle("line");
        mute(video.srcObject, {audio: this.getAttribute("state") == "Mute"});   
        }
    };
    let exit = document.getElementById("exit-btn");
        exit.onclick = function() {
            if(accountRole=='user'){
                window.close();
            }else{
                hangupC();
            }	
        };
}
function reloadButtons(){
    let muteAudio = document.getElementById("audio-btn");
    muteAudio.classList.remove("line");
    muteAudio.setAttribute("state", "Unmute")
    let muteVideo = document.getElementById("video-btn"); 
    muteVideo.setAttribute("state", "Unmute");
    muteVideo.classList.remove("line");
    let muteSound = document.getElementById("audio-out-btn");
    muteSound.setAttribute("state", "Unmute");
    muteSound.classList.remove("line");
}

var callOptions = {
    mediaConstraints: {audio: true, video: true},
    pcConfig:
    {
        hackStripTcp: true, 
        rtcpMuxPolicy: 'negotiate',
        iceServers: []
    },
    rtcOfferConstraints:
          { offerToReceiveAudio: 1, offerToReceiveVideo: 1 }
  };
var phone;
if(configuration.uri && configuration.password){
    // JsSIP.debug.enable('JsSIP:*'); ///////////////////////////// debug output
    phone = new JsSIP.UA(configuration);
    phone.on('registered', () => {
      $('#callInfoText').val('Вы в сети');
    });
    phone.on('registrationFailed', function(ev){
    	alert('Registering on SIP server failed with error: ' + ev.cause);
      $('#callInfoText').val('Регистрация провалена');
      configuration.uri = null;
      configuration.password = null;
      updateUI();
    });
    phone.on('newRTCSession',function(ev){
        var newSession = ev.session;
        if(session){
            session.terminate();
        }
        session = newSession;
        var completeSession = function(){
          $('#callInfoText').val('Звонок завершен')
        	session = null;
            reloadButtons();
          	updateUI();
        };
        session.on('ended', completeSession);
        session.on('failed', completeSession);
        session.on('accepted',function(){
          $('#callInfoText').val('Звонок принят')
          updateUI();
        });
        session.on('confirmed',function(){
            var localStream = session.connection.getLocalStreams()[0];
            let video = document.getElementById("lvideo");
            video.autoplay = true;
            video.srcObject = localStream;
            // var dtmfSender = session.connection.createDTMFSender(localStream.getAudioTracks()[0])
            // session.sendDTMF = function(tone){
            //     dtmfSender.insertDTMF(tone);
            // };
            updateUI();
        });
        session.on('peerconnection', (e) => {
          let logError = '';
          const peerconnection = e.peerconnection;

          peerconnection.onaddstream = function (e) {
            remoteAudio.srcObject = e.stream;
            remoteAudio.play();

            let video = document.getElementById("video");
            video.autoplay = true;
            video.srcObject = e.stream;
          };

          var remoteStream = new MediaStream();
          peerconnection.getReceivers().forEach(function (receiver) {
            remoteStream.addTrack(receiver.track);
          });

          
        });
      
        if(session.direction === 'incoming'){
            outcomingCallAudio.play();
            // var getStatus = localStorage.getItem('autoAnswer');////////////!!!!!!!!!!!!!11
            // if (1){
            //  session.answer(callOptions);
            // }
            let coller = session.remote_identity.uri.user
            $('#callInfoText').val(`Звонок от ${coller}`)
            updateUI();
        } else {
          incomingCallAudio.play();
          $('#callInfoText').val('Звоним оператору...')
          updateUI();

          session.connection.addEventListener('addstream', function(e){
            remoteAudio.srcObject = e.stream;
            let video = document.getElementById("lvideo");
            video.autoplay = true;
            video.srcObject = e.stream;

            video.onloadedmetadata = function() {
                let tracks = e.stream.getVideoTracks();
                for (let i = 0; i < tracks.length; ++i) {
                    tracks[i].enabled = true;
                }
            };
          });      
        }
    });
    phone.start();
}
var session;
updateUI();

function callC() {
    let dest = `991*${operator}`;
        phone.call(dest, callOptions);
        updateUI();
  
}

function answerC(){
    event.preventDefault();
    session.answer(callOptions);   
};

function hangupC(){
    event.preventDefault();
    if(!!session){
        session.terminate();
    }
};
function toVue(msg){
        window.parent.postMessage({
           'message': msg
        },'*');
   };

window.onload = function() {
    $('#callNumberText').keypress(function(e){
        if(e.which === 13){//Enter
         $('#cCall').click();
        }
    });

    if(accountRole == 'user'){
        setTimeout(function() {
            callC();
        }, 3000);
    }
};

function updateUI(){
    if(configuration.uri && configuration.password){
        if(session){
            if(session.isInProgress()){
                if(session.direction === 'incoming'){
                    toVue('true')
                    // $('.callTd').addClass("hide");
                    $('#answerButton').removeClass("hide");
                    // if($('.mainPhoneButton').html() == 'Развернуть телефон'){
                    //     $('.mainPhoneButton').addClass("redPhoneButton");
                    // }
                }else{
                 toVue('false')
                 $('#answerButton').addClass("hide");
                //   $('.callTd').removeClass("hide");
                //   $('.answerTd').addClass("hide"); 
                //   $('.tel').addClass("disabled")               
                }   
            }else if(session.isEstablished()){
                incomingCallAudio.pause();
                outcomingCallAudio.pause();
                toVue('false')
                $('#answerButton').addClass("hide");
                // $('.tel').addClass("disabled")
                // $('.mainPhoneButton').removeClass("redPhoneButton");
            }
        }else{
            incomingCallAudio.pause();
            outcomingCallAudio.pause();
            $("#video").load();
            $("#lvideo").load();
            toVue('false');
            $('#answerButton').addClass("hide");
            
        }
    }else{
        // $('#errorMessage').show();
    }
}

window.onunload = function() {
	if (phone) {
		phone.stop();
	}
};
