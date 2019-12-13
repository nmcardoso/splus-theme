/**
 * @param {Object} data 
 * @param {string} data.src
 * @param {string} data.title
 * @param {string} data.caption
 * @param {string} data.href
 * @param {Element} rootElement 
 */
function Mosaic(data, rootElement) {
  this.data = data
  this.container = rootElement
  this.margin = 0
  this.breakpoints = {
    small: 576,
    medium: 768,
    large: 992,
    xlarge: 1200,
    default: 99999999
  }

  this.container.classList.add('mosaic-gallery')

  this.calcImageWidth = function () {
    const vp = this.getCurrentViewport()
    const margin = this.margin[vp]
    const imgPerRow = this.imagePerRow[vp]

    return (this.container.clientWidth - (margin * imgPerRow * 2)) / imgPerRow
  }

  this.getCurrentViewport = function () {
    const k = Object.keys(this.breakpoints)

    for (let i = 0; i < k.length; i++) {
      const sizeName = k[i]
      const sizeValue = this.breakpoints[sizeName]

      if (this.container.clientWidth <= sizeValue) {
        return sizeName
      }
    }

    return 'large'
  }
}

Mosaic.prototype.render = function () {
  const w = this.calcImageWidth()
  const vp = this.getCurrentViewport()

  this.data.forEach(image => {
    const template = `
      <div class="mosaic-item" style="width: ${w}px; height: ${w}px; margin: ${this.margin[vp]}px">
        <a href="${image.href}">
          <img src="${image.src}" />
          <div class="caption">
            <p>${image.title}</p>
            <p class="d-none d-sm-block">${image.caption}</p>
          </div>
        </a>
      </div>
    `

    this.container.innerHTML += template
  })

  document.addEventListener('DOMContentLoaded', () => {
    window.addEventListener('resize', () => {
      const w = this.calcImageWidth()
      const vp = this.getCurrentViewport()

      this.container.querySelectorAll('.mosaic-item').forEach(img => {
        img.style.width = `${w}px`
        img.style.height = `${w}px`
        img.style.margin = `${this.margin[vp]}px`
      })
    })
  })
}

/**
 * @param {Object} margin
 * @param {number} margin.default
 * @param {number} margin.small
 * @param {number} margin.medium
 * @param {number} margin.large
 * @param {number} margin.xlarge
 */
Mosaic.prototype.setMargin = function (margin) {
  this.margin = margin
}

/**
 * @param {Object} quantity
 * @param {number} quantity.default
 * @param {number} quantity.small
 * @param {number} quantity.medium
 * @param {number} quantity.large
 * @param {number} quantity.xlarge
 */
Mosaic.prototype.imagesPerRow = function (quantity) {
  this.imagePerRow = quantity
}
