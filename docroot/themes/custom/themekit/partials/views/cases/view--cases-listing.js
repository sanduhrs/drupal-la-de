Drupal.behaviors.themekitPartners = {
  attach(context) {
    const view = context.classList && context.classList.contains('view-cases-listing')
      ? context
      : context.querySelector('.view-cases-listing');
    if (!view) return;

    const toggleFiltersButton = view.querySelector('.toggle-filters');
    if (!toggleFiltersButton) return;

    const filtersWrapper = view.querySelector('.form-checkboxes');
    if (!filtersWrapper) return;

    const filtersArray = filtersWrapper.querySelectorAll('.form-checkbox');
    if (!filtersArray.length) return;

    const toggleFilters = (button) => {
      const activeFilters = [...filtersArray].filter((input) => input.checked);
      if (activeFilters.length) {
        button.classList.add('active');
        filtersWrapper.classList.add('opened');
      } else {
        button.classList.remove('active');
        filtersWrapper.classList.remove('opened');
      }
    };

    toggleFilters();
    toggleFiltersButton.addEventListener('click', toggleFilters);
  },
};
