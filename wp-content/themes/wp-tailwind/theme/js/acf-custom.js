(function ($) {
  // Function to disable already selected options in other flexible layouts
  function updateHeaderOptions() {
    let selectedValues = [];

    // Loop through all header layout select fields with data-name="usage"
    $('.acf-field[data-name="usage"] select').each(function () {
      let selectedValue = $(this).val();

      if (selectedValue === 'homepage' || selectedValue === 'inner_pages') {
        selectedValues.push(selectedValue);
      }
    });

    // Loop through all header layout select fields again and disable the options
    $('.acf-field[data-name="usage"] select').each(function () {
      let $select = $(this);
      let currentValue = $select.val();

      // Enable all options first
      $select.find('option').prop('disabled', false);

      // Disable options that are already selected in other layouts
      selectedValues.forEach(function (value) {
        if (value !== currentValue) {
          $select.find('option[value="' + value + '"]').prop('disabled', true);
        }
      });
    });
  }

  // Trigger update on page load and when a header option changes
  $(document).on('acf/input/change', '.acf-field[data-name="usage"] select', updateHeaderOptions);
  $(document).ready(updateHeaderOptions);

})(jQuery);
