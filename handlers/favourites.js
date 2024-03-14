// соблюдаем делегирование событий - вешая клик на общего родителя
document.querySelector(".blog-list").addEventListener("click", function (e) {
    // убрать перезагрузку - если мы нажали на кнопку
    if (e.target.matches(".add-favourite")) {
        e.preventDefault();
        // раньше всё обрабатывалось сторонним сервером через АПИ теперь же мы будем обрабатывать всё сами в файле favourites.php
        const url = "handlers/favourites.php";
        // dataset - собирает все категории м после . всё то что после data-
        const postCategory = e.target.dataset.category;
        const postUrl = e.target.dataset.url;
        const data = {
            category: postCategory,
            url: postUrl,
            param: 'add_favourite'
        };
        // GET - получение данных
        // POST - отправка информации к ресурсу сервера
        // и иные запросы в чистом PHP
        // до fetch был синтаксис xhr.
        fetch(url, {
            // метод
            method: 'POST',
            // тип отправляеммой информации - мы отпровляем в формате json (т.к. сложный тип можем пересылать только в json аналог как с локал сторедж)
            contentType: 'application/json',
            // тело запроса
            body: JSON.stringify(data)
            // всё запрос отправлен на обработку в PHP после которой приходит ответ .then()
            // смотри файл favourites.php с логикой обработки php зпроса
        }).then(function (resp) {
            // работет и без echo - но это пришло обещание
            // console.log(resp);
            return resp.json();
        }).then(function (res) {
            // okОшибка подключение к БД  пришол наш ок с echo с доп информацией
            // т.о. в файле в котором обрабатываються данные с JS в нём не должно быть посторонних обработчиков и вывода
            console.log(res);
        })
    }
    // бэкенд формирует точки api.php static.php и т.д. куда фронтенд будет стучаться
    // запрос на сервер в точки и от туда echo возвращаеться
    // движок сервера apachi / nginx обрабатывают толь ко то что относиться к серверной части (заключено в теги PHP) всю верстку пропускает + подключаемые файлы
    // обработав PHP он формирует данные и подставляет данные в вёрстку а не как сейчас в index.php
    // т.о. насервере осттаёться весь PHP а на клиете приходить код HTML JS и.тд. без PHP
    // схема работы scram
    // аутсорсинг


})