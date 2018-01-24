<?php if ($this->isShow): ?>
    <div id="<?= $this->id ?>" class="uk-modal uk-modal-password">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>
            <div class="uk-grid">
                <div class="uk-width-large-1-1 uk-width-medium-1-1 uk-width-small-1-1">                
                    <?= $this->message ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            if (typeof UIkit != 'undefined') {
                modal = UIkit.modal('#<?= $this->id ?>', {center: true});
                modal.show();
            }
        });
    </script>
<?php endif; ?> 