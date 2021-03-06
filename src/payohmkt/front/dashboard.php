<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function dashboard()
{
    $hasWallet = false;
    $ibans = array();
    $_walletDetails = new stdClass();
    $walletManager = new WC_Payohmkt_Wallet();
    $moneyoutManager = new WC_Payohmkt_Moneyout();

    $current_user = wp_get_current_user();
    $_wallet = $walletManager->getWalletByUser($current_user->ID);
    $moneyouts = array();
    if ($_wallet) {
        $hasWallet = true;
        $_walletDetails = $walletManager->getWalletDetails($_wallet->id_lw_wallet);
        $ibans = $_walletDetails->ibans;
        
        $moneyouts = $moneyoutManager->getMoneyouts($current_user->ID);
    }
?>  
    <div class="woocommerce">
    <?php wc_print_notices(); ?>
                    <div class="">
                        <h3><?php echo __('Wallet Information', PAYOHMKT_TEXT_DOMAIN) ?></h3>
                    </div>
                    <div class="">
                        <?php if($hasWallet):?>
                             <table cellspacing="0" class="shop_table shop_table_responsive" >
                            <tr>
                                <td ><label ><?php echo __('Wallet ID', PAYOHMKT_TEXT_DOMAIN)?></label></td>
                                <td >
                                    <strong><?php  echo $_wallet->id_lw_wallet ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td ><label ><?php echo __('Balance', PAYOHMKT_TEXT_DOMAIN)?></label></td>
                                <td >
                                    <strong><?php echo wc_price($_walletDetails->BAL) ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td ><label ><?php echo __('Owner name', PAYOHMKT_TEXT_DOMAIN)?></label></td>
                                <td >
                                    <strong><?php echo $_walletDetails->NAME; ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td ><label ><?php echo __('Owner email', PAYOHMKT_TEXT_DOMAIN)?></label></td>
                                <td >
                                    <strong><?php echo $_walletDetails->EMAIL ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td ><label ><?php echo __('Status', PAYOHMKT_TEXT_DOMAIN)?></label></td>
                                <td >
                                    <strong><?php echo $_walletDetails->getStatusLabel() ?></strong>
                                </td>
                            </tr>
                             <tr>
                                <td ><label ><?php echo __('Documents', PAYOHMKT_TEXT_DOMAIN)?></label></td>
                                <td >
                                   <?php echo sprintf(__('<strong>%d</strong> document(s) uploaded.', PAYOHMKT_TEXT_DOMAIN),count($_walletDetails->kycDocs)) ?><br /> 
                                </td>
                            </tr>
                        </table>
                        <?php else:?>
                            <p><?php echo __("You don't have a wallet!", PAYOHMKT_TEXT_DOMAIN)?></p>
                            <a href="<?php echo add_query_arg( array(
                                                    'page' => 'payoh',
                                                    'action' => 'createWallet'
                                                    ), get_permalink() ) ?>"><?php echo __('Create my wallet') ?></a>
                        <?php endif;?>
                    </div>
                    
                    <?php if($hasWallet):?>
                    <div class="box">
                        <div class="box-title">
                            <h3><?php echo __('Ibans',PAYOHMKT_TEXT_DOMAIN) ?></h3>
                         </div>
                        <div class="box-content">
                            <?php if(count($ibans) > 0) :?>
                                <table cellspacing="0" class="shop_table shop_table_responsive" id="ibans_table">
                                    <col width="1"  />
                                    <col width="1"  />
                                    <col  />
                                    <thead>
                                        <tr>
                                            <th><?php echo __('Account number', PAYOHMKT_TEXT_DOMAIN)?></th>
                                            <th><?php echo __('Bic', PAYOHMKT_TEXT_DOMAIN)?></th>
                                            <th><?php echo __('Holder', PAYOHMKT_TEXT_DOMAIN)?></th>
                                            <th><?php echo __('Status', PAYOHMKT_TEXT_DOMAIN)?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php /* @var $iban Iban */?>
                                    <?php foreach ($ibans as $iban):?>
                                        <tr class="">
                                            <td><?php echo $iban->IBAN ?></td>
                                            <td><?php echo $iban->BIC ?></td>
                                            <td><?php echo $iban->HOLDER ?></td>
                                            <td><?php echo $iban->STATUS ?></td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            <?php else:?>
                                <p><?php echo __("You don't have any Iban!", PAYOHMKT_TEXT_DOMAIN)?></p>
                            <?php endif;?>
                            <a href="<?php echo add_query_arg( array(
                                'page' => 'payoh-add-iban'
                                ), get_permalink() ); ?>"><?php echo __('Add an Iban', PAYOHMKT_TEXT_DOMAIN) ?></a>
                        </div>
                    </div>
                <?php endif;?>
                
                <?php if($hasWallet && $_walletDetails->BAL > 0):?>
                  <div class="box">
                        <div class="box-title">
                            <h2><?php echo __('Money out',PAYOHMKT_TEXT_DOMAIN) ?></h2>
                        </div>
                        <?php if(is_array($moneyouts) && count($moneyouts)):?>
                            <p style="margin: 10px;font-size:18px"><?php echo __('Your ten last money out', PAYOHMKT_TEXT_DOMAIN)?></p>
                            <table cellspacing="0" class="shop_table shop_table_responsive" id="moneyout_table">
                                <thead>
                                    <tr>
                                        <th><?php echo __('Amount', PAYOHMKT_TEXT_DOMAIN)?></th>
                                        <th><?php echo __('New balance', PAYOHMKT_TEXT_DOMAIN)?></th>
                                        <th><?php echo __('Date', PAYOHMKT_TEXT_DOMAIN)?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($moneyouts as $mo):?>
                                    <tr class="">
                                        <td><?php echo wc_price($mo->amount_to_pay)?></td>
                                        <td><?php echo wc_price($mo->new_bal)?></td>
                                        <td><?php echo date( 'Y-m-d', strtotime( $mo->date_add ) ) ?></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        <?php else:?>
                            <p class="a-center" style="margin:10px 0"><?php echo __("You don't have any Money out!",PAYOHMKT_TEXT_DOMAIN)?></p>
                        <?php endif;?>
                        <a  href="<?php echo add_query_arg( array(
                        'page' => 'payoh-do-moneyout'
                        ), get_permalink() ); ?>" class="button" title="<?php echo __('Do a money out',PAYOHMKT_TEXT_DOMAIN) ?>"><span><span><?php echo __('Do a money out',PAYOHMKT_TEXT_DOMAIN) ?></span></span></a>

                  </div>
                  <?php endif;?>
                </div><!-- end div woocommerce -->
<?php 
}
