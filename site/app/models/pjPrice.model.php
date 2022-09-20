<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjPriceModel extends pjAppModel {

    protected $table = 'prices';
    protected $schema = array(
        array('name' => 'bus_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'ticket_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'from_location_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'to_location_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'price', 'type' => 'decimal', 'default' => ':NULL'),
        array('name' => 'is_return', 'type' => 'enum', 'default' => 'F')
    );

    public static function factory($attr = array()) {
        return new pjPriceModel($attr);
    }

    public function getTicketPrice($busId, $pickupId, $returnId, $bookedData, $optionArr, $localeId, $isReturn) {
        $subTotal = 0;
        $tax = 0;
        $total = 0;
        $deposit = 0;

        $subTotalFormat = '';
        $taxFormat = '';
        $totalFormat = '';
        $depositFormat = '';

        $ticketArr = $this
                ->reset()
                ->join('pjTicket', 't1.ticket_id = t2.id', 'left')
                ->join('pjMultiLang', "t3.model='pjTicket' AND t3.foreign_id=t1.ticket_id AND t3.field='title' AND t3.locale='" . $localeId . "'", 'left outer')
                ->join('pjBus', 't1.bus_id = t4.id', 'left')
                ->select("t1.*, t2.seats_count, t3.content as ticket, t4.discount")
                ->where('t1.bus_id', $busId)
                ->where('t1.from_location_id', $pickupId)
                ->where('t1.to_location_id', $returnId)
                ->where('is_return = "F"')
                ->index("FORCE KEY (`ticket_id`)")
                ->orderBy("ticket ASC")
                ->findAll()
                ->getData();

        foreach ($ticketArr as $k => $v) {
            $returnStr = $isReturn == 'T' ? 'return_' : '';

            if (isset($bookedData[$returnStr . 'ticket_cnt_' . $v['ticket_id']]) && (int) $bookedData[$returnStr . 'ticket_cnt_' . $v['ticket_id']] > 0) {
                $discount = 0;
                if (isset($v['discount']) && (float) $v['discount'] > 0 && $isReturn == 'T') {
                    $discount = $v['discount'];
                }
                $price = $v['price'] - ($v['price'] * $discount / 100);
                $subTotal += (int) $bookedData[$returnStr . 'ticket_cnt_' . $v['ticket_id']] * $price;
            }
        }

        if (!empty($optionArr['o_tax_payment']) && $subTotal > 0) {
            $tax = ($optionArr['o_tax_payment'] * $subTotal) / 100;
        }
        
        $total = $subTotal + $tax;
        if (!empty($optionArr['o_deposit_payment']) && $total > 0) {
            $deposit = ($optionArr['o_deposit_payment'] * $total) / 100;
        }

        $subTotalFormat = pjUtil::formatCurrencySign(number_format($subTotal, 2), $optionArr['o_currency']);
        $taxFormat = pjUtil::formatCurrencySign(number_format($tax, 2), $optionArr['o_currency']);
        $totalFormat = pjUtil::formatCurrencySign(number_format($total, 2), $optionArr['o_currency']);
        $depositFormat = pjUtil::formatCurrencySign(number_format($deposit, 2), $optionArr['o_currency']);

        return [
            'ticket_arr' => $ticketArr, 
            'sub_total' => $subTotal, 
            'tax' => $tax, 
            'total' => $total, 
            'deposit' => $deposit,
            'sub_total_format' => $$subTotalFormat,
            'tax_format' => $$taxFormat, 
            'total_format' => $totalFormat, 
            'deposit_format' => $depositFormat
        ];
        
    }

}

?>