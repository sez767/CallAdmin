
        let random = 333;
		let cshBtnVideoCall = document.querySelector("#cshBtnVideoCall"); // Кнопка "VideoCall"
		let cshLinkVideoCall = `https://video.ansecode.com/video?ex=${random}`; // Ссылка видеозвонка
		let cshNameVideoCall = "MyWindow"; // Имя нового окна
		let cshParametersVideoCall = "toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbars=no,resizable=yes,height=600,width=600"; // Параметры видеозвонка
		// При клике на кнопку "Позвонить", срабатывает событие
		cshBtnVideoCall.addEventListener("click", () => {
			window.open(cshLinkVideoCall, cshNameVideoCall, cshParametersVideoCall); // Открывает в новом окне видеозвонок
		});



        var xhr = new XMLHttpRequest();
        // let csrftoken = Cookies.get('csrftoken');

        // xhr.setRequestHeader("X-CSRFToken", csrftoken);

        xhr.open('POST', 'https://shop.lendos.biz/visits/gethead', false);

        xhr.send();

        // 4. Если код ответа сервера не 200, то это ошибка
        if (xhr.status != 200) {
        // обработать ошибку
        alert( xhr.status + ': ' + xhr.statusText ); // пример вывода: 404: Not Found
        } else {
        // вывести результат
        alert( xhr.responseText ); // responseText -- текст ответа.
        }