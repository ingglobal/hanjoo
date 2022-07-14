<?php
$sub_menu = '915110';
include_once('./_common.php');



$g5['title'] = '대시보드';
include_once ('./_head.php');
// echo G5_USER_ADMIN_JS_URL.'/packery-docs/index.html';
/*
wd(400), wd6, wd8, wd12, wd16
ht(300), ht4, ht5, ht6, ht7, ht8, ht9, ht10, ht11, ht12
*/
?>
<div class="grid">
  <div class="grid-item grid-item-wd6"></div>
  <div class="grid-item grid-item-ht4"></div>
  <div class="grid-item"></div>
  <div class="grid-item"></div>
  <div class="grid-item grid-item-wd8 grid-item-ht5"></div>
  <div class="grid-item grid-item-wd6"></div>
  <div class="grid-item grid-item-wd16"></div>
  <div class="grid-item grid-item-ht7"></div>
  <div class="grid-item"></div>
  <div class="grid-item grid-item-wd8"></div>
  <div class="grid-item grid-item-ht8"></div>
  <div class="grid-item"></div>
  <div class="grid-item"></div>
  <div class="grid-item grid-item-wd6 grid-item-ht4"></div>
  <div class="grid-item"></div>
  <div class="grid-item grid-item-wd6"></div>
  <div class="grid-item grid-item-ht5"></div>
  <div class="grid-item"></div>
</div>

<script>
var $grid = $('.grid').packery({
  itemSelector: '.grid-item',
  // columnWidth helps with drop positioning
  columnWidth: 400
});

// make all items draggable
var $items = $grid.find('.grid-item').draggable();
// bind drag events to Packery
$grid.packery( 'bindUIDraggableEvents', $items );

// show item order after layout
function orderItems() {
  $grid.getItemElements().forEach( function( itemElem, i ) {
    itemElem.textContent = i + 1;
  });
}

$grid.on( 'layoutComplete', orderItems );
$grid.on( 'dragItemPositioned', orderItems );
</script>
<?php
include_once ('./_tail.php');