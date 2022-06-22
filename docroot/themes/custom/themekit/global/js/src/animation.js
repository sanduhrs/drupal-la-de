/**
 * @file
 * Animations functionality
 */

Drupal.behaviors.themekitAnimations = {
  attach(context) {
    const page = context.classList && context.classList.contains('is-home-banner') ? context : context.querySelector('.is-home-banner');
    if (!page) { return; }

    const elements = page.querySelectorAll('.layout-content .block');
    if (!elements.length) { return; }

    const options = {
      threshold: 0.3,
    };

    const inViewCallback = (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animated');
        }
      });
    };

    const observer = new IntersectionObserver(inViewCallback, options);
    elements.forEach((element) => {
      observer.observe(element);
    });
  },
};
