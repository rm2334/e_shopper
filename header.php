<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package e-shopper
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> <?php e_shopper_html_tag_schema(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>Home | E-Shopper</title>

    <!-- Favicon -->
    <?php $favicon = themes_option('custom_favicon', false, 'url'); ?>
    <?php if ($favicon !== '') { ?>
    <link rel="icon" type="image/png" href="<?php echo themes_option('custom_favicon', false, 'url'); ?>" />
    <?php } ?>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <?php $contact_phone = themes_option('contact_phone'); ?><?php if ($contact_phone !== '') { ?><li><a href="#"><i class="fa fa-phone"></i> <?php foreach ($contact_phone as $key => $contact_value) { ?><?php echo $contact_value; ?> <?php } ?></a></li><?php } ?>
                                
                                <?php $contact_email = themes_option('contact_email'); ?><?php if ($contact_email !== '') { ?><li><a href="#"><i class="fa fa-envelope"></i> <?php echo themes_option('contact_email'); ?></a></li><?php } ?>
                            
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <?php $social_facebook = themes_option('social_facebook'); ?><?php if ($social_facebook !== '') { ?><li><a href="<?php echo themes_option('social_facebook'); ?>"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                
                                <?php $social_twitter = themes_option('social_twitter'); ?><?php if ($social_twitter !== '') { ?><li><a href="<?php echo themes_option('social_twitter'); ?>"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                
                                <?php $social_linkedin = themes_option('social_linkedin'); ?><?php if ($social_linkedin !== '') { ?><li><a href="<?php echo themes_option('social_linkedin'); ?>"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                
                                <?php $social_dribbble = themes_option('social_dribbble'); ?><?php if ($social_dribbble !== '') { ?><li><a href="<?php echo themes_option('social_dribbble'); ?>"><i class="fa fa-dribbble"></i></a></li><?php } ?>
                                
                                <?php $social_gplus = themes_option('social_gplus'); ?><?php if ($social_gplus !== '') { ?><li><a href="<?php echo themes_option('social_gplus'); ?>"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                            
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->
        
        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="<?php bloginfo('url'); ?>"><img src="<?php $custom_logo = themes_option('custom_logo', false, 'url' ); ?><?php if ($custom_logo !== '') { ?><?php echo themes_option('custom_logo', false, 'url' ); ?><?php } else { ?><?php bloginfo('template_directory'); ?>/images/home/logo.png<?php } ?>" alt="<?php bloginfo('name'); ?>" /></a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <?php global $woocommerce; ?>
                            <ul class="nav navbar-nav">
                                
                                <?php if ( is_user_logged_in() ) { ?><?php $account_page = themes_option('account_page'); ?><?php if ($account_page !== '') { ?><li><a href="<?php bloginfo('url'); ?>/?page_id=<?php echo themes_option('account_page'); ?>"><i class="fa fa-user"></i>My Account</a></li><?php } ?>
                                <?php } else { ?><?php $login_page = themes_option('login_page'); ?><?php if ($login_page !== '') { ?><li><a href="<?php bloginfo('url'); ?>/?page_id=<?php echo themes_option('login_page'); ?>"><i class="fa fa-lock"></i> Login</a></li><?php } ?>
                                <?php } ?>
                                
                                <?php $wishlist_page = themes_option('wishlist_page'); ?><?php if ($wishlist_page !== '') { ?><li><a href="<?php bloginfo('url'); ?>/?page_id=<?php echo themes_option('wishlist_page'); ?>"><i class="fa fa-star"></i> Wishlist</a></li><?php } ?>
                                
                                <?php $checkout_page = themes_option('checkout_page'); ?><?php if ($checkout_page !== '') { ?><li><a href="<?php bloginfo('url'); ?>/?page_id=<?php echo themes_option('checkout_page'); ?>"><i class="fa fa-crosshairs"></i> Checkout</a></li><?php } ?>
                                
                                <li class="cart-item"><?php echo woocommerce_cart_link(); ?></li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->
    
        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="index.html" class="active">Home</a></li>
                                <li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="shop.html">Products</a></li>
                                        <li><a href="product-details.html">Product Details</a></li> 
                                        <li><a href="checkout.html">Checkout</a></li> 
                                        <li><a href="cart.html">Cart</a></li> 
                                        <li><a href="login.html">Login</a></li> 
                                    </ul>
                                </li> 
                                <li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="blog.html">Blog List</a></li>
                                        <li><a href="blog-single.html">Blog Single</a></li>
                                    </ul>
                                </li> 
                                <li><a href="404.html">404</a></li>
                                <li><a href="contact-us.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="search_box pull-right">
                            <input type="text" placeholder="Search"/>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->