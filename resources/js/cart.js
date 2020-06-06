import LiveEvent from './live'

class Cart {
  options = {
    routes: {
      index: '/cart',
      toggle: '/cart/toggle/',
      remove: '/cart/remove/',
      inc: '/cart/inc/',
      dec: '/cart/dec/',
      quantity: '/cart/quantity'
    },
    closeSuccessTimer: undefined
  }

  /**
   * Инициализация
   */
  init() {

    this.bind();

  }

  /**
   * "Навешиваем" события
   */
  bind() {
    const me = this;

    new LiveEvent('click', '[data-toggle-cart]', async function (e) {
      e.preventDefault();
      await me.toggle(this.dataset.id, this);
      return false;
    })

    new LiveEvent('click', '[data-cart-dec]', async function (e) {
      e.preventDefault();
      await me.dec(this.dataset.cartDec);
      return false;
    })

    new LiveEvent('click', '[data-cart-inc]', async function (e) {
      e.preventDefault();
      await me.inc(this.dataset.cartInc);
      return false;
    })

    new LiveEvent('click', '[data-cart-remove]', async function (e) {
      e.preventDefault();
      await me.remove(this.dataset.cartRemove);
      return false;
    })
  }

  async toggle(id, element) {
    await this.request(this.options.routes.toggle + id, {}, element);
  }

  async dec(position) {
    await this.request(this.options.routes.dec + position);
  }

  async inc(position) {
    await this.request(this.options.routes.inc + position);
  }

  async remove(position) {
    await this.request(this.options.routes.remove + position);
  }

  async request(route, request, element) {
    try {
      const result = await axios.create().get(route);
      const data = result.data;

      if (data.status && data.message) {
        this.message(data.status, data.message)
      }
      if (data.status === 'success') {
        await this.update();
      }
      if (element && typeof data.removeClass !== 'undefined') {
        element.classList.remove(data.removeClass)
      }
      if (element && typeof data.addClass !== 'undefined') {
        element.classList.add(data.addClass)
      }
    } catch (e) {
      console.log(e);
    }
  }

  /**
   * @param status "success"|"error"
   * @param message
   */
  message(status, message) {
    const me = this;
    if (status === 'success') {
      const successWrapper = document.querySelector('.cart-success-wrapper');
      console.log(successWrapper)
      if (successWrapper) {
        const item = successWrapper.querySelector('.cart-item-name');
        item.innerText = message;
        successWrapper.classList.add('show');

        clearTimeout(me.options.closeSuccessTimer);
        me.options.closeSuccessTimer = setTimeout(function () {
          me.closeSuccess();
        }, 4000);
      }
    }
  }


  closeSuccess() {
    const successWrapper = document.querySelector('.cart-success-wrapper');
    if (successWrapper) {
      successWrapper.classList.remove('show')
    }
  }

  async update() {
    let me = this;
    const blocks = document.querySelectorAll('[data-cart-block]');
    if (blocks.length > 0) {

      blocks.forEach((item) => {
        item.classList.add('loading')
      });

      const result = await axios.create().get(window.location.href);
      const page = result.data;

      this.updateBlocks(page);
    }
  }

  updateBlocks(page) {
    const fragPage = document.createRange().createContextualFragment(page);
    const blocks = fragPage.querySelectorAll('[data-cart-block]');

    blocks.forEach((block) => {
      const nameBlock = block.dataset.cartBlock;
      const pageBlock = document.querySelector('[data-cart-block="' + nameBlock + '"]');
      pageBlock.innerHTML = block.innerHTML;
      pageBlock.classList.remove('loading');
    });
  }
}

new Cart().init()