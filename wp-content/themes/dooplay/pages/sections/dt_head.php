<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php wp_title('-', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() .'/assets/css/front.signup.css'; ?>">
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js?ver=2.2.0'></script>
	<?php if(cs_get_option('gcaptchasitekey') && cs_get_option('gcaptchasecret')){ echo "<script src='https://www.google.com/recaptcha/api.js'></script>"; } ?>
	<script type="text/javascript">
        $.fn.passwordStrength=function(t){return this.each(function(){var s=this;s.opts={},s.opts=$.extend({},$.fn.passwordStrength.defaults,t),s.div=$(s.opts.targetDiv),s.defaultClass=s.div.attr("class"),s.percents=s.opts.classes.length?100/s.opts.classes.length:100,v=$(this).keyup(function(){"undefined"==typeof el&&(this.el=$(this));var s=function(s){var t=s.length;5<t&&(t=5);var e=s.replace(/[0-9]/g,""),a=s.length-e.length;3<a&&(a=3);var r=s.replace(/\W/g,""),n=s.length-r.length;3<n&&(n=3);var i=s.replace(/[A-Z]/g,""),l=s.length-i.length;3<l&&(l=3);var h=10*t-20+10*a+15*n+10*l;h<0&&(h=0);100<h&&(h=100);return h}(this.value),t=this.percents,e=Math.floor(s/t);100<=s&&(e=this.opts.classes.length-1),this.div.removeAttr("class").addClass(this.defaultClass).addClass(this.opts.classes[e])}).next().click(function(){return $(this).prev().val(function(){var s="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$_+",t=1,e="";for(;t<=10;)$max=s.length-1,$num=Math.floor(Math.random()*$max),$temp=s.substr($num,1),e+=$temp,t++;return e}()).trigger("keyup"),!1})})},$.fn.passwordStrength.defaults={classes:Array("is10","is20","is30","is40","is50","is60","is70","is80","is90","is100"),targetDiv:"#passwordStrengthDiv",cache:{}},$(document).ready(function(){$('input[name="spassword"]').passwordStrength(),$('input[name="spassword"]').passwordStrength({targetDiv:"#passwordStrengthDiv",classes:Array("is10","is20","is30","is40","is50","is60","is70","is80","is90","is100")})});
	</script>
<?php
	$color1 = cs_get_option('maincolor','#408BEA');
	$color2 = cs_get_option('bgcolor','#F5F7FA');
	$logo = doo_compose_image_option('headlogo');
	$home = esc_url(home_url());
	$bnme = get_option('blogname');
?>
<style>
    body{background:<?php echo $color2; ?>}
    a{color: <?php echo $color1; ?>}
    .form_dt_user fieldset input[type="submit"]{background:<?php echo $color1; ?>}
    .text_ft{color: #fff;}
</style>

</head>
<body>
<div class="container">
	<div class="dt_box <?php if( isset($_GET['action']) && $_GET['action'] == 'log-in') echo "login"; ?>">
	<div class="logo">
		<?php echo ($logo) ? "<a href='{$home}'><img src='{$logo}'></a>" : "<h1>{$bnme}</h1>"; ?>
	</div>
