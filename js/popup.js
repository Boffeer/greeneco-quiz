document.addEventListener('DOMContentLoaded', function () {
    let popupBg = document.querySelector('.popup__bg'); // Фон попап окна
    let popup = document.querySelector('.popup'); // Само окно
    let openPopupButtons = document.querySelectorAll('.open-popup'); // Кнопки для показа окна
    let closePopupButton = document.querySelector('.popup__close'); // Кнопка для скрытия окна

    openPopupButtons.forEach((button) => { // Перебираем все кнопки
        button.addEventListener('click', (e) => { // Для каждой вешаем обработчик событий на клик
            e.preventDefault(); // Предотвращаем дефолтное поведение браузера
            popupBg.classList.add('active'); // Добавляем класс 'active' для фона
            popup.classList.add('active'); // И для самого окна
        })
    });

    closePopupButton.addEventListener('click',() => { // Вешаем обработчик на крестик
        popupBg.classList.remove('active'); // Убираем активный класс с фона
        popup.classList.remove('active'); // И с окна
    });

    document.addEventListener('click', (e) => { // Вешаем обработчик на весь документ
        if(e.target === popupBg) { // Если цель клика - фон, то:
            popupBg.classList.remove('active'); // Убираем активный класс с фона
            popup.classList.remove('active'); // И с окна
        }
    });




    let popupBg2 = document.querySelector('.popup__bg2'); // Фон попап окна
    let popup2 = document.querySelector('.popup2'); // Само окно
    let openPopupButtons2 = document.querySelectorAll('.open-popup2'); // Кнопки для показа окна
    let closePopupButton2 = document.querySelector('.popup__close2'); // Кнопка для скрытия окна

    openPopupButtons2.forEach((button) => { // Перебираем все кнопки
        button.addEventListener('click', (e) => { // Для каждой вешаем обработчик событий на клик
            e.preventDefault(); // Предотвращаем дефолтное поведение браузера
            popupBg2.classList.add('active'); // Добавляем класс 'active' для фона
            popup2.classList.add('active'); // И для самого окна
        })
    });

    closePopupButton2.addEventListener('click',() => { // Вешаем обработчик на крестик
        popupBg2.classList.remove('active'); // Убираем активный класс с фона
        popup2.classList.remove('active'); // И с окна
    });

    document.addEventListener('click', (e) => { // Вешаем обработчик на весь документ
        if(e.target === popupBg2) { // Если цель клика - фон, то:
            popupBg2.classList.remove('active'); // Убираем активный класс с фона
            popup2.classList.remove('active'); // И с окна
        }
    });
})