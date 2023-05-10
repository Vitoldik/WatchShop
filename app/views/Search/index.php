<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="<?=MAIN_URL;?>">Home</a></li>
                <li>Search result: "<?=$cleanedQuery?>"</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="prdt-left">
                <?php if(!empty($products)): ?>
                    <div class="product-one">
                        <?php $curr = \watchShop\App::$app->getProperty('currency'); ?>
                        <?php foreach($products as $product): ?>
                            <?php
                                $price = $product->price * $curr['value'];
                                $oldPrice = $product->old_price ? $product->old_price * $curr['value'] : false;
                            ?>

                            <div class="col-md-3 product-left p-left">
                                <div class="product-main simpleCart_shelfItem">
                                    <a href="product/<?=$product->alias;?>" class="mask"><img class="img-responsive zoom-img" src="images/<?=$product->img;?>" alt="" /></a>
                                    <div class="product-bottom">
                                        <h3><?=$product->title;?></h3>
                                        <p>Explore Now</p>
                                        <h4>
                                            <a data-id="<?=$product->id;?>" class="add-to-cart-link" href="cart/add?id=<?=$product->id;?>"><i></i></a>
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
                    </div>
                <?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--product-end-->