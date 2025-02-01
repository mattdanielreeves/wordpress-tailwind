(function ($) {
  // Function to check and disable options in the header layouts
  function checkHeaderSelectFields() {
    let frontSelected = false;
    let innerSelected = false;

    // Iterate over each "header" layout select field
    $('.acf-flexible-content .layout[data-layout="header"] .acf-field-select select').each(function () {
      let selectedValue = $(this).val();

      // If "front" is selected, mark it and disable it in other instances
      if (selectedValue === 'front') {
        frontSelected = true;
      }

      // If "inner" is selected, mark it and disable it in other instances
      if (selectedValue === 'inner') {
        innerSelected = true;
      }
    });

    // Iterate over each "header" layout select field again to disable the options
    $('.acf-flexible-content .layout[data-layout="header"] .acf-field-select select').each(function () {
      let $select = $(this);

      // Enable all options first
      $select.find('option').prop('disabled', false);

      // Disable "front" option if already selected in another instance
      if (frontSelected && $select.val() !== 'front') {
        $select.find('option[value="front"]').prop('disabled', true);
      }

      // Disable "inner" option if already selected in another instance
      if (innerSelected && $select.val() !== 'inner') {
        $select.find('option[value="inner"]').prop('disabled', true);
      }
    });
  }

  // Run check when the page loads
  $(document).ready(function () {
    checkHeaderSelectFields();
  });

  // Run check when a new flexible content layout is added
  $(document).on('acf/append', function (e, $el) {
    checkHeaderSelectFields();
  });

  // Run check when a select field value changes
  $(document).on('change', '.acf-flexible-content .layout[data-layout="header"] .acf-field-select select', function () {
    checkHeaderSelectFields();
  });
})(jQuery);
