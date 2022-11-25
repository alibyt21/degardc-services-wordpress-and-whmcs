<div class="degardc-container">

    <a href="?" class="degardc-btn-back">بازگشت<i aria-hidden="true" class="fas fa-reply" style="margin-right: 5px"></i></a>
    <hr class="degardc-hr">
    <div class="degardc-full row--top-20">
        <div class="col-md-12">
            <div class="table-container">
                <table class="table">
                    <thead class="table__thead">
                    <tr>
                        <th class="table__th">ردیف</th>
                        <th class="table__th">شماره صورتحساب</th>
                        <th class="table__th">تاریخ ایجاد صورتحساب</th>
                        <th class="table__th">تاریخ سررسید</th>
                        <th class="table__th">مجموع کل</th>
                        <th class="table__th">وضعیت</th>
                        <th class="table__th">عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="table__tbody">

                    <?php
                    $num = 0;
                    foreach ($invoices as $invoice) {
                        $num++;
                        $invoice_id = $invoice->id;
                        $invoice_date = $invoice->date;
                        $invoice_duedate = $invoice->duedate;
                        $invoice_total = $invoice->total;

                        $invoice_status = $invoice->status;
                        switch($invoice_status){
                            case 'Unpaid':
                                $invoice_status = '<p class="table-row__p-status status--red status">پرداخت نشده</p>';
                                $row_status = 'red';
                                break;
                            case 'Paid':
                                $invoice_status = '<p class="table-row__p-status status--green status">پرداخت شده</p>';
                                $row_status = 'green';
                                break;
                            case 'Pending':
                                $invoice_status = '<p class="table-row__p-status status--yellow status">در انتظار پرداخت</p>';
                                $row_status = 'blue';
                                break;
                            case 'Draft':
                                $invoice_status = '<p class="table-row__p-status status--yellow status">پیش نویس</p>';
                                $row_status = 'yellow';
                                break;
                            case 'Cancelled':
                                $invoice_status = '<p class="table-row__p-status status--red status">لغو شده</p>';
                                $row_status = 'red';
                                break;
                            default:
                                $invoice_status;
                        }
                        if($row_status == 'yellow'){
                            ?>
                            <tr class="table-row table-row--yellow">
                            <?php
                        }elseif($row_status == 'red'){
                            ?>
                            <tr class="table-row table-row--red">
                            <?php
                        }elseif($row_status == 'green'){
                            ?>
                            <tr class="table-row table-row--green">
                            <?php
                        }else{
                            ?>
                            <tr class="table-row">
                            <?php
                        }
                        ?>
                        <td data-column="ردیف" class="table-row__td">
                            <?php

                            if($row_status == 'yellow'){
                                ?>
                                <div class="table-row--overdue-yellow"></div>
                                <?php
                            }elseif($row_status == 'red'){
                                ?>
                                <div class="table-row--overdue"></div>
                                <?php
                            }

                            echo $num;
                            ?>
                        </td>
                        <td data-column="شماره صورتحساب" class="table-row__td">
                            <?php
                            echo $invoice_id;
                            ?>
                        </td>
                        <td data-column="تاریخ ایجاد صورتحساب" class="table-row__td">
                            <?php
                            echo int_time_to_jalali_date(strtotime($invoice_date));
                            ?>
                        </td>
                        <td data-column="تاریخ سررسید" class="table-row__td">
                            <?php
                            echo int_time_to_jalali_date(strtotime($invoice_duedate));
                            ?>
                        </td>
                        <td data-column="مجموع کل" class="table-row__td">
                            <?php
                            echo number_format($invoice_total/1000);
                            ?>
                            هزار تومان
                        </td>
                        <td data-column="وضعیت" class="table-row__td">
                            <?php
                            echo $invoice_status;
                            ?>
                        </td>
                        <td data-column="عملیات" class="table-row__td">
                            <div class="table-row__edit">
                                <a href="?action=view-invoice&id=<?php echo $invoice_id; ?>">
                                    <i class="fas fa-file-invoice" style="vertical-align:middle;"></i>
                                    مشاهده صورتحساب
                                </a>
                            </div>
                        </td>

                        </tr>
                        <?php
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="degardc-notice">
        <p class="degardc-message"></p>
    </div>

</div>