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

const bsColumns = () => {
  const $rows = $('.wp-block-columns')
  $rows.each((i, e) => {
    e.classList.add('row')

    const n = [].slice.call(e.classList).reduce((prev, curr) => {
      if (prev.found) return prev

      const m = curr.match(/has-(\d)-columns/)

      if (m && m[1]) {
        return { found: true, value: parseInt(m[1]) }
      } else {
        return { found: false, value: null }
      }
    }, { found: false, value: null }).value

    if (!n) return

    const d = 12 / n

    $(e).children().each((j, c) => {
      c.classList.add(`col-md-${d}`)
    })
  })
}

$(document).ready(e => {
  if (!('scrollBehavior' in document.documentElement.style)) {
    smoothScrollPolyfill()
  }

  navbarPosition()

  bsColumns()
})