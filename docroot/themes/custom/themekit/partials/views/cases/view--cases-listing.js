Drupal.behaviors.themekitPartners = {
  attach(context) {
    const view = context.classList && context.classList.contains('view-cases-listing')
      ? context
      : context.querySelector('.view-cases-listing');
    if (!view) return;

    const toggleFiltersButton = view.querySelector('.toggle-filters');
    if (!toggleFiltersButton) return;

    const filtersWrapper = view.querySelector('.bef-checkboxes');
    if (!filtersWrapper) return;

    const filtersArray = filtersWrapper.querySelectorAll('.form-checkbox');
    if (!filtersArray.length) return;

    const form = view.querySelector('.views-exposed-form');
    if (!form) return;

    toggleFiltersButton.addEventListener('click', (event) => {
      event.target.classList.toggle('active');
      filtersWrapper.classList.toggle('opened');
    });

    const handleFilters = () => {
      const activeFilters = [...filtersArray].filter((input) => input.checked);
      if (activeFilters.length > 0) {
        toggleFiltersButton.classList.add('active');
        filtersWrapper.classList.add('opened');
      }
    };

    handleFilters();
    form.addEventListener('submit', handleFilters);
  },
};
