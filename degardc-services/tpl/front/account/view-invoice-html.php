<?php
$invoice_status = $specific_client_invoice->status;
switch ($invoice_status) {
    case 'Unpaid':
        $invoice_status_div = '<div class="degardc-btn-back red degardc-right">پرداخت نشده</div>';
        break;
    case 'Paid':
        $invoice_status_div = '<div class="degardc-btn-back green degardc-right">پرداخت شده</div>';
        break;
    case 'Pending':
        $invoice_status_div = '<div class="degardc-btn-back degardc-right">در انتظار پرداخت</div>';
        break;
    case 'Draft':
        $invoice_status_div = '<div class="degardc-btn-back degardc-right">پیش نویس</div>';
        break;
    case 'Cancelled':
        $invoice_status_div = '<div class="degardc-btn-back red degardc-right">لغو شده</div>';
        break;
    default:
        $invoice_status_div = $invoice_status;
}
$invoice_id = $specific_client_invoice->invoiceid;
$invoice_date = $specific_client_invoice->date;
$invoice_total = $specific_client_invoice->total;
$invoice_item = $specific_client_invoice->items->item;
$invoice_description = $invoice_item[0]->description;
$invoice_paymentmethod = $specific_client_invoice->paymentmethod;
?>
<div class="degardc-container">
    <div class="degardc-full">
        <a href="?" class="degardc-btn-back degardc-left">بازگشت<i aria-hidden="true" class="fas fa-reply" style="margin-right: 5px"></i></a>
        <?php echo $invoice_status_div; ?>
    </div>
    <hr class="degardc-hr">
    <div class="invoice-card">
        <div class="invoice-title">
            <div id="main-title">
                <h4>صورتحساب</h4>
                <span>#<?php echo $invoice_id; ?></span>
            </div>

            <span id="date"><?php echo int_time_to_jalali_date(strtotime($invoice_date)) ?></span>
        </div>

        <div class="invoice-details">
            <table class="invoice-table">
                <thead>
                <tr>
                    <td class="invoice-td">محصول</td>
                    <td class="invoice-td">قیمت</td>
                </tr>
                </thead>

                <tbody>
                <tr class="row-data">
                    <td class="invoice-td"><?php echo $invoice_description; ?></td>
                    <td class="invoice-td"><?php echo number_format($invoice_total/1000) ?> هزار تومان</td>
                </tr>

                <tr class="calc-row">
                    <td class="invoice-td">مجموع کل</td>
                    <td class="invoice-td"><?php echo number_format($invoice_total/1000) ?> هزار تومان</td>
                </tr>
                </tbody>
            </table>
        </div>

        <?php
        if( ($invoice_status == 'Unpaid') || ($invoice_status == 'Pending') ){
            ?>
            <div class="invoice-footer">
                <form id="degardc-pay-invoice-form">
                    <input type="hidden" name="degardc-invoice-id" id="degardc-invoice-id" value="<?php echo $invoice_id ?>">
                    <input type="hidden" name="degardc-client-id" id="degardc-client-id" value="<?php echo $whmcs_client_id ?>">
                    <input type="hidden" name="degardc-payment-method" id="degardc-payment-method" value="<?php echo $invoice_paymentmethod ?>">
                    <input type="submit" class="degardc-button" name="degardc-pay-invoice-button" id="degardc-pay-invoice-button" value="پرداخت صورتحساب">
                </form>
            </div>
            <?php
        }
        ?>

    </div>



    <div class="degardc-notice" id="degardc-pay-invoice-notice">
        <p class="degardc-message" id="degardc-pay-invoice-message"></p>
    </div>

    <?php wp_nonce_field( 'degardc_nonce' ); ?>

</div>