{strip}
<script>
    (function() {
        var prev_size = window.innerWidth;
        let wrapper = document.getElementById('scroll_list_{$block.block_id}');

        if (wrapper !== null) {
            var is_hidden = (el) => {
                el.offsetParent === null
            };

            let elems = wrapper.getElementsByClassName('ut2-gl__item');
            window.onresize = function () {
                if (is_hidden(wrapper) || prev_size === window.innerWidth) {
                    return;
                }

                prev_size = window.innerWidth;
                let items_in_row = 0;

                let item = {$block.properties.item_quantity|default:5};
                    /* default setting of carousel */
                let itemsDesktop = 5;
                let itemsDesktopSmall = 4;
                let itemsTablet = 4;
                let itemsTabletSmall = 2;
                let itemsMobile = 1;

                if (item > 3) {
                    itemsDesktop = item;
                    itemsDesktopSmall = item - 1;
                    itemsTablet = item - 2;
                } else if (item === 1) {
                    itemsDesktop = itemsDesktopSmall = itemsTablet = 1;
                } else {
                    itemsDesktop = item;
                    itemsDesktopSmall = itemsTablet = item - 1;
                }

                if (window.innerWidth > 1199) {
                    items_in_row = itemsDesktop;
                } else if (window.innerWidth > 1023) {
                    items_in_row = itemsDesktopSmall;
                } else if (window.innerWidth > 767) {
                    items_in_row = itemsTablet;
                } else if (window.innerWidth > 479) {
                    items_in_row = itemsTabletSmall;
                } else {
                    items_in_row = itemsMobile;
                }

                let width = wrapper.offsetWidth / Number(items_in_row + '.35');

                Array.prototype.forEach.call(elems, item => {
                    item.style.width = Math.ceil(width) + 'px';
                });
            };
        }
    }());
</script>
{/strip}