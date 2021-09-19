let menu = document.querySelector('.hamburger'),
    menuNav = document.querySelector('.nav-main'),
    menuNavDouble = document.querySelector('.nav-main_double'),
    menuNavDoubleNext = document.querySelector('.nav-main_double_next'),
    slideNumArea = document.querySelector('.swiper-num-area'),
    slideNumAreaProg = document.querySelector('.programs-slider .swiper-num-area')
    

menu.addEventListener('click', () => {
  if (document.body.clientWidth <= 768) {
    menu.classList.toggle('active');
    document.querySelector('body').classList.toggle('active');
  }
})

if (document.querySelector('.article')) {

  var galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 10,
    slidesPerView: 4,
    loop: true,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });
  var galleryTop = new Swiper('.gallery-top', {
    spaceBetween: 10,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    thumbs: {
      swiper: galleryThumbs,
    },
  });

}


if (document.querySelector('.hero')) {
// tabs

  let tab = document.getElementsByClassName('info-header-tab');
  tabs = document.querySelectorAll('.info-header-tab');
  tabcontent = document.getElementsByClassName('info-tabcontent');
  info = document.getElementsByClassName('info-header')[0];

  function hideTabContent(a) {
    for (let i = a; i < tabcontent.length; i++) {
      tabcontent[i].classList.remove('show');
      tabcontent[i].classList.add('hide');
    }
  }

  hideTabContent(1);

  function showTabContent(b) {
    if (tabcontent[b].classList.contains('hide')) {
      hideTabContent(0);
      tabcontent[b].classList.remove('hide');
      tabcontent[b].classList.add('show');
    }
  }

  info.addEventListener('click', (event) => {
    let target = event.target;
    for (let i = 0; i < tabs.length; i++) {
      tabs[i].classList.remove('active')
    }
    target.classList.add('active')

    if (target.classList.contains('info-header-tab')) {

      for (let i = 0; i < tabcontent.length; i++) {
        if (target == tab[i]) {
          showTabContent(i);
          break;
        }
      }
    }
  })



  var andSwiper = new Swiper('.section-slider', {
    speed: 700,
    direction: 'horizontal',
    spaceBetween: 30,
    slidesPerView: 1,
    clickable: true,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      768: {
        speed: 700,
        direction: 'horizontal',
        clickable: true,
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        }
      }
    }
  })

  var progSwiper = new Swiper('.programs-slider', {
    speed: 700,
    direction: 'horizontal',
    spaceBetween: 30,
    slidesPerView: 1,
    clickable: true,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: '.programs-slider .swiper-button-next',
      prevEl: '.programs-slider .swiper-button-prev',
    },
    breakpoints: {
      768: {
        speed: 700,
        direction: 'horizontal',
        clickable: true,
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        navigation: {
          nextEl: '.programs-slider .swiper-button-next',
          prevEl: '.programs-slider .swiper-button-prev',
        }
      }
    }
  })

  andSwiper.on('slideChange', function () {
       setTimeout(function () {
        let slideNum = document.querySelector('.swiper-slide-active');
        slideNumArea.innerHTML = slideNum.getAttribute('data-num') + '/'
    }, 1000);
    
  });

  progSwiper.on('slideChange', function () {
    setTimeout(function () {
     let slideNum = document.querySelector('.programs-slider .swiper-slide-active');
     slideNumAreaProg.innerHTML = slideNum.getAttribute('data-num') + '/'
 }, 1000);
 
});
  // window.onresize = function () {
  //   setTimeout(function () {
  //     var andSwiper = new Swiper('.section-slider', {
  //       speed: 700,
  //       direction: 'horizontal',
  //       spaceBetween: 30,
  //       slidesPerView: 2,
  //       clickable: true,
  //       spaceBetween: 20,
  //       pagination: {
  //         clickable: true,
  //         el: '.mainlp-swiper_pagination'
  //       },
  //       breakpoints: {
  //         768: {
  //           speed: 700,
  //           direction: 'horizontal',
  //           clickable: true,
  //           slidesPerView: 4,
  //           spaceBetween: 30,
  //           allowSlidePrev: true,
  //           allowSlideNext: true,
  //           pagination: false,
  //           navigation: {
  //             nextEl: '.swiper-button-next',
  //             prevEl: '.swiper-button-prev',
  //           }
  //         }
  //       }
  //     })
  //   }, 1000);
  // }

}

var $tabs = function (target) {
  var
    _elemTabs = (typeof target === 'string' ? document.querySelector(target) : target),
    _eventTabsShow,    
    _showTab = function (tabsLinkTarget) {
      var tabsPaneTarget, tabsLinkActive, tabsPaneShow;
      tabsPaneTarget = document.querySelector(tabsLinkTarget.getAttribute('href'));
      tabsLinkActive = tabsLinkTarget.parentElement.querySelector('.tabs__link_active');
      tabsPaneShow = tabsPaneTarget.parentElement.querySelector('.tabs__pane_show');
      // если следующая вкладка равна активной, то завершаем работу
      if (tabsLinkTarget === tabsLinkActive) {
        return;
      }
      // удаляем классы у текущих активных элементов
      if (tabsLinkActive !== null) {
        tabsLinkActive.classList.remove('tabs__link_active');
      }
      if (tabsPaneShow !== null) {
        tabsPaneShow.classList.remove('tabs__pane_show');
      }
      // добавляем классы к элементам (в завимости от выбранной вкладки)
      tabsLinkTarget.classList.add('tabs__link_active');
      tabsPaneTarget.classList.add('tabs__pane_show');
      document.dispatchEvent(_eventTabsShow);
    },
    _switchTabTo = function (tabsLinkIndex) {
      var tabsLinks = _elemTabs.querySelectorAll('.tabs__link');
      if (tabsLinks.length > 0) {
        if (tabsLinkIndex > tabsLinks.length) {
          tabsLinkIndex = tabsLinks.length;
        } else if (tabsLinkIndex < 1) {
          tabsLinkIndex = 1;
        }
        _showTab(tabsLinks[tabsLinkIndex - 1]);
      }
    };
    if (_elemTabs !== null) {
      _elemTabs.classList.remove('.tabs');
    }

  _eventTabsShow = new CustomEvent('tab.show', { detail: _elemTabs });

  _elemTabs.addEventListener('click', function (e) {
    var tabsLinkTarget = e.target;
    // завершаем выполнение функции, если кликнули не по ссылке
    if (!tabsLinkTarget.classList.contains('tabs__link')) {
      return;
    }
      // отменяем стандартное действие
    e.preventDefault();
    _showTab(tabsLinkTarget);
    
  }); 

  return {
    showTab: function (target) {
      _showTab(target);
    },
    switchTabTo: function (index) {
      _switchTabTo(index);
    }
  }

};



