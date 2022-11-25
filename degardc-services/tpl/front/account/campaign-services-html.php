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
                                <th class="table__th">محصول / آدرس</th>
                                <th class="table__th">اولین پرداخت</th>
                                <th class="table__th">دوره صورتحساب</th>
                                <th class="table__th">تاریخ سررسید بعدی</th>
                                <th class="table__th">وضعیت</th>
                            </tr>
                        </thead>
                        <tbody class="table__tbody">

                            <?php
                            $num = 0;
                            foreach (array_reverse($products) as $product) {
                                $num++;
                                $product_name = $product->name;
                                $product_domain = $product->domain;
                                $product_firstpaymentamount = $product->firstpaymentamount;
                                $product_billingcycle = $product->billingcycle;
                                switch($product_billingcycle){
                                    case 'Monthly':
                                        $product_billingcycle = 'ماهانه';
                                        break;
                                    case 'Quarterly':
                                        $product_billingcycle = 'سه ماهه';
                                        break;
                                    case 'Semi-Annually':
                                        $product_billingcycle = 'شش ماهه';
                                        break;
                                    case 'Annually':
                                        $product_billingcycle = 'سالانه';
                                        break;
                                    case 'Biannually':
                                        $product_billingcycle = 'دو ساله';
                                        break;
                                    case 'Triennially':
                                        $product_billingcycle = 'سه ساله';
                                        break;
                                }
                                $product_nextduedate = $product->nextduedate;
                                $product_status = $product->status;
                                switch($product_status){
                                    case 'Pending':
                                        $product_status = '<p class="table-row__p-status status--blue status">در انتظار پرداخت</p>';
                                        $row_status = 'blue';
                                        break;
                                    case 'Active':
                                        $product_status = '<p class="table-row__p-status status--green status">فعال</p>';
                                        $row_status = 'green';
                                        break;
                                    case 'Suspended':
                                        $product_status = '<p class="table-row__p-status status--yellow status">معلق</p>';
                                        $row_status = 'yellow';
                                        break;
                                    case 'Terminated':
                                        $product_status = '<p class="table-row__p-status status--red status">حذف شده</p>';
                                        $row_status = 'red';
                                        break;
                                    case 'Cancelled':
                                        $product_status = '<p class="table-row__p-status status--red status">لغو شده</p>';
                                        $row_status = 'red';
                                        break;
                                    case 'Fraud':
                                        $product_status = '<p class="table-row__p-status status--red status">تقلب</p>';
                                        $row_status = 'red';
                                        break;
                                    default:
                                        $product_status;
                                }
                                if($row_status == 'yellow'){
                                    ?>
                                    <tr class="table-row table-row--yellow">
                                    <?php
                                }elseif($row_status == 'red'){
                                    ?>
                                    <tr class="table-row table-row--red">
                                    <?php
                                }elseif($row_status == 'green') {
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
                                    <td data-column="محصول / آدرس" class="table-row__td">
                                        <div class="table-row__info">
                                            <p class="table-row__name">
                                                <a href="<?php echo 'https://' . $product_domain; ?>" target="_blank">
                                                    <?php
                                                    echo $product_domain;
                                                    ?>
                                                </a>

                                            </p>
                                            <span class="table-row__small">
                                                <?php
                                                echo $product_name;
                                                ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td data-column="اولین پرداخت" class="table-row__td">
                                        <?php
                                        echo number_format($product_firstpaymentamount/1000);
                                        ?>
                                        هزار تومان
                                    </td>
                                    <td data-column="دوره صورتحساب" class="table-row__td">
                                        <?php
                                        echo $product_billingcycle;
                                        ?>
                                    </td>
                                    <td data-column="تاریخ سررسید بعدی" class="table-row__td">
                                        <?php
                                        echo int_time_to_jalali_date(strtotime($product_nextduedate));
                                        ?>
                                    </td>
                                    <td data-column="وضعیت" class="table-row__td">
                                        <?php
                                        echo $product_status;
                                        ?>
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