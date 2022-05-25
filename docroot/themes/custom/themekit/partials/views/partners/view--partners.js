Drupal.behaviors.themekitPartners = {
  attach(context) {
    const view = (context.classList && context.classList.contains('view-display-id-randomized')) ? context : context.querySelector('.view-display-id-randomized');
    if (!view) return;
    console.log(view);
  },
};
