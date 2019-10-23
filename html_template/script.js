"use strict";

const navbarPosition = () => {
  let prevScrollpos = window.pageYOffset

  window.onscroll = () => {
    let currentScrollPos = window.pageYOffset

    if (prevScrollpos > currentScrollPos) {
      //console.log($('#navbar'))
      $('#navbar')[0].style.top = '0'
    } else {
      $('#navbar')[0].style.top = '-100px'
    }

    prevScrollpos = currentScrollPos
  }
}

const smoothScrollPolyfill = () => {
  $('a[data-smooth-scroll]').on('click', (event) => {
    if (this.hash !== "") {
      event.preventDefault()
      const hash = this.hash

      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, () => {
        window.location.hash = hash
      })
    }
  })
}

$(document).ready(e => {
  if (!('scrollBehavior' in document.documentElement.style)) {
    smoothScrollPolyfill()
  }

  navbarPosition()
})