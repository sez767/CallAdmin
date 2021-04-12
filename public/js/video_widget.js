
		let cshBtnVideoCall = document.querySelector("#cshBtnVideoCall"); // Кнопка "VideoCall"
		let cshLinkVideoCall = `https://video.ansecode.com/video`; // Ссылка видеозвонка
		let cshNameVideoCall = "MyWindow"; // Имя нового окна
		let cshParametersVideoCall = "toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=no,resizable=yes,height=600,width=600"; // Параметры видеозвонка
		// При клике на кнопку "Позвонить", срабатывает событие
		cshBtnVideoCall.addEventListener("click", () => {
			window.open(cshLinkVideoCall, cshNameVideoCall, cshParametersVideoCall); // Открывает в новом окне видеозвонок
		});

        var scripts = document.getElementsByTagName('script');
        var index = scripts.length - 1;
        var myScript = scripts[index];
        var queryString = myScript.src.replace(/^[^\?]+\??/,'');
        console.log('client',queryString);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', `https://shop.lendos.biz/visits/gethead?cl=${client_id}`, false);
        xhr.send();
