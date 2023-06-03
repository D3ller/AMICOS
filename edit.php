<!DOCTYPE html>
<html>
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <link href='/assets/css/header-footer.css' rel='stylesheet' type='text/css'>
</head>
<body>
  <select id="mySelect">
    <option value="default-pp" data-image="https://portfolio.karibsen.fr/assets/img/default-pp">Avatar rose</option>
    <option value="profil-orange" data-image="https://portfolio.karibsen.fr/assets/img/profil-orange">Avatar orange</option>
  </select>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#mySelect').select2({
        templateResult: function(option) {
          if (!option.id) {
            return option.text;
          }

          var imageUrl = option.element.getAttribute('data-image');
          var optionText = $('<span>' + option.text + '</span>');

          if (imageUrl) {
            var optionImage = $('<img width="50" height="50" style="display: block; margin: 0 auto;" src="' + imageUrl + '">');
            optionText.prepend(optionImage);
          }

          return optionText;
        },
        escapeMarkup: function(markup) {
          return markup;
        }
      });
    });
  </script>
</body>
</html>
