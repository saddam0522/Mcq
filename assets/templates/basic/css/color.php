<?php
header("Content-Type:text/css");
$color = "#f0f";
$color2 = "#000";
function checkhexcolor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}
if (isset($_GET['color']) and $_GET['color'] != '')
{
    $color = "#" . $_GET['color'];
}
if (!$color or !checkhexcolor($color))
{
    $color = "#f0f";
}
function checkhexcolor2($color2)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color2);
}
if (isset($_GET['color2']) and $_GET['color2'] != '')
{
    $color2 = "#" . $_GET['color2'];
}
if (!$color2 or !checkhexcolor2($color2))
{
    $color2 = "#000";
}






function hexToHsl($hex)
{
    $hex   = str_replace('#', '', $hex);
    $red   = hexdec(substr($hex, 0, 2)) / 255;
    $green = hexdec(substr($hex, 2, 2)) / 255;
    $blue  = hexdec(substr($hex, 4, 2)) / 255;
    $cmin  = min($red, $green, $blue);
    $cmax  = max($red, $green, $blue);
    $delta = $cmax - $cmin;
    if ($delta == 0)
    {
        $hue = 0;
    }
    elseif ($cmax === $red)
    {
        $hue = (($green - $blue) / $delta);
    }
    elseif ($cmax === $green)
    {
        $hue = ($blue - $red) / $delta + 2;
    }
    else
    {
        $hue = ($red - $green) / $delta + 4;
    }
    $hue = round($hue * 60);
    if ($hue < 0)
    {
        $hue += 360;
    }
    $lightness  = (($cmax + $cmin) / 2);
    $saturation = $delta === 0 ? 0 : ($delta / (1 - abs(2 * $lightness - 1)));
    if ($saturation < 0)
    {
        $saturation += 1;
    }
    $lightness  = round($lightness * 100);
    $saturation = round($saturation * 100);
    $hsl['h']   = $hue;
    $hsl['s']   = $saturation;
    $hsl['l']   = $lightness;
    return $hsl;
}
?>

:root{
--base-h: <?php echo hexToHsl($color)['h']; ?>;
--base-s: <?php echo hexToHsl($color)['s']; ?>%;
--base-l: <?php echo hexToHsl($color)['l']; ?>%;
--base-two-h: <?php echo hexToHsl($color2)['h']; ?>;
--base-two-s: <?php echo hexToHsl($color2)['s']; ?>%;
--base-two-l: <?php echo hexToHsl($color2)['l']; ?>%;

--base: var(--base-h) var(--base-s) var(--base-l);
--base-two: <?php echo $color2; ?>;

}



.slider-next, .slider-prev,.process-area::before,.process-area-inner::before,.faq-thumb .faq-video .video-icon,.submit-btn, *::-webkit-scrollbar-button,*::-webkit-scrollbar-thumb,.footer-social li:hover,.header-bottom-area .navbar-collapse .main-menu li .sub-menu li::before,.header-bottom-area .navbar-collapse .main-menu li .sub-menu li:hover a,.blog-social-area .blog-social li:hover,.preloader,.account-form-area::before,.account-form-area::after,.bg--base,.schedule-thumb .schedule-badge, .process-item.left .process-content .title::after, .process-item.right .process-content .title::after, .faq-wrapper .faq-item.open .right-icon::before, .faq-wrapper .faq-item.open .right-icon::after, .blog-content .blog-date .date-icon, ::selection{
background-color:<?php echo $color; ?> !important
}

.text--base,.section-header .section-title,.custom-btn,.statistics-icon,.client-content .client-quote-icon,.call-to-action-form input,.breadcrumb-item a,.breadcrumb-item.active::before,.breadcrumb-item.active,.exam-content .title, .exam-details-section .exam-content .sub-title, .blog-content .blog-content-details .title a:hover,.blog-social-area .title,.blog-social-area .blog-social li,.contact-info-icon i,.account-header .sub-title a,.checkbox-wrapper .checkbox-item label a,.category-content li:hover,.schedule-content .schedule-list li i{
color:<?php echo $color; ?> !important;
}

.footer-social li:hover,.blog-social-area .blog-social li:hover{
color:white !important
}

.section-header .title-border::before, .section-header .title-border::after{
border: 1px solid <?php echo $color; ?> !important;
}

.schedule-thumb .schedule-badge::before{
border-top-color:<?php echo $color; ?>
}



.process-area::before, .process-area::after,.process-item .process-content .title::after,.process-area-inner::before{
border: 6px solid <?php echo $color2; ?> !important;
}


.blog-content .blog-date .date-icon{
border-bottom: 3px solid <?php echo $color . "1a"; ?> !important;
}

.footer-section{
border-top: 3px solid <?php echo $color . "33"; ?> !important;
}


.blog-social-area .blog-social li{
border: 2px solid <?php echo $color . "33"; ?> !important;
}


.page{
border-left: 1px solid <?php echo $color; ?> !important;
background: <?php echo $color; ?> !important;
}

.pagination .page-item.active .page-link, .pagination .page-item:hover .page-link{
background: <?php echo $color; ?> !important;
border-color: <?php echo $color; ?> !important;
}

.pagination .page-item.disabled span{
background: <?php echo $color . "4D"; ?> !important;
border: 1px solid <?php echo $color . "4D"; ?> !important;
}

.action-button,#msform fieldset .radio-wrapper input[type="radio"]:checked + label::after
{
background:<?php echo $color; ?> !important;
}

.subject-item::after{
background-color:<?php echo $color . '4d'; ?>
}

.language .dropdown-menu, .section--bg,.footer-section,.blog-content .blog-date,.contact-info-icon i, .header-bottom-area, .feature-item, .statistics-section, .footer-bottom-area, .bg-overlay-white:before, .account-form-area, .page-container .sidebar-menu{
background-color:<?php echo $color2; ?> !important

}

.bg-overlay-white:before {
opacity: .83;
}

.scrollToTop{
background:<?php echo $color; ?> !important;
}

.custom-table thead tr {
background-color: <?php echo $color; ?> !important;
}