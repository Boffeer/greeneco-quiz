/*
  Проверяет был ли клик за пределами выбранного блока
 */
  function getClickedNotBeyondElement(e, selector) {
    // let isElementClicked = false;
    let clickedElement;
    const path = e.path || (e.composedPath && e.composedPath());
    const isSelect = path.map((item, index, pathElems) => {
      if (pathElems.length - 4 < index) return;
      if (item.classList.contains(selector)) {
        // isElementClicked = true;
        clickedElement = item;
      }
    })
    if (clickedElement !== undefined) return clickedElement;
    return false
    // return isElementClicked;
}


// Кастомный select
const selectNodes = document.querySelectorAll('.form-select');

function initSelects(selectNodes) {
  selectNodes.forEach(selectNode => {
    if (selectNode.classList.contains('is-init')) return;

    const inputNode = selectNode.querySelector('.form-select__input');
    const toggleNode = selectNode.querySelector('.form-select__toggle');
    const buttonNodes = [...selectNode.querySelectorAll('.form-select__button')];

    toggleNode.addEventListener('click', handleToggle);


    buttonNodes.forEach((buttonNode, index, arr) => {
      buttonNode.addEventListener('click', () => {
        buttonNodes.forEach(buttonNode => buttonNode.classList.remove('form-select__button--active'));
        buttonNode.classList.add('form-select__button--active');
        inputNode.selectedIndex = index + 1;
        toggleNode.classList.add('form-select__toggle--selected');
        toggleNode.textContent = buttonNode.textContent;
      });
    });

    function handleToggle(evt) {
      evt.stopPropagation();
      selectNode.classList.toggle('form-select--active');

      if (selectNode.classList.contains('form-select--active')) {
          toggleNode.removeEventListener('click', handleToggle);
          document.addEventListener('click', handleDocument);
      }
    }

    function handleDocument(e) {
      selectNode.classList.remove('form-select--active');

      document.removeEventListener('click', handleDocument);
      selectNode.addEventListener('click', handleToggle);
    }

    selectNode.classList.add('is-init')
  });
}
initSelects(selectNodes);
