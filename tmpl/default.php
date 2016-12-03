<?php
defined('_JEXEC') or die;

$style = '';
if($params->get('float_image'))
{
    $style .= 'float:'.$params->get('float_image').'; ';
}
if($params->get('tam_image'))
{
    $style .= 'width:'.$params->get('tam_image').'px; ';
}
if($params->get('padding_image'))
{
    $style .= 'padding:'.$params->get('padding_image').'; ';
}
?>
<div class="accordion <?php echo $moduleclass_sfx; ?>" id="accordion<?php echo $module->id; ?>">
<?php foreach ($items as $item) : ?>
	<div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $module->id; ?>" href="#collapse<?php echo $item->id; ?>">
                <?php echo $item->title; ?>
            </a>
        </div>
        <div id="collapse<?php echo $item->id; ?>" class="accordion-body collapse">
            <div class="accordion-inner">
                <?php if($params->get('show_image') != 'off'): ?>
                    <?php
                    $images = json_decode($item->images);
                    $image = $images->image_intro;
                    $alt = $images->image_intro_alt ? $images->image_intro_alt : $item->title;
                    if($params->get('show_image') == 'fulltext')
                    {
                        $image = $images->image_fulltext;
                        $alt = $images->image_fulltext_alt ? $images->image_fulltext_alt : $item->title;
                    }
                    ?>
                    <?php if($params->get('link_image')): ?>
                        <a href="<?php echo $item->link; ?>" itemprop="url">
                            <img style="<?php echo $style; ?>" data-src="<?php echo $image; ?>" src="<?php echo $image; ?>" alt="<?php echo $alt; ?>">
                        </a>
                    <?php else: ?>
                        <img style="<?php echo $style; ?>" data-src="<?php echo $image; ?>" src="<?php echo $image; ?>" alt="<?php echo $alt; ?>">
                    <?php endif; ?>
                <?php endif; ?>

                <?php if($params->get('show_content') != 'offc'): ?>
                    <?php
                    if($params->get('show_content') == 'partc'):
                        $cleanText = filter_var($item->introtext, FILTER_SANITIZE_STRING);
                        $introCleanText = strip_tags($cleanText);
                        if (strlen($introCleanText) > $params->get('tam_content', 200))
                        {
                            $introtext = substr($introCleanText,0,strrpos(substr($introCleanText,0,$params->get('tam_content', 200))," ")).'...';
                        }
                        else
                        {
                            $introtext = $introCleanText;
                        }
                    elseif($params->get('show_content') == 'fullc'):
                        $introtext = $item->fulltext;
                    else:
                        $introtext = $item->introtext;
                    endif;
                    ?>
                    <p><?php echo $introtext; ?></p>
                <?php endif; ?>
                
                <?php if($params->get('show_readmore')): ?>
                <p class="text-right">
                    <a href="<?php echo $item->link; ?>" class="btn btn-primary"><?php echo $params->get('readmore_text') ? $params->get('readmore_text') : JText::_('MOD_ARTICLES_FAQ_FIELD_READMORE_TEXT'); ?></a>
                </p>
                <?php endif; ?>
            </div>
        </div>
	</div>
<?php endforeach; ?>
</div>