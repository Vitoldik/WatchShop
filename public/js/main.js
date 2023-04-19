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