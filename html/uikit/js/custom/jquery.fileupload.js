(function ($) {
  $.extend({
    uploadPreview : function (options) {

      // Options + Defaults
      var settings = $.extend({
        input_field: ".image-input",
        preview_box: ".image-preview",
        label_field: ".image-label",
        label_default: "Choose File",
        label_selected: "Change File",
        no_label: false
      }, options);

      // Check if FileReader is available
      if (window.File && window.FileList && window.FileReader) {
        if (typeof($(settings.input_field)) !== 'undefined' && $(settings.input_field) !== null) {
          $(settings.input_field).change(function() {
            var files = event.target.files;

            var $preview_box = $(event.target).closest(settings.preview_box);
            var $label_field = $preview_box.find(settings.label_field);
            console.log($label_field)

            if (files.length > 0) {
              var file = files[0];
              var reader = new FileReader();

              // Load file
              reader.addEventListener("load",function(event) {
                var loadedFile = event.target;

                // Check format
                if (file.type.match('image')) {
                  // Image
                  $preview_box.css("background-image", "url("+loadedFile.result+")");
                  $preview_box.css("background-size", "cover");
                  $preview_box.css("background-position", "center center");
                } else if (file.type.match('audio')) {
                  // Audio
                  $preview_box.html("<audio controls><source src='" + loadedFile.result + "' type='" + file.type + "' />Your browser does not support the audio element.</audio>");
                } else {
                  alert("This file type is not supported yet.");
                }
              });

              if (settings.no_label == false) {
                // Change label
                $label_field .html(settings.label_selected);
              }

              // Read the file
              reader.readAsDataURL(file);
            } else {
              if (settings.no_label == false) {
                // Change label
                $label_field .html(settings.label_default);
              }

              // Clear background
              $preview_box.css("background-image", "none");

              // Remove Audio
              $preview_box.find(audio).remove();
              //$(settings.preview_box + " audio").remove();
            }
          });
        }
      } else {
        alert("You need a browser with file reader support, to use this form properly.");
        return false;
      }
    }
  });
})(jQuery);