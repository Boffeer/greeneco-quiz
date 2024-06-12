document.addEventListener('DOMContentLoaded', function () {
    const quiz = new Swiper('.quiz__swiper', {
        allowTouchMove: false,
        // pagination: {
        //     el: ".qiuz__pagination",
        //     type: "fraction",
        //   },
        autoHeight: true,
        navigation: {
          nextEl: '.quiz__button-next',
          prevEl: '.quiz__button-prev',
        },
        on: {
          slideChange: function () {
            updateProgressBar (this);
            // Нужно добиться что бы когда на последней странице квиза, пропадала пагинация и менялся заголовок
            // и менялась кнопка и её позиция
            const lastSlideIndex = this.slides.length-1
            const quiz = this.el.closest(".quiz")
            quiz.querySelector(".qiuz__pagination").innerText = `${this.activeIndex + 1} / ${this.slides.length - 1}`
            

            const halfProgressIndex = Math.ceil(this.slides.length  / 2)
            if (halfProgressIndex == this.activeIndex) {
              const halfProgressEvent = new CustomEvent("halfProgress", {
                detail: {},
              });
              quiz.dispatchEvent(halfProgressEvent)
            }

            if (lastSlideIndex == this.activeIndex) {
              // console.log(quiz.querySelector('.qiuz__pagination'))

              quiz.classList.add("quiz--last__slide")
              const title = quiz.querySelector('.quiz__head-title')
              title.textContent = quiz.querySelector('.quiz__head-title').dataset.quizTitle
              document.querySelector(".quiz__head-icon").style.display='none';
            } else {
              // console.log(quiz.querySelector('.qiuz__pagination'))
              quiz.classList.remove("quiz--last__slide")
              
              const title = quiz.querySelector('.quiz__head-title')  
              title.textContent = quiz.querySelector('.quiz__head-title').dataset.quizTitleBack
              // title.innerText = 'Odpovězte na otázky a získejte výpočet + bonusy' 
              document.querySelector(".quiz__head-icon").style.display='block';
            }
          },
          init: function() {
              const quiz = this.el.closest(".quiz")
              quiz.addEventListener("halfProgress", (e) => {
                if (typeof dataLayer != 'undefined') {
                  dataLayer.push({'event': 'quizHalfProgress'});
                }
              });
          }
        }
      });

      function updateProgressBar(carousel) {
        let progress = (carousel.activeIndex + 1) / carousel.slides.length * 100;
        document.querySelector('.progress').style.width = progress + '%';
        progress = progress.toFixed(0);
        document.querySelector('.progress-bar-status-percent').innerHTML = progress + '%';
        // document.querySelector('.progress-bar-status-percent').innerHTML = progress + '%';
        // Надо сделать так что бы прогресс был округлённым в процентах
        // let percent = 15.999
        // percent = percent.toFixed(0);
        // console.log(percent)
      }


      const recommendation1 = new Swiper('.recommendation__swiper1', {
        // Кол-ва слайдов на показ за раз
        slidesPerView: 1,
        // Отступ между слайдерами 
        spaceBetween: 30,
        // Пагинация
        pagination: {
          el: ".swiper-pagination",
          clickable: true,

        },
        navigation: {
          nextEl: ".recommendation-next1",
          prevEl: ".recommendation-prev1",
        },
        breakpoints: {
          650: {
            slidesPerView: 1,
          },

          1024: {
            slidesPerView: 1,
          },
        },

      });

      const recommendation2 = new Swiper('.recommendation__swiper2', {
        // Кол-ва слайдов на показ за раз
        slidesPerView: 1,
        // Отступ между слайдерами 
        spaceBetween: 30,
        // Пагинация
        pagination: {
          el: ".swiper-pagination",
          clickable: true,

        },
        navigation: {
          nextEl: ".recommendation-next2",
          prevEl: ".recommendation-prev2",
        },
        breakpoints: {
          650: {
            slidesPerView: 1,
          },

          1024: {
            slidesPerView: 1,
          },
        },

      });

      const recommendation3 = new Swiper('.recommendation__swiper3', {
        // Кол-ва слайдов на показ за раз
        slidesPerView: 1,
        // Отступ между слайдерами 
        spaceBetween: 30,
        // Пагинация
        pagination: {
          el: ".swiper-pagination",
          clickable: true,

        },
        navigation: {
          nextEl: ".recommendation-next3",
          prevEl: ".recommendation-prev3",
        },
        breakpoints: {
          650: {
            slidesPerView: 1,
          },

          1024: {
            slidesPerView: 1,
          },
        },

      });

      const rewiesbottom = new Swiper('.rewies-bottom__swiper', {
        cssMode: true,
      navigation: {
        nextEl: ".rewies-bottom-button-next",
        prevEl: ".rewies-bottom-button-prev",
      },
      pagination: {
        el: ".rewies-bottom-pagination",
      },
      mousewheel: true,
      keyboard: true,
      });

      Fancybox.bind('[data-fancybox]', {
        beforeShow: (instance, current) => {
          if (current.type === 'image') {
            current.zoom = {
              click: 'auto', // disable zoom on click
              wheel: 'auto', // enable zoom with mousewheel
              pinch: 'auto' // enable zoom with pinch gesture on touch devices
            };
          }
        },
      });

      const telInputs = document.querySelectorAll('input[type="tel"]');
      telInputs.forEach(tel => {
        const maskOptions = {
          mask: '+7(999) 999-99-99',
          inputmode: 'tel',
        };
        if (typeof Inputmask == 'undefined') return;
        new Inputmask(maskOptions).mask(tel);
      })

  const telLinks = document.querySelectorAll('a[href^="tel:"]')
  telLinks.forEach((tel) => {
    tel.addEventListener('click', () => {
      if (typeof ym == 'undefined') {
        console.warn('Кажется, метрика не подключена');
        return;
      };

      ym(94322465,'reachGoal','click-phone');
    })
  })


// Заклинание на плавные якоря
function getTopOffset(percents = 100) {
    return window.innerHeight / 100 * percents;
}
function scrollTosectionToScroll(percents = 9) {
    const linkElems = document.querySelectorAll('[href^="#"]')
    if (!linkElems) return;
    for (let i = 0; i < linkElems.length; i++) {
        const link = linkElems[i];
        link.addEventListener('click', (e) => {
            e.preventDefault()
            let href = link.getAttribute('href')
            if (!href || href == "#") return;
            let sectionToScroll = document.querySelector(href)
            if (!sectionToScroll) return;
            if (sectionToScroll.classList.contains('poppa')) return;
            if (sectionToScroll.classList.contains('b_modal')) return;

            if (link.classList.contains('header__nav-link')) {
                window.closeBurger();
            }
            window.scroll({
                top: sectionToScroll.getBoundingClientRect().top + pageYOffset - getTopOffset(percents),
                left: 0,
                behavior: 'smooth'
            })
        })
    }
}
scrollTosectionToScroll(0);
// end Заклинание на плавные якоря




  

})
  
  