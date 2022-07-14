<?php
$sub_menu = '915110';
include_once('./_common.php');

$rn_num = get_random_integer(0,14);
// print_r3($rn_num);
$g5['title'] = '대시보드1';
include_once ('./_head.php');
?>
<div class="grid">
  <div class="grid-sizer"></div>
  <div class="grid-item grid-item--large" data-item-id="1"
    style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/orange-tree.jpg);"></div>
  <div class="grid-item" data-item-id="2"
    style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/submerged.jpg);"></div>
  <div class="grid-item" data-item-id="3"
    style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/look-out.jpg);"></div>
  <div class="grid-item grid-item--width2" data-item-id="4"
    style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/one-world-trade.jpg);"></div>
  <div class="grid-item" data-item-id="5"
    style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/drizzle.jpg);"></div>
  <div class="grid-item grid-item--width2" data-item-id="6"
    style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/golden-hour.jpg);"></div>
  <div class="grid-item" data-item-id="7"
    style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/cat-nose.jpg);"></div>
  <div class="grid-item" data-item-id="8"
    style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/contrail.jpg);"></div>
  <div class="grid-item" data-item-id="9"
    style="background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/flight-formation.jpg);"></div>
</div>
<script>
 // get JSON-friendly data for items positions
Packery.prototype.getShiftPositions = function( attrName ) {
  attrName = attrName || 'id';
  var _this = this;
  return this.items.map( function( item ) {
    return {
      attr: item.element.getAttribute( attrName ),
      x: item.rect.x / _this.packer.width
    }
  });
};

Packery.prototype.initShiftLayout = function( positions, attr ) {
  if ( !positions ) {
    // if no initial positions, run packery layout
    this.layout();
    return;
  }
  // parse string to JSON
  if ( typeof positions == 'string' ) {
    try {
      positions = JSON.parse( positions );
    } catch( error ) {
      console.error( 'JSON parse error: ' + error );
      this.layout();
      return;
    }
  }
  
  attr = attr || 'id'; // default to id attribute
  this._resetLayout();
  // set item order and horizontal position from saved positions
  this.items = positions.map( function( itemPosition ) {
    var selector = '[' + attr + '="' + itemPosition.attr  + '"]'
    var itemElem = this.element.querySelector( selector );
    var item = this.getItem( itemElem );
    item.rect.x = itemPosition.x * this.packer.width;
    return item;
  }, this );
  this.shiftLayout();
};

// -----------------------------//

// init Packery
var $grid = $('.grid').packery({
  itemSelector: '.grid-item',
  columnWidth: '.grid-sizer',
  percentPosition: true,
  initLayout: false // disable initial layout
});

// get saved dragged positions
var initPositions = localStorage.getItem('dragPositions');
// init layout with saved positions
$grid.packery( 'initShiftLayout', initPositions, 'data-item-id' );

// make draggable
$grid.find('.grid-item').each( function( i, itemElem ) {
  var draggie = new Draggabilly( itemElem );
  $grid.packery( 'bindDraggabillyEvents', draggie );
});

// save drag positions on event
$grid.on( 'dragItemPositioned', function() {
  // save drag positions
  var positions = $grid.packery( 'getShiftPositions', 'data-item-id' );
  localStorage.setItem( 'dragPositions', JSON.stringify( positions ) );
});   
</script>
<?php
include_once ('./_tail.php');