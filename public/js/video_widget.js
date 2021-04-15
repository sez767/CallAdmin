
		let videoButton = document.createElement("input");
        videoButton.type = 'button'
        videoButton.value = 'Call';
        videoButton.id = 'cshBtnVideoCall';
		let docBody = document.querySelector("body");
        docBody.appendChild(videoButton);

		var scripts = document.getElementsByTagName('script');
        var index = scripts.length - 1;
        var myScript = scripts[index];
        var clientId = myScript.src.replace(/^[^\?]+\??/,'');

		let cshBtnVideoCall = document.querySelector("#cshBtnVideoCall"); // Кнопка "VideoCall"
		let cshLinkVideoCall = `https://shop.lendos.biz/video?rl=user&cl=${clientId}`; // Ссылка видеозвонка
		// let cshLinkVideoCall = `http://localhost:8090/video?rl=user&${clientId}`;
		let cshNameVideoCall = "MyWindow"; // Имя нового окна
		let cshParametersVideoCall = "toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=no,resizable=yes,height=600,width=600"; // Параметры видеозвонка
		// При клике на кнопку "Позвонить", срабатывает событие
		cshBtnVideoCall.addEventListener("click", () => {
			window.open(cshLinkVideoCall, cshNameVideoCall, cshParametersVideoCall); // Открывает в новом окне видеозвонок
		});

        var xhr = new XMLHttpRequest(); //Отправка хедера для подсчета визитеров
        xhr.open('POST', `https://shop.lendos.biz/visits/gethead?${clientId}`, false);
        xhr.send();
