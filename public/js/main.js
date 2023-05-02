// Смена валюты
$('#currency').on('change', ({currentTarget}) => {
    window.location = `currency/change?curr=${$(currentTarget).val()}`
})

// Модификация товара
$('.available select').on('change', ({currentTarget}) => {
    const $currentTarget = $(currentTarget);
    //const id = $currentTarget.val()
    const {/*title, */price} = $currentTarget.find('option').filter(':selected').data()
    const $basePrice = $('#base-price')
    const basePrice = $basePrice.data('base_price')
    const $oldPrice = $('.simpleCart_shelfItem #old-price')

    $oldPrice.toggle(!price)
    $basePrice.text(SYMBOL_LEFT + (price ? price : basePrice) + SYMBOL_RIGHT)
})

// Корзина
$('body').on('click', '.add-to-cart-link', (e) => {
    e.preventDefault()

    const {id} = $(e.currentTarget).data()

    const quantity = $('.quantity input').val() ?? 1
    const modification = $('.available select').val()

    $.ajax({
        url: '/cart/add',
        data: {
            id: id,
            quantity: quantity,
            modification: modification
        },
        type: 'GET',
        success: (response) => {
            showCart(response)
        },
        error: () => {
            alert('Error! Try later')
        }
    })
})

const $cart = $('#cart')
const $modalBody = $cart.find('.modal-body')
const $cartControls = $cart.find('.modal-footer a, .modal-footer .btn-danger')
const $cartInfoContainer = $('.cart .simpleCart_info_container')
const $simpleCartTotal = $cartInfoContainer.find('.simpleCart_total')
const $simpleCartQuantity = $cartInfoContainer.find('.simpleCart_quantity')

function showCart(cart) {
    $modalBody.html(cart)
    const isCartEmpty = $.trim(cart) === '<h3>Корзина пуста</h3>'
    $cartControls.toggle(!isCartEmpty)
    $cart.modal()

    if (isCartEmpty) {
        $simpleCartTotal.text('Empty Cart')
        $simpleCartQuantity.empty()
        return
    }

    $simpleCartTotal.text($cart.find('.cart-sum').text())
    $simpleCartQuantity.text(`${$cart.find('.cart-qty').text()}x`)
}

$('.cart-link').on('click', (e) => {
    e.preventDefault()

    getCart()
})

function getCart() {
    $.ajax({
        url: '/cart/show',
        type: 'GET',
        success: (response) => {
            showCart(response)
        },
        error: () => {
            alert('Error! Try later')
        }
    })
}

$modalBody.on('click', '.del-item', ({currentTarget}) => {
    $.ajax({
        url: '/cart/delete',
        data: {
            id: $(currentTarget).data('id')
        },
        type: 'GET',
        success: (response) => {
            showCart(response)
        },
        error: () => {
            alert('Error! Try later')
        }
    })
})