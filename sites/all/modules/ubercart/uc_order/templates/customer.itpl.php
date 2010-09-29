<?php
// $Id: customer.itpl.php,v 1.5.2.9 2009/09/21 14:34:49 islandusurper Exp $

/**
 * @file
 * This file is the default customer invoice template for Ubercart.
 */
?>

<table width="95%" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#006699" style="font-family: verdana, arial, helvetica; font-size: small;">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center" bgcolor="#FFFFFF" style="font-family: verdana, arial, helvetica; font-size: small;">
        <?php if ($business_header) { ?>
        <tr valign="top">
          <td>
            <table width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">
              <tr>
                <td>
                  [site-logo]
                </td>
                <td width="98%">
                  <div style="padding-left: 1em;">
                  <span style="font-size: large;">[store-name]</span><br />
                  [site-slogan]
                  </div>
                </td>
                <td nowrap="nowrap">
                  [store-address]<br />[store-phone]
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <?php } ?>

        <tr valign="top">
          <td>

            <?php if ($thank_you_message) { ?>
            <p><b><?php echo t('Thanks for your order, [order-first-name]!'); ?></b></p>
            
            <p><?php print t("La sua richiesta &egrave; andata a un buon fine. Il numero della richiesta &egrave;: [order-link]");?></p>
              
            <p><?php print t("L'ufficio commerciale provvederà ad evadere l'ordine attenendosi alle condizioni di consegna e pagamento in uso. Solo in caso di anomalie vi contatteremmo entro le prossime 48 ore.");?></p>

            <?php if (isset($_SESSION['new_user'])) { ?>
            <p><b><?php echo t('An account has been created for you with the following details:'); ?></b></p>
            <p><b><?php echo t('Username:'); ?></b> [new-username]<br />
            <b><?php echo t('Password:'); ?></b> [new-password]</p>
            <?php } ?>

           
            <?php } ?>

            <table cellpadding="4" cellspacing="0" border="0" width="100%" style="font-family: verdana, arial, helvetica; font-size: small;">

              <?php if ($help_text || $email_text || $store_footer) { ?>
              <tr>
                <td colspan="2">
                  <hr noshade="noshade" size="1" /><br />

                  <?php if ($email_text) { ?>
                  <p><?php echo t('Please note: This e-mail message is an automated notification. Please do not reply to this message.'); ?></p>

                  <p><?php echo t('Thanks again for shopping with us.'); ?></p>
                  <?php } ?>

                  <?php if ($store_footer) { ?>
                  <p><b>[store-link]</b><br /><b>[site-slogan]</b></p>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>

            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
