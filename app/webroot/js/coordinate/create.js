$(document).ready(function () {
    $(".item_image").fadeIn(700);

    $('.photo').hover(
        function () {
            $(this).find('.item_image').fadeTo('fast', 0.5);
            $(this).find('.pick_button').show('fast');
        },
        function () {
            $(this).find('.item_image').fadeTo('fast', 1.0);
            $(this).find('.pick_button').hide('fast');
        }
    );

    function drawItemInPickedItemsArea(itemId, photoPath, price) {
        $('.picked_items').append(
            "<div class='picked_item' data-item-id='" + itemId + "'>" +
            "<img class='picked_item_img' data-item-id='" + itemId + "' src='/img/" + photoPath + "'>" +
            "<a class='delete_picked_button' data-item-id='" + itemId + "'><img src='/img/view/delete.png'></a>" +
            "<div class='picked_item_price'>¥" + price + "</div>" +
            "</div>"
        );
    }

    const STORAGE_KEY = 'items';
    const ITEM_KEY_PREFIX = 'item_';

    function addItemIdToSessionStorage(itemId, photoPath, price, name) {
        var storage = localStorage;
        var items = JSON.parse(storage.getItem(STORAGE_KEY));

        // TODO : 真面目にバリデーションする
        if (items == null) {
            items = {};
        }
        if (items[ITEM_KEY_PREFIX + itemId] == undefined) {
            items[ITEM_KEY_PREFIX + itemId] = {
                'itemId': itemId,
                'photoPath': photoPath,
                'price': price,
                'name': name
            };
            storage.setItem(STORAGE_KEY, JSON.stringify(items));
            return true;
        }
        return false;
    }

    function deleteItemIdFromSessionStorage(itemId) {
        var storage = localStorage;
        var items = JSON.parse(storage.getItem(STORAGE_KEY));

        // TODO : 真面目にバリデーションする
        if (items == null) {
            items = {};
        }
        if (items[ITEM_KEY_PREFIX + itemId] != undefined) {
            delete items[ITEM_KEY_PREFIX + itemId];
            storage.setItem(STORAGE_KEY, JSON.stringify(items));
            return true;
        }
        return false;
    }

    function drawAllItems() {
        var storage = localStorage;
        var items = JSON.parse(storage.getItem(STORAGE_KEY));

        // TODO : 真面目にバリデーションする
        if (items == null) {
            items = {};
        }
        for (var key in items) {
            drawItemInPickedItemsArea(items[key]['itemId'], items[key]['photoPath'], items[key]['price']);
        }
    }

    $(document).on('click', '.delete_picked_button', function () {
        var itemId = $(this).data('item-id');
        deleteItemIdFromSessionStorage(itemId);
        $('.picked_items [data-item-id=' + itemId + ']').fadeOut('fast');
    });

    $('.pick_button').click(function () {
        var itemId = $(this).data('item-id');
        var photoPath = $(this).data('item-photo-path');
        var price = $(this).data('item-price');
        var name = $(this).data('item-name');
        var result = addItemIdToSessionStorage(itemId, photoPath, price, name);
        if (result) {
            drawItemInPickedItemsArea(itemId, photoPath, price);
        }
    });

    drawAllItems();
});
