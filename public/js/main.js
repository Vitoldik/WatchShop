// Смена валюты
$('#currency').on('change',
    ({currentTarget}) => window.location = `currency/change?curr=${$(currentTarget).val()}`)

// Модификация товара
$('.available select').on('change', ({currentTarget}) => {
    const $currentTarget = $(currentTarget)
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
        success: (response) => showCart(response),
        error: () => alert('Error! Try later')
    })
})

const $cart = $('#cart')
const $modalBody = $cart.find('.modal-body')
const $modalFooter = $cart.find('.modal-footer')
const $cartControls = $modalFooter.find('a, .btn-danger')
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
    $simpleCartQuantity.text(`${$cart.find('.cart-qty').text().trim()}x`)
}

$('.cart-link').on('click', (e) => {
    e.preventDefault()

    getCart()
})

function getCart() {
    $.ajax({
        url: '/cart/show',
        type: 'GET',
        success: (response) => showCart(response),
        error: () => alert('Error! Try later')
    })
}

// Удаление товара из модального окна корзины
$modalBody.on('click', '.del-item', ({currentTarget}) => {
    $.ajax({
        url: '/cart/delete',
        data: {
            id: $(currentTarget).data('id')
        },
        type: 'GET',
        success: (response) => showCart(response),
        error: () => alert('Error! Try later')
    })
})

$modalFooter.on('click', '.btn-clear-cart', () => clearCart())

// Полная очистка корзины
function clearCart() {
    $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: (response) => showCart(response),
        error: () => alert('Error! Try later')
    })
}

// Поиск
const $typeahead = $("#typeahead")

const products = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        wildcard: '%QUERY',
        url: `${MAIN_URL}/search/typeahead?query=%QUERY`
    }
})

products.initialize()

$typeahead.typeahead({highlight: true}, {
    name: 'products',
    display: 'title',
    limit: 10,
    source: products
})

$typeahead.bind('typeahead:select', (ev, suggestion) =>
    window.location = `${MAIN_URL}/search/?s=${encodeURIComponent(suggestion.title)}`)

// Фильтры
$preloader = $('.preloader')
$productOne = $('.content .product-one')

$('body').on('change', '.filter-sidebar input', () => {
    const $checked = $('.filter-sidebar input:checked')
    const data = []

    $checked.each(function () {
        data.push(this.value)
    })

    if (data.length) {
        $.ajax({
            url: location.href,
            data: {
                filter: data.join(',')
            },
            type: 'GET',
            beforeSend: () => {
                $preloader.fadeIn(300, () => {
                    $productOne.hide()
                })
            },
            success: (response) => {
                $preloader.delay(500).fadeOut('slow', () => {
                    $productOne.html(response).fadeIn()

                    // Добавляем фильтр в адресную строку
                    const params = location.search

                    const url = params.replace(/filter(.+?)(&|$)/g, '')
                    const newURL = (location.pathname + url + (params ? "&" : "?") + "filter=" + data)
                        .replace('&&', '&')
                        .replace('?&', '?')
                    history.pushState({}, '', newURL)
                })
            },
            error: () => alert('Error!')
        })
    } else {
        window.location = location.pathname
    }
})