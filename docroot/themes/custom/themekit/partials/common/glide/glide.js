import Glide from '@glidejs/glide';

const sliders = {
  'glide-wrapper': {
    selector: '.glide__slide',
    options: {
      type: 'slider',
      startAt: 0,
      perView: 1,
      gap: 32,
      keyboard: false,
      bound: false,
      rewind: false,
      peek: { before: 0, after: 80 },
      breakpoints: {
        480: {
          perView: 1,
          gap: 20,
          peek: { before: 0, after: 50 },
        },
        768: {
          perView: 1,
          gap: 20,
          peek: { before: 0, after: 50 },
        },
      },
    },
  },
  'glide-wrapper-multiple': {
    selector: '.glide__slide',
    options: {
      type: 'slider',
      startAt: 0,
      perView: 4,
      gap: 32,
      keyboard: false,
      bound: false,
      rewind: false,
      peek: { before: 0, after: -80 },
      breakpoints: {
        480: {
          perView: 1,
          gap: 20,
          peek: { before: 0, after: 50 },
        },
        680: {
          perView: 2,
          gap: 20,
          peek: { before: 0, after: -80 },
        },
        1024: {
          perView: 3,
          gap: 20,
          peek: { before: 0, after: -70 },
        },
      },
    },
  },
};

Drupal.behaviors.slider = {
  attach(context) {
    if (typeof sliders !== 'undefined') {
      Object.keys(sliders).forEach((component) => {
        const sliderWrapper = context.classList && context.classList.contains(component)
          ? [context] : context.querySelectorAll(`.${component}`);
        if (sliderWrapper.length === 0) { return; }

        sliderWrapper.forEach((element) => {
          const elGlide = element.querySelector('.glide');
          const glide = new Glide(elGlide, sliders[component].options);
          window.glide = glide;

          elGlide.addEventListener('keyup', (e) => {
            if (e.keyCode === 39) glide.go('>');
            if (e.keyCode === 37) glide.go('<');
          });

          glide.mount();
        });
      });
    }
  },
};
