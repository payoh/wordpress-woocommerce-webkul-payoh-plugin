<?php 

function formIban()
{
    ?>
    <!-- @TODO create a custom CSS file -->
    <div class="woocommerce">
    <?php wc_print_notices(); ?>
    <div class="">
        <h3><?php echo __('New Iban',PAYOHMKT_TEXT_DOMAIN) ?></h3>
    </div>

    <form action="" method="post" >
        <div class="fieldset">
            <h2 class="legend"><?php echo __('Bank account informations',PAYOHMKT_TEXT_DOMAIN) ?></h2>
            <div class="form-list">
                <div class="wide">
                    <label for="holder" class="required"><?php echo __('Holder',PAYOHMKT_TEXT_DOMAIN)?></label>
                    <div class="input-box">
                        <input type="text" class="input-text required" id="holder" name="iban_data[holder]" value="" placeholder="<?php echo __('Holder account name',PAYOHMKT_TEXT_DOMAIN)?>" />
                    </div>
                </div>
                <div class="wide">
                    <label for="iban" class="required"><?php echo __('Iban',PAYOHMKT_TEXT_DOMAIN)?></label>
                    <div class="input-box">
                        <input type="text" class="input-text required" id="iban" name="iban_data[iban]" value="" placeholder="<?php echo __('Iban Number',PAYOHMKT_TEXT_DOMAIN)?>" />
                    </div>
                </div>
                <div class="wide">
                    <label for="bic" ><?php echo __('Bic',PAYOHMKT_TEXT_DOMAIN)?></label>
                    <div class="input-box">
                        <input type="text"  class="input-text" id="bic" name="iban_data[bic]" value="" placeholder="<?php echo __('Bic number',PAYOHMKT_TEXT_DOMAIN)?>" />
                    </div>
                </div>
                <div class="wide">
                    <label for="dom1"><?php echo __('Agency',PAYOHMKT_TEXT_DOMAIN)?></label>
                    <div class="input-box">
                        <input type="text" class="input-text" id="dom1" name="iban_data[dom1]" value="" placeholder="<?php echo __('Agency name',PAYOHMKT_TEXT_DOMAIN)?>" />
                    </div>
                </div>
                <div class="wide">
                    <label for="dom2"><?php echo __('Agency street',PAYOHMKT_TEXT_DOMAIN)?></label>
                    <div class="input-box">
                        <input type="text" class="input-text" id="dom2" name="iban_data[dom2]" value="" placeholder="<?php echo __('Agency street name',PAYOHMKT_TEXT_DOMAIN)?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="buttons-set">
            <a class="edit-link" href="<?php echo add_query_arg( array(
            'page' => 'payoh'), get_permalink() ); ?>"><small>&laquo; </small><?php echo __('Back',PAYOHMKT_TEXT_DOMAIN) ?></a>
            <button type="submit" class="button" title="<?php echo __('Save Iban',PAYOHMKT_TEXT_DOMAIN) ?>"><span><span><?php echo __('Save Iban',PAYOHMKT_TEXT_DOMAIN) ?></span></span></button>
    </div>
    </form>
    </div>
    
    <?php 
}