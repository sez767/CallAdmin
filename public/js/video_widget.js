		document.head.innerHTML += `<link type="text/css" rel="stylesheet" href="https://shop.lendos.biz/css/callwidget.css">`;
		let videoButton = document.createElement("button");
        videoButton.type = 'button'
        // videoButton.innerHTML = 'Call';
        videoButton.id = 'cshBtnVideoCall';
		videoButton.className = "callBtn";
		videoButton.title = "Видеозвонок оператору";
		let docBody = document.querySelector("body");
		let image = document.createElement("img");
		image.src = "https://shop.lendos.biz/images/calloperator.svg"
		videoButton.appendChild(image);
        docBody.appendChild(videoButton);

		var scripts = document.getElementsByTagName('script');
        var index = scripts.length - 1;
        var myScript = scripts[index];
        var clientId = myScript.src.replace(/^[^\?]+\??/,'');

		let cshBtnVideoCall = document.querySelector("#cshBtnVideoCall");
		let cshLinkVideoCall = `https://shop.lendos.biz/videoclient?${clientId}`; // Ссылка видеозвонка
		// let cshLinkVideoCall = `http://localhost:8090/videoclient?${clientId}`;
		let cshNameVideoCall = "MyWindow";
		let cshParametersVideoCall = "toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=no,resizable=yes,height=600,width=650"; // Параметры видеозвонка
		// При клике на кнопку "Позвонить", срабатывает событие
		cshBtnVideoCall.addEventListener("click", () => {
			window.open(cshLinkVideoCall, cshNameVideoCall, cshParametersVideoCall); // Открывает в новом окне видеозвонок
		});

        var xhr = new XMLHttpRequest(); //Отправка хедера для подсчета визитеров
        xhr.open('POST', `https://shop.lendos.biz/visits/gethead?${clientId}`, false);
        xhr.send();
