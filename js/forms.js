document.addEventListener('DOMContentLoaded', function () {
  const forms = document.querySelectorAll('.js_form');
  
  async function handleSubmitForm(event) {
    event.preventDefault();

    // Берем текущую форму и кнопки отправки внутри нее
    const formNode = event.target;
    
    const submitButton = formNode.querySelector('button[type="submit"]');
    const submitButtonTextNode = submitButton.querySelector('.btn__text');

    // Запоминаем исходный текст кнопки
    const initialButtonText = submitButton.textContent;
    
    // Делаем кнопку некликабельной и меняем текст
    submitButton.classList.add('btn--loading');
    submitButtonTextNode.textContent = document.querySelector('.btn__text').dataset.btnLoadText
    //Осбираем данные из формы и отправляем их в mail.php
    const formData = new FormData(formNode)

    let redirectUrl = '';
    if (formData.get('redirect') != null) {
      redirectUrl = formData.get('redirect');
    }

    const response = await sendData(formData, formNode.action);

    // Меняем текст кнопки на галочку
    submitButtonTextNode.textContent = document.querySelector('.btn__text').dataset.btnLoadPure

    // Ждем 15 секунд, меняем текст кнопки на исходный и делаем кнопку кликабельной
    setTimeout(() => {
      submitButtonTextNode.innerText = initialButtonText;
      submitButton.classList.remove('btn--loading');
    }, 15000);

    // Чистим поля формы
    formNode.reset();

    setTimeout(() => {
      if (redirectUrl != '') {
        window.location.href = redirectUrl;
      }
    }, 1000)

    /*
    ✓  0. При отправке формы заменить текст кнопки на «отправвляем» и сделать ее некликабельной.
    ✓    1. Запомнить иходный текст кнопки
    ✓  1. Получить все значения инпутов из форм
    ✓  2. отправить значения инпутов из формы на mail.php
    ✓  3. меняем текст кнопки на галочку ✓ на 15 секунд, а после возвращаем исходный текст кнопки
    ✓  4. очистим форму после успешной отправки
    ✓  5. отправим в яндекс мтерику событие отправки формы
    */
  }  

  async function sendData(data,url) {
    if (typeof ym != 'undefined') {
      if (data.get('ym-event') != null) {
        ym(94322465,'reachGoal', data.get('ym_event'));
      }
    } else {
      console.warn('Не подключена яндекс метрика')
    }
    
    const response = await fetch(url, {
      method: 'POST',
      body: data,
    });

    return response;
  }

  function handleForms(form) {
    form.addEventListener('submit', handleSubmitForm);
  }
  forms.forEach(handleForms);

  // отправляем значение salebot

  // const myKeysValues = window.location.search;
  
  // const urlParams = new URLSearchParams(myKeysValues);

  // const salebotID = urlParams.get('salebot');

  // console.log("salebot;", salebotID)

  // const salebotInputs = document.querySelectorAll('input[name="salebot"]');

  // salebotInputs.forEach((input) => {
  //   input.value = salebotID
  // })

  

})


