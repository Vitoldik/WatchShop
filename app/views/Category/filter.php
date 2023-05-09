<?php if (!empty($products)): ?>
    <?php $curr = \watchShop\App::$app->getProperty('currency'); ?>
    <?php foreach ($products as $product): ?>
        <?php
        $price = $product->price * $curr['value'];
        $oldPrice = $product->old_price ? $product->old_price * $curr['value'] : false;
        ?>

        <div class="col-md-4 product-left p-left">
            <div class="product-main simpleCart_shelfItem">
                <a href="product/<?= $product->alias; ?>" class="mask"><img class="img-responsive zoom-img" src="images/<?= $product->img; ?>" alt=""/></a>
                <div class="product-bottom">
                    <h3><?= $product->title; ?></h3>
                    <p>Explore Now</p>
                    <h4>
                        <a data-id="<?= $product->id; ?>" class="add-to-cart-link" href="cart/add?id=<?= $product->id; ?>"><i></i></a>
                        <span class=" item_price"><?= $curr['symbol_left'] ?><?= $price ?><?= $curr['symbol_right'] ?></span>
                        <?php if ($oldPrice): ?>
                            <small>
                                <del><?= $curr['symbol_left'] ?><?= $oldPrice ?><?= $curr['symbol_right'] ?></del>
                            </small>
                        <?php endif; ?>
                    </h4>
                </div>
                <?php if ($oldPrice): ?>
                    <div class="srch">
                        <span>
                            <?= round(($price / $oldPrice - 1) * 100, 2) ?>%
                        </span>
                    </div>
                <?php endif ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <?php if ($pagination->countPages > 1): ?>
        <div class="text-center">
            <p><?= count($products) ?> item(s) from <?= $totalPages ?></p>
            <?= $pagination ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <h3>No products found :(</h3>
<?php endif; ?>