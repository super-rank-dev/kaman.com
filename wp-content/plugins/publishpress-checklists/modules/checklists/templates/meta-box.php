<?php $show_required_legend = false; ?>

<div id="<?php echo esc_attr($context['metadata_taxonomy']); ?>-meta-box">
    <input type="hidden" name="<?php echo esc_attr($context['metadata_taxonomy']); ?>_nonce"
           value="<?php echo esc_attr($context['nonce']); ?>"/>

    <ul id="pp-checklists-req-box">
        <?php if (empty($context['requirements'])) : ?>
            <p>
                <?php
                $message = sprintf(
                    esc_html($context['lang']['empty_checklist_message']),
                    '<a href="' . esc_url($context['configure_link']) . '">',
                    '</a>'
                );
                ?>
                <em><?php echo $message;// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></em>
            </p>
        <?php else : ?>
            <?php foreach ($context['requirements'] as $key => $req) : ?>
                <li
                        id="pp-checklists-req-<?php echo esc_attr($key); ?>"
                        class="pp-checklists-req pp-checklists-<?php echo esc_attr($req['rule']); ?> status-<?php echo $req['status'] ? 'yes' : 'no'; ?> <?php echo $req['is_custom'] ? 'pp-checklists-custom-item' : ''; ?>"
                        data-id="<?php echo esc_attr($key); ?>"
                        data-type="<?php echo esc_attr($req['type']); ?>">

                    <?php if ($req['is_custom']) : ?>
                        <input type="hidden" name="_PPCH_custom_item[<?php echo esc_attr($req['id']); ?>]"
                               value="<?php echo $req['status'] ? 'yes' : 'no'; ?>"/>
                    <?php endif; ?>

                    <?php
                    if ($req['is_custom']) :
                        $icon_class = $req['status'] ? 'dashicons-yes' : '';
                    else:
                        $icon_class = $req['status'] ? 'dashicons-yes' : 'dashicons-no';
                    endif;
                    ?>
                    <div class="status-icon dashicons <?php echo esc_attr($icon_class); ?>"></div>
                    <div class="status-label">
                        <?php echo esc_html($req['label']); ?>
                        <?php if ($req['rule'] === 'block') : ?>
                            <span class="required">*</span>
                            <?php $show_required_legend = true; ?>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <?php if ($show_required_legend) : ?>
        <em>(*) <?php echo esc_html($context['lang']['required']); ?></em>
    <?php endif; ?>
</div>

<?php # Modal Windows; ?>
<div class="remodal" data-remodal-id="pp-checklists-modal-alert"
     data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
    <div id="pp-checklists-modal-alert-content"></div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel"><?php echo esc_html($context['lang']['ok']); ?></button>
</div>

<div class="remodal" data-remodal-id="pp-checklists-modal-confirm"
     data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
    <div id="pp-checklists-modal-confirm-content"></div>
    <br>
    <button data-remodal-action="cancel" class="remodal-cancel"><?php echo esc_html($context['lang']['no']); ?></button>
    <button data-remodal-action="confirm"
            class="remodal-confirm"><?php echo esc_html($context['lang']['yes']); ?></button>
</div>
