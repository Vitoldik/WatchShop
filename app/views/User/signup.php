<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="<?= MAIN_URL ?>">Home</a></li>
                <li>Register</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12">
                <div class="product-one signup">
                    <div class="register-top heading">
                        <h2>REGISTRATION</h2>
                    </div>
                    <div class="register-main">
                        <div class="col-md-6 account-left register-form-block">
                            <form method="post" action="user/signup" id="signup" role="form" data-toggle="validator">
                                <div class="form-group has-feedback">
                                    <label for="login">Login</label>
                                    <input type="text"
                                           name="login"
                                           class="form-control"
                                           id="login"
                                           placeholder="Login"
                                           data-error="Minimum login length 3 characters"
                                           data-minlength="3"
                                           value="<?=isset($_SESSION['form_data']['login']) ? escapeSpecialChars($_SESSION['form_data']['login']) : ''?>"
                                           required
                                    >
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="pasword">Password</label>
                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                           id="pasword"
                                           placeholder="Password"
                                           data-error="Minimum password length 6 characters"
                                           data-minlength="6"
                                           value="<?=isset($_SESSION['form_data']['password']) ? escapeSpecialChars($_SESSION['form_data']['password']) : ''?>"
                                           required
                                    >
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="name">Name</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           id="name"
                                           placeholder="Name"
                                           value="<?=isset($_SESSION['form_data']['name']) ? escapeSpecialChars($_SESSION['form_data']['name']) : ''?>"
                                           required
                                    >
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="email">Email</label>
                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           id="email"
                                           placeholder="Email"
                                           value="<?=isset($_SESSION['form_data']['email']) ? escapeSpecialChars($_SESSION['form_data']['email']) : ''?>"
                                           required
                                    >
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="address">Address</label>
                                    <input type="text"
                                           name="address"
                                           class="form-control"
                                           id="address"
                                           placeholder="Address"
                                           value="<?=isset($_SESSION['form_data']['address']) ? escapeSpecialChars($_SESSION['form_data']['address']) : ''?>"
                                           required
                                    >
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <button type="submit" class="btn btn-default">Create account</button>
                            </form>
                            <?php
                                if (isset($_SESSION['form_data']))
                                    unset($_SESSION['form_data']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--product-end-->