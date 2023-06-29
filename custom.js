jQuery(document).ready(function($) {
    // Modify the Pagination Block output
    $('.wp-block-query-pagination').each(function() {
        var $pagination = $(this);
        var $nextLink = $pagination.find('.wp-block-query-pagination-next');
        var $prevLink = $pagination.find('.wp-block-query-pagination-previous');
        
        // Remove "Page" text from Next and Previous elements
        $nextLink.text('Next');
        $prevLink.text('Previous');
    });

    var previousButton = $('.wp-block-query-pagination-previous');
    var nextButton = $('.wp-block-query-pagination-next');

    // Create previous button if it doesn't exist
    if (previousButton.length === 0) {
        previousButton = $('<a>').addClass('wp-block-query-pagination-previous').attr('href', '#').text('Previous');
        $('.wp-block-query-pagination').prepend(previousButton);
    }

    // Create next button if it doesn't exist
    if (nextButton.length === 0) {
        nextButton = $('<a>').addClass('wp-block-query-pagination-next').attr('href', '#').text('Next');
        $('.wp-block-query-pagination').append(nextButton);
    }

    // Show both buttons by default
    previousButton.css('display', 'inline-block');
    nextButton.css('display', 'inline-block');

    // Check if there is a previous page
    if (previousButton.attr('href') === '#') {
        previousButton.addClass('hide-button'); // Add the "hide-button" class to hide the previous button
    }

    // Check if there is a next page
    if (nextButton.attr('href') === '#') {
        nextButton.addClass('hide-button'); // Add the "hide-button" class to hide the next button
    }

    $('.pagination-links').each(function() {
      var $pagination = $(this);
      var $nextLink = $pagination.find('.next');
      var $prevLink = $pagination.find('.prev');

      // Remove "Page" text from Next and Previous elements
      $nextLink.text('Next');
      $prevLink.text('Previous');
  });

  var previousButton = $('.pagination-links .prev');
  var nextButton = $('.pagination-links .next');

  // Create previous button if it doesn't exist
  if (previousButton.length === 0) {
      previousButton = $('<a>').addClass('prev').attr('href', '#').text('Previous');
      $('.pagination-links').prepend(previousButton);
  }

  // Create next button if it doesn't exist
  if (nextButton.length === 0) {
      nextButton = $('<a>').addClass('next').attr('href', '#').text('Next');
      $('.pagination-links').append(nextButton);
  }

  // Show both buttons by default
  previousButton.css('display', 'inline-block');
  nextButton.css('display', 'inline-block');

  // Check if there is a previous page
  if (previousButton.attr('href') === '#') {
      previousButton.addClass('hide-button'); // Add the "hide-button" class to hide the previous button
  }

  // Check if there is a next page
  if (nextButton.attr('href') === '#') {
      nextButton.addClass('hide-button'); // Add the "hide-button" class to hide the next button
  }


    $('ul.wp-block-latest-posts__list li').each(function() {
        if (!$(this).find('span.title-arrow').length) {
          $(this).append('<span class="title-arrow"></span>');
        }
      });

      $('p.more-articles').each(function() {
        if (!$(this).find('span.title-arrow').length) {
          $(this).append('<span class="title-arrow"></span>');
        }
      });

      $('ul.wp-block-post-template li').each(function() {
        if (!$(this).find('span.title-arrow').length) {
          $(this).append('<span class="title-arrow"></span>');
        }
      });
      


});
