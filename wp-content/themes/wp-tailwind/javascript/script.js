/**
 * Front-end JavaScript
 *
 * The JavaScript code you place here will be processed by esbuild. The output
 * file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */
(function ($) {
  // Function to disable already selected options in other flexible layouts
  function updateHeaderOptions() {
    let selectedValues = [];

    // Loop through all header layout select fields
    $('.acf-field[data-name="usage"] select').each(function () {
      let selectedValue = $(this).val();

      if (selectedValue === 'front' || selectedValue === 'inner') {
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
