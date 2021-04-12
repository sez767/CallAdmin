
function loadScript(url) {
    var oXmlHttp = new XMLHttpRequest();
    oXmlHttp.onreadystatechange = function () {
        if (oXmlHttp.readyState == XMLHttpRequest.DONE) {
            if (oXmlHttp.status == 200) {


                var x = oXmlHttp.getAllResponseHeaders();
                console.log(x);


                if (oXmlHttp.responseText != null) {
                    var oHead = document.getElementsByTagName('HEAD').item(0);
                    var oScript = document.createElement("script");
                    oScript.language = "javascript";
                    oScript.type = "text/javascript";
                    oScript.text = oXmlHttp.responseText;
                    oHead.appendChild(oScript);
                }
            } else {
                console.log("Error", oXmlHttp.statusText)
            }
        }
    }
    oXmlHttp.open('get', url);
    oXmlHttp.send();
}

        loadScript("https://shop.lendos.biz/js/video_widget.js");       

        let random = 333;
		let cshBtnVideoCall = document.querySelector("#cshBtnVideoCall"); // Кнопка "VideoCall"
		let cshLinkVideoCall = `https://video.ansecode.com/video?ex=${random}`; // Ссылка видеозвонка
		let cshNameVideoCall = "MyWindow"; // Имя нового окна
		let cshParametersVideoCall = "toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=no,resizable=yes,height=600,width=600"; // Параметры видеозвонка
		// При клике на кнопку "Позвонить", срабатывает событие
		cshBtnVideoCall.addEventListener("click", () => {
			window.open(cshLinkVideoCall, cshNameVideoCall, cshParametersVideoCall); // Открывает в новом окне видеозвонок
		});
        // 1. Создаём новый объект XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // 2. Конфигурируем его: GET-запрос на URL 'phones.json'
        xhr.open('GET', 'https://shop.lendos.biz/visits/getheaders', false);

        // 3. Отсылаем запрос
        xhr.send();

        // 4. Если код ответа сервера не 200, то это ошибка
        if (xhr.status != 200) {
        // обработать ошибку
        alert( xhr.status + ': ' + xhr.statusText ); // пример вывода: 404: Not Found
        } else {
        // вывести результат
        alert( xhr.responseText ); // responseText -- текст ответа.
        }