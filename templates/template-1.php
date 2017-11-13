<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Photoswipe Template</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.2/photoswipe.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.2/default-skin/default-skin.min.css">

  <!-- Custom Styles -->
  <style>
    /*gallery lightbox */
    .gallery {
      width: 100%;
      float: left;
    }
    .gallery img {
      width: 100%;
      height: auto;
    }
    .gallery .gallery-item {
      display: block;
      float: left;
      margin: 0 5px 5px 0;
      width: 150px;
    }
    .gallery .caption {
      display: none;
    }

    div.photoSwipe_innerthumbs{position: fixed; bottom: 0; width: 100%; text-align: center;z-index: 1000000;}
    div.ps-thumb{max-width: 5em; display: inline-block; background: #00527c; margin: 0 0.2em;}
    div.photoSwipe_innerthumbs img{cursor: pointer;}
    .svifaded{opacity: 0.5;}
    .pswp__item {
      bottom: 6em;
    }
    .pswp--zoomed-in .pswp__item {
      bottom: 0;
    }
  </style>



</head>
<body>
  <div class="container">

    <p>This template works only when a single gallery needed on the page</p>

    <?php if ($gallery = get_field('gallery')): ?>
      <div class="block-gallery">
        <div class="row">

          <!-- LOOP -->
          <?php foreach ($gallery as $i => $im): ?>

            <?php $full  = $im['sizes']['hd'] ?>
            <?php $w     = $im['width'] ?>
            <?php $h     = $im['height'] ?>
            <?php $small = $im['sizes']['small'] ?>
            <?php $index = $i ?>


            <?php $src = $im['sizes']['large'] ?>
            <?php $alt = $im['alt'] ?>

            <div class="col-6">
              <div class="bp">
                <a href="<?php echo $full ?>" class="gallery-item" 
                data-imgw="<?php echo $w ?>" 
                data-imgh="<?php echo $h ?>" 
                data-imgthumb="<?php echo $small ?>" 
                data-index="<?php echo $index ?>">
                  <img src="<?php echo $src ?>" alt="<?php echo $alt ?>" title="">
                </a>
              </div>
            </div>

          <?php endforeach ?>
          <!-- END LOOP -->

        </div>
      </div>

      <?php get_template_part('parts/photoswipe') ?>

    <?php endif ?>

  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.2/photoswipe.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.2/photoswipe-ui-default.min.js"></script>

  <!-- Custom JS -->
  <script>
    var pswpElement = document.querySelectorAll('.pswp')[0];

    $('.gallery-item').click(function (e) {

      e.preventDefault();

      $('body').append('<div class="photoSwipe_innerthumbs"></div>');

      var svi_items = [];
      var thumbs = '';

      $('.gallery-item').each(function (i, v) {    // build items array


      svi_items.push({
        src: $(v).attr('href'),
        w: $(v).data('imgw'),
        h: $(v).data('imgh'),
        msrc: $(v).data('imgthumb'),
        index: $(v).data('index')
      });

      //generate thumbnail markup..
      thumbs += '<div class="bp ps-thumb"><img src="'+ $(v).data('imgthumb') +'" alt=""></div>';


      });

      // define options (if needed)
      var options = {
      index: $(this).data('index') // start on clicked slide..
      };

      // Initializes and opens PhotoSwipe
      gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, svi_items, options);

      gallery.init();

      // Gallery starts closing
      gallery.listen('close', function () {
      $('.photoSwipe_innerthumbs').remove();
      });

      gallery.listen('beforeChange', function(z) {
      $('div.photoSwipe_innerthumbs img').removeClass("svifaded");
      $("div.photoSwipe_innerthumbs img").eq(gallery.getCurrentIndex()).addClass('svifaded');
      });

      //Clone and append the thumbnail images
      $(thumbs).appendTo("div.photoSwipe_innerthumbs");

      //Get current active index and add class to thumb just to fade a bit
      $("div.photoSwipe_innerthumbs img").eq(gallery.getCurrentIndex()).addClass('svifaded');

      //Handle the swaping of images
      $('div.photoSwipe_innerthumbs img').click(function (e) {

      $('div.photoSwipe_innerthumbs img').removeClass("svifaded");
      $(this).addClass('svifaded');
      gallery.goTo($("div.photoSwipe_innerthumbs img").index($(this)));
      });

    });
  </script>
</body>
</html>