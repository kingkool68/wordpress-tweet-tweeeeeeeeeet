<?php
/*
IDEA: Animated Fail Whale in CSS: http://www.subcide.com/experiments/fail-whale/
IDEA: Animated Fail Whale as a SVG: http://priyanka-herur.github.io/svgfailwhale/
IDEA: Animate floating right to left infinitely. See http://www.bryanbraun.com/2014/03/15/how-i-rebuilt-flying-toasters-using-only-css-animations maybe?
*/

function fail_whale_404_css() {
?>
<style>
body {
	background-color: #77cdd3;
}
h1 {
	font-size: 36px;
	color: #F45522;
	font-weight: 700;
	padding-top: 15px;
}
.escape-hatch {
	color: #fff;
	padding-top: 7px;
	display: block;
}
h1,
.escape-hatch {
	padding-left: 15px;
}
.fail-whale-credit {
	text-align: right;
	padding-right: 15px;
	padding-top: 12px;
	font-size: 11px;
}
.fail-whale-credit,
.fail-whale-credit a {
	color: #666;
}


.twitterWhale  {
	width: 100%;
	height: 100%;
}
.twitterWhale  .whale {
	-webkit-animation-name: whalean;
	-webkit-animation-duration: 1.5s;
	-webkit-animation-iteration-count: infinite;
	-webkit-animation-timing-function: ease-in-out;
	-webkit-animation-delay: -1.5s;
	-webkit-animation-direction: alternate;
	-webkit-transform-origin: 50%;

	animation-name: whalean;
	animation-duration: 3s;
	animation-iteration-count: infinite;
	animation-timing-function: ease-in-out;
	animation-delay: -1.5s;
	animation-direction: alternate;
	transform-origin: 50%;

/*        -moz-animation: none;*/
}

@-webkit-keyframes whalean {
	0% { -webkit-transform: translateY(8px); }
	100% { -webkit-transform: translateY(-8px); }
}

@keyframes whalean {
	0% { transform: translateY(8px);  }
	100% { transform: translateY(-8px); }
}

/*        Animated back wave*/
.twitterWhale  .waves .backwave {
	-webkit-animation-name: backwavean;
	-webkit-animation-duration: 1.5s;
	-webkit-animation-iteration-count: infinite;
	-webkit-animation-timing-function: ease-in-out;
	-webkit-animation-direction: alternate;
	-webkit-transform-origin: 50%;

	animation-name: backwavean;
	animation-duration: 3s;
	animation-iteration-count: infinite;
	animation-timing-function: ease-in-out;
	animation-delay: -1.5s;
	animation-direction: alternate;
	transform-origin: 50%;

/*        -moz-animation: none;*/
}

@-webkit-keyframes backwavean {
	0% { -webkit-transform: translateX(-20px); }
	100% { -webkit-transform: translateX(20px); }
}

@keyframes backwavean {
	0% { transform: translateX(-20px);  }
	100% { transform: translateX(20px); }
}


/*        Front wave going up and down*/
.twitterWhale  .waves .forewave {
	-webkit-animation-name: frontwavean;
	-webkit-animation-duration: 1.5s;
	-webkit-animation-iteration-count: infinite;
	-webkit-animation-timing-function: ease-in-out;
	-webkit-animation-delay: -1.5s;
	-webkit-animation-direction: alternate;
	-webkit-transform-origin: 50%;

	animation-name: frontwavean;
	animation-duration: 3s;
	animation-iteration-count: infinite;
	animation-timing-function: ease-in-out;
	animation-delay: -1.5s;
	animation-direction: alternate;
	transform-origin: 50%;

/*        -moz-animation: none;*/
}

@-webkit-keyframes frontwavean {
	0% { -webkit-transform: translateY(-3px); }
	100% { -webkit-transform: translateY(3px); }
}

@keyframes frontwavean {
	0% { transform: translateY(-3px);  }
	100% { transform: translateY(3px); }
}

/*        Bird left wing animation*/
.twitterWhale  .whale .left_wing{
	-webkit-animation-name: flapleft;
	-webkit-animation-duration: 0.05s;
	-webkit-animation-iteration-count: infinite;
	-webkit-animation-timing-function: ease-in-out;
	-webkit-animation-direction: alternate;
	-webkit-transform-origin: 50%;

	animation-name: flapleft;
	animation-duration: .1s;
	animation-iteration-count: infinite;
	animation-timing-function: ease-in-out;
	animation-delay: -1.5s;
	animation-direction: alternate;
	transform-origin: 50%;

/*        -moz-animation: none;*/
}

@-webkit-keyframes flapleft {
	0% { -webkit-transform:translate(-1px,1px); }
	100% { -webkit-transform: translate(-3px,5px);  }
}

@keyframes flapleft {
	0% { transform: translate(-1px,1px); }
	100% { transform: translate(-3px,5px);}
}

	/*        Bird right wing animation*/
.twitterWhale  .whale .right_wing,
.twitterWhale  .whale .right_wing_tilted {
	-webkit-animation-name: flapright;
	-webkit-animation-duration: 0.05s;
	-webkit-animation-iteration-count: infinite;
	-webkit-animation-timing-function: ease-in-out;
	-webkit-animation-direction: alternate;
	-webkit-transform-origin: 50%;

	animation-name: flapright;
	animation-duration: .1s;
	animation-iteration-count: infinite;
	animation-timing-function: ease-in-out;
	animation-delay: -1.5s;
	animation-direction: alternate;
	transform-origin: 50%;

/*        -moz-animation: none;*/
}

@-webkit-keyframes flapright {
	0% { -webkit-transform:translate(3px,1px);}
	100% { -webkit-transform: translate(0px,5px) ; }
}

@keyframes flapright {
	0% { transform: translate(3px,1px); }
	100% { transform: translate(0px,5px); }
}
</style>
<?php
}
add_action( 'wp_head', 'fail_whale_404_css' );
?>

<?php get_header(); ?>
	<h1>Fail Whale!</h1>
	<a href="<?php echo esc_url( get_site_url() ); ?>" class="escape-hatch">Go Home <span aria-hidden="true">→</span></a>
	<?php
	$path = get_template_directory() . '/icons/' . 'fail-whale.svg';
	$args = array(
		'css_class' => 'twitterWhale',
	);
	echo tweet_theme_get_svg( $path, $args );
	?>
	<p class="fail-whale-credit">Credit: <a href="https://github.com/priyanka-herur/svgfailwhale">Priyanka Herur</a></p>
<?php get_footer();
