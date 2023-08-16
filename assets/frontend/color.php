<?php
header("Content-Type: text/css");

    $primaryColor = getValidColor($_GET['primary_color'] ?? '#7F56D9');
    $secondaryColor = getValidColor($_GET['secondary_color'] ?? '#ff8');

    function getValidColor($color): bool|string
    {
        $color = '#' . ltrim($color, '#'); // Ensure that the color has a leading hash
        return preg_match('/^#[a-f0-9]{6}$/i', $color) ? $color : false; // Check if the color is valid, otherwise return false
    }

    if (!$primaryColor) {
        $primaryColor = '#0219c8'; // Use default color if primary color is not valid
    }

    if (!$secondaryColor) {
        $secondaryColor = '#f00146'; // Use default color if secondary color is not valid
    }
?>

    .btn--primary::after, .btn--primary, .btn--primary-outline:hover::after, .btn--primary-outline::after, .get-start-bg, .ribbon span, .pricing-feature > span, .custiom-accordion .accordion-button:not(.collapsed), .custiom-accordion .accordion-button:not(.collapsed)::after{
        background: linear-gradient(-75deg, <?php echo $primaryColor ?> 31%, <?php echo $secondaryColor ?> 98%);
    }

    .feature-icon, .btn--primary-outline, .banner-action-item, .icon-avaters, .banner-action-item:hover, .nav-menu-item a:is(.menu-item-active), .btn--white, .btn--white-outline:hover{
        color: <?php echo $primaryColor ?>;
    }

    .pricing-feature{
        color: <?php echo $secondaryColor ?>;
    }

    .icon-avaters, .btn--primary-outline{
        border: 1px solid <?php echo $primaryColor ?>;
    }

    .ribbon span, .pricing-feature > span, .custiom-accordion .accordion-button:not(.collapsed),.custiom-accordion .accordion-button:not(.collapsed)::after{
        background: <?php echo $primaryColor ?>;
    }

    .ribbon span::before, .ribbon span::after {
        border-left: 3px solid <?php echo $primaryColor ?>;
        border-top: 3px solid <?php echo $primaryColor ?>;
    }

    .ribbon span::before, .ribbon span::after {
        border-right: 3px solid <?php echo $primaryColor ?>;
        border-top: 3px solid <?php echo $primaryColor ?>;
    }
