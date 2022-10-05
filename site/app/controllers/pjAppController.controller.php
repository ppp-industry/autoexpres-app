<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjAppController extends pjController {

    public $models = array();
    public $defaultLocale = 'admin_locale_id';
    public $defaultFields = 'fields';
    public $defaultFieldsIndex = 'fields_index';

    public function isOneAdminReady() {
        return $this->isAdmin();
    }

    public function isCountryReady() {
        return $this->isAdmin();
    }

    public static function setTimezone($timezone = "UTC") {
        if (in_array(version_compare(phpversion(), '5.1.0'), array(0, 1))) {
            date_default_timezone_set($timezone);
        } else {
            $safe_mode = ini_get('safe_mode');
            if ($safe_mode) {
                putenv("TZ=" . $timezone);
            }
        }
    }

    public static function setMySQLServerTime($offset = "-0:00") {
        pjAppModel::factory()->prepare("SET SESSION time_zone = :offset;")->exec(compact('offset'));
    }

    public function setTime() {
        if (isset($this->option_arr['o_timezone'])) {
            $offset = $this->option_arr['o_timezone'] / 3600;
            if ($offset > 0) {
                $offset = "-" . $offset;
            } elseif ($offset < 0) {
                $offset = "+" . abs($offset);
            } elseif ($offset === 0) {
                $offset = "+0";
            }

            pjAppController::setTimezone('Etc/GMT' . $offset);
            if (strpos($offset, '-') !== false) {
                $offset = str_replace('-', '+', $offset);
            } elseif (strpos($offset, '+') !== false) {
                $offset = str_replace('+', '-', $offset);
            }
            pjAppController::setMySQLServerTime($offset . ":00");
        }
    }

    public function isEditor() {
        return $this->getRoleId() == 2;
    }

    public function getForeignId() {
        return 1;
    }

    public function beforeFilter() {
        $this->appendJs('jquery.min.js', PJ_THIRD_PARTY_PATH . 'jquery/');
        $dm = new pjDependencyManager(PJ_THIRD_PARTY_PATH);
        $dm->load(PJ_CONFIG_PATH . 'dependencies.php')->resolve();
        $this->appendJs('jquery-migrate.min.js', $dm->getPath('jquery_migrate'), FALSE, FALSE);
        $this->appendJs('pjAdminCore.js');
        $this->appendCss('reset.css');

        $this->appendJs('js/jquery-ui.custom.min.js', PJ_THIRD_PARTY_PATH . 'jquery_ui/');
        $this->appendCss('css/smoothness/jquery-ui.min.css', PJ_THIRD_PARTY_PATH . 'jquery_ui/');

        $this->appendCss('pj-all.css', PJ_FRAMEWORK_LIBS_PATH . 'pj/css/');
        $this->appendCss('admin.css');

        
        if ($_GET['controller'] != 'pjInstaller') {
            $this->models['Option'] = pjOptionModel::factory();
            $this->option_arr = $this->models['Option']->getPairs($this->getForeignId());
            $this->set('option_arr', $this->option_arr);
            $this->setTime();

            if (!isset($_SESSION[$this->defaultLocale])) {
                $locale_arr = pjLocaleModel::factory()->where('is_default', 1)->limit(1)->findAll()->getData();
                if (count($locale_arr) === 1) {
                    $this->setLocaleId($locale_arr[0]['id']);
                }
            }
            $this->loadSetFields();
        }
    }

    public static function setFields($locale) {
        if (isset($_SESSION['lang_show_id']) && (int) $_SESSION['lang_show_id'] == 1) {
            $fields = pjMultiLangModel::factory()
                    ->select('CONCAT(t1.content, CONCAT(":", t2.id, ":")) AS content, t2.key')
                    ->join('pjField', "t2.id=t1.foreign_id", 'inner')
                    ->where('t1.locale', $locale)
                    ->where('t1.model', 'pjField')
                    ->where('t1.field', 'title')
                    ->findAll()
                    ->getDataPair('key', 'content');
        } else {
            $fields = pjMultiLangModel::factory()
                    ->select('t1.content, t2.key')
                    ->join('pjField', "t2.id=t1.foreign_id", 'inner')
                    ->where('t1.locale', $locale)
                    ->where('t1.model', 'pjField')
                    ->where('t1.field', 'title')
                    ->findAll()
                    ->getDataPair('key', 'content');
        }
        $registry = pjRegistry::getInstance();
        $tmp = array();
        if ($registry->is('fields')) {
            $tmp = $registry->get('fields');
        }
        $arrays = array();
        foreach ($fields as $key => $value) {
            if (strpos($key, '_ARRAY_') !== false) {
                list($prefix, $suffix) = explode("_ARRAY_", $key);
                if (!isset($arrays[$prefix])) {
                    $arrays[$prefix] = array();
                }
                $arrays[$prefix][$suffix] = $value;
            }
        }
        require PJ_CONFIG_PATH . 'settings.inc.php';
        $fields = array_merge($tmp, $fields, $settings, $arrays);
        $registry->set('fields', $fields);
    }

    public static function jsonDecode($str) {
        $Services_JSON = new pjServices_JSON();
        return $Services_JSON->decode($str);
    }

    public static function jsonEncode($arr) {
        $Services_JSON = new pjServices_JSON();
        return $Services_JSON->encode($arr);
    }

    public static function jsonResponse($arr) {
        header("Content-Type: application/json; charset=utf-8");
        echo pjAppController::jsonEncode($arr);
        exit;
    }

    public function getLocaleId() {
        return isset($_SESSION[$this->defaultLocale]) && (int) $_SESSION[$this->defaultLocale] > 0 ? (int) $_SESSION[$this->defaultLocale] : false;
    }

    public function setLocaleId($locale_id) {
        $_SESSION[$this->defaultLocale] = (int) $locale_id;
    }

    public function friendlyURL($str, $divider = '-') {
        $str = mb_strtolower($str, mb_detect_encoding($str));
        $str = trim($str);
        $str = preg_replace('/[_|\s]+/', $divider, $str);
        $str = preg_replace('/\x{00C5}/u', 'AA', $str);
        $str = preg_replace('/\x{00C6}/u', 'AE', $str);
        $str = preg_replace('/\x{00D8}/u', 'OE', $str);
        $str = preg_replace('/\x{00E5}/u', 'aa', $str);
        $str = preg_replace('/\x{00E6}/u', 'ae', $str);
        $str = preg_replace('/\x{00F8}/u', 'oe', $str);
        $str = preg_replace('/[^a-z\x{0400}-\x{04FF}0-9-]+/u', '', $str);
        $str = preg_replace('/[-]+/', $divider, $str);
        $str = preg_replace('/^-+|-+$/', '', $str);
        return $str;
    }

    public function pjActionCheckInstall() {
        $this->setLayout('pjActionEmpty');

        $result = array('status' => 'OK', 'code' => 200, 'text' => 'Operation succeeded', 'info' => array());
        $folders = array(
            'app/web/upload',
            'app/web/upload/bus_types'
        );
        foreach ($folders as $dir) {
            if (!is_writable($dir)) {
                $result['status'] = 'ERR';
                $result['code'] = 101;
                $result['text'] = 'Permission requirement';
                $result['info'][] = sprintf('Folder \'<span class="bold">%1$s</span>\' is not writable. You need to set write permissions (chmod 777) to directory located at \'<span class="bold">%1$s</span>\'', $dir);
            }
        }

        return $result;
    }

    public function getData($option_arr, $booking_arr, $salt, $locale_id) {
        $country = NULL;
        if (isset($booking_arr['c_country']) && !empty($booking_arr['c_country'])) {
            $country_arr = pjCountryModel::factory()
                            ->select('t1.id, t2.content AS country_title')
                            ->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $locale_id . "'", 'left outer')
                            ->find($booking_arr['c_country'])->getData();
            if (!empty($country_arr)) {
                $country = $country_arr['country_title'];
            }
        }

        $seats = '';
        $booked_seat_id_arr = pjBookingSeatModel::factory()
                ->select("DISTINCT (seat_id)")
                ->where('booking_id', $booking_arr['id'])
                ->findAll()
                ->getDataPair('seat_id', 'seat_id');
        if (!empty($booked_seat_id_arr)) {
            $selected_seat_arr = pjSeatModel::factory()->whereIn('t1.id', $booked_seat_id_arr)->findAll()->getDataPair('id', 'name');
            $seats = join(", ", $selected_seat_arr);
        }

        $row = array();
        if (isset($booking_arr['tickets'])) {
            $ticket_arr = $booking_arr['tickets'];
            foreach ($ticket_arr as $v) {
                if ($v['qty'] > 0) {
                    $price = $v['amount'] / $v['qty'];
                    $amount = $v['amount'];
                    if (isset($v['price'])) {
                        $price = $v['price'];
                        $amount = $price * $v['qty'];
                    }
                    $row[] = stripslashes($v['title']) . ' ' . $v['qty'] . ' x ' . pjUtil::formatCurrencySign(number_format($price, 2), $option_arr['o_currency']) . ' = ' . pjUtil::formatCurrencySign(number_format($amount, 2), $option_arr['o_currency']);
                }
            }
        }
        $tickets = count($row) > 0 ? join("<br/>", $row) : NULL;

        $bus = @$booking_arr['route_title'] . ', ' . date($option_arr['o_time_format'], strtotime(@$booking_arr['departure_time'])) . ' - ' . date($option_arr['o_time_format'], strtotime(@$booking_arr['arrival_time']));
        $route = mb_strtolower(__('lblFrom', true), 'UTF-8') . ' ' . @$booking_arr['from_location'] . ' ' . mb_strtolower(__('lblTo', true), 'UTF-8') . ' ' . @$booking_arr['to_location'];

        $time = $booking_arr['booking_time'];
        $total = pjUtil::formatCurrencySign($booking_arr['total'], $option_arr['o_currency']);

        $booking_date = NULL;
        if (isset($booking_arr['booking_date']) && !empty($booking_arr['booking_date'])) {
            $tm = strtotime(@$booking_arr['booking_date']);
            $booking_date = date($option_arr['o_date_format'], $tm);
        }
        $personal_titles = __('personal_titles', true, false);

        $cancelURL = PJ_INSTALL_URL . 'index.php?controller=pjFrontEnd&action=pjActionCancel&id=' . @$booking_arr['id'] . '&hash=' . sha1(@$booking_arr['id'] . @$booking_arr['created'] . $salt);
        $printURL = PJ_INSTALL_URL . 'index.php?controller=pjFrontEnd&action=pjActionPrintTickets&id=' . @$booking_arr['id'] . '&hash=' . sha1(@$booking_arr['id'] . @$booking_arr['created'] . $salt);
        $cancelURL = '<a href="' . $cancelURL . '">' . $cancelURL . '</a>';
        $printURL = '<a href="' . $printURL . '">' . $printURL . '</a>';
        $search = array(
            '{Title}', '{FirstName}', '{LastName}', '{Email}', '{Phone}', '{Country}',
            '{City}', '{State}', '{Zip}', '{Address}',
            '{Company}', '{CCType}', '{CCNum}', '{CCExp}', '{CCSec}', '{PaymentMethod}',
            '{UniqueID}', '{Date}', '{Bus}', '{Route}', '{Seats}', '{Time}', '{TicketTypesPrice}',
            '{Total}', '{Notes}',
            '{PrintTickets}',
            '{CancelURL}');
        $replace = array(
            (!empty($booking_arr['c_title']) ? $personal_titles[$booking_arr['c_title']] : null), $booking_arr['c_fname'], $booking_arr['c_lname'], $booking_arr['c_email'], $booking_arr['c_phone'], $country,
            $booking_arr['c_city'], $booking_arr['c_state'], $booking_arr['c_zip'], $booking_arr['c_address'],
            $booking_arr['c_company'], @$booking_arr['cc_type'], @$booking_arr['cc_num'], (@$booking_arr['payment_method'] == 'creditcard' ? @$booking_arr['cc_exp'] : NULL), @$booking_arr['cc_code'], @$booking_arr['payment_method'],
            @$booking_arr['uuid'], $booking_date, $bus, $route, $seats, $time, $tickets,
            @$total, @$booking_arr['c_notes'],
            $printURL,
            $cancelURL);

        return compact('search', 'replace');
    }

    public function getTemplate($option_arr, $booking_arr, $salt, $locale_id) {
        $country = NULL;
        if (isset($booking_arr['c_country']) && !empty($booking_arr['c_country'])) {
            $country_arr = pjCountryModel::factory()
                            ->select('t1.id, t2.content AS country_title')
                            ->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $locale_id . "'", 'left outer')
                            ->find($booking_arr['c_country'])->getData();
            if (!empty($country_arr)) {
                $country = $country_arr['country_title'];
            }
        }

        $seats = '';
        $booked_seat_id_arr = pjBookingSeatModel::factory()
                ->select("DISTINCT (seat_id)")
                ->where('booking_id', $booking_arr['id'])
                ->findAll()
                ->getDataPair('seat_id', 'seat_id');
        $booked_seat_id_arr = $booked_seat_id_arr;
        if (!empty($booked_seat_id_arr)) {
            $selected_seat_arr = pjSeatModel::factory()->whereIn('t1.id', $booked_seat_id_arr)->findAll()->getDataPair('id', 'name');
            $seats = join(", ", $selected_seat_arr);
        }
        $row = array();
        if (isset($booking_arr['tickets'])) {
            $ticket_arr = $booking_arr['tickets'];
            foreach ($ticket_arr as $v) {
                if ($v['qty'] > 0) {
                    $price = $v['amount'] / $v['qty'];
                    $row[] = stripslashes($v['title']) . ' ' . $v['qty'] . ' x ' . pjUtil::formatCurrencySign(number_format($price, 2), $option_arr['o_currency']);
                }
            }
        }
        $ticket_type = count($row) > 0 ? join("<br/>", $row) : NULL;

        $booking_route_arr = explode("<br/>", $booking_arr['booking_route']);
        $bus = $booking_route_arr[0];
        $route = $booking_route_arr[1];
        $time = $booking_arr['booking_time'];
        $total = pjUtil::formatCurrencySign($booking_arr['total'], $option_arr['o_currency']);

        $time_arr = explode(" - ", $time);

        $booking_date = NULL;
        if (isset($booking_arr['booking_date']) && !empty($booking_arr['booking_date'])) {
            $tm = strtotime(@$booking_arr['booking_date']);
            $booking_date = date($option_arr['o_date_format'], $tm);
        }
        $personal_titles = __('personal_titles', true, false);

        $cancelURL = PJ_INSTALL_URL . 'index.php?controller=pjFrontEnd&action=pjActionCancel&id=' . @$booking_arr['id'] . '&hash=' . sha1(@$booking_arr['id'] . @$booking_arr['created'] . $salt);
        $search = array(
            '{Title}', '{FirstName}', '{LastName}', '{Email}', '{Phone}', '{Country}',
            '{City}', '{State}', '{Zip}', '{Address}',
            '{Company}', '{CCType}', '{CCNum}', '{CCExp}', '{CCSec}', '{PaymentMethod}',
            '{UniqueID}', '{Date}', '{Bus}', '{Route}', '{Seat}', '{Time}',
            '{From_Location}', '{To_Location}', '{Departure_Time}', '{Arrival_Time}',
            '{TicketType}',
            '{Total}', '{Notes}',
            '{CancelURL}');
        $replace = array(
            (!empty($booking_arr['c_title']) ? $personal_titles[$booking_arr['c_title']] : null), $booking_arr['c_fname'], $booking_arr['c_lname'], $booking_arr['c_email'], $booking_arr['c_phone'], $country,
            $booking_arr['c_city'], $booking_arr['c_state'], $booking_arr['c_zip'], $booking_arr['c_address'],
            $booking_arr['c_company'], @$booking_arr['cc_type'], @$booking_arr['cc_num'], (@$booking_arr['payment_method'] == 'creditcard' ? @$booking_arr['cc_exp'] : NULL), @$booking_arr['cc_code'], @$booking_arr['payment_method'],
            @$booking_arr['uuid'], $booking_date, $bus, $route, $seats, $time,
            @$booking_arr['from_location'], @$booking_arr['to_location'], @$time_arr[0], @$time_arr[1],
            $ticket_type,
            @$total, @$booking_arr['c_notes'],
            @$cancelURL);

        return compact('search', 'replace');
    }

    public function getAdminEmail() {
        $arr = pjUserModel::factory()->find(1)->getData();
        return $arr['email'];
    }

    public function getAdminPhone() {
        $arr = pjUserModel::factory()->find(1)->getData();
        return !empty($arr['phone']) ? $arr['phone'] : null;
    }

    public function getAllEmails() {
        $user_arr = pjUserModel::factory()->where('t1.status', 'T')->findAll()->getData();
        $arr = array();
        foreach ($user_arr as $v) {
            if (!empty($v['email'])) {
                $arr[] = $v['email'];
            }
        }
        return $arr;
    }

    public function getAllPhones() {
        $user_arr = pjUserModel::factory()->where('t1.status', 'T')->findAll()->getData();
        $arr = array();
        foreach ($user_arr as $v) {
            if (!empty($v['phone'])) {
                $arr[] = $v['phone'];
            }
        }
        return $arr;
    }

    public function getBusAvailability($bus_id, $store, $option_arr) {
        $pickup_id = $store ['pickup_id'];
        $return_id = $store ['return_id'];
        $booked_seat_arr = array();
        $bus_type_arr = array();

        $bus_arr = pjBusModel::factory()->find($bus_id)->getData();
        $departure_time = null;
        $arrival_time = null;
        if (isset($store ['booking_period'] [$bus_id])) {
            if (isset($store ['booking_period'] [$bus_id] ['departure_time'])) {
                $departure_time = $store ['booking_period'] [$bus_id] ['departure_time'];
            }
            if (isset($store ['booking_period'] [$bus_id] ['arrival_time'])) {
                $arrival_time = $store ['booking_period'] [$bus_id] ['arrival_time'];
            }
        }
        $and_where = '';
        if ($departure_time != null && $arrival_time != null) {
            $and_where .= " AND ((TB.booking_datetime BETWEEN '$departure_time' AND '$arrival_time') OR (TB.stop_datetime BETWEEN '$departure_time' AND '$arrival_time' ) OR ('$departure_time' BETWEEN TB.booking_datetime AND TB.stop_datetime ) OR ('$arrival_time' BETWEEN TB.booking_datetime AND TB.stop_datetime ))";
        }

        if (!empty($bus_arr)) {
            $location_id_arr = pjRouteCityModel::factory()->getLocationIdPair($bus_arr ['route_id'], $pickup_id, $return_id);

            $booked_seat_arr = pjBookingSeatModel::factory()->select("DISTINCT seat_id")->where("t1.booking_id IN(SELECT TB.id
										  FROM `" . pjBookingModel::factory()->getTable() . "` AS TB
										  WHERE (TB.status='confirmed' OR (TB.status='pending' AND UNIX_TIMESTAMP(TB.created) >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL " . $option_arr ['o_min_hour'] . " MINUTE))))
					AND TB.bus_id = $bus_id $and_where)
					AND start_location_id IN(" . join(",", $location_id_arr) . ")")->findAll()->getDataPair("seat_id", "seat_id");

            $bus_type_arr = pjBusTypeModel::factory()->find($bus_arr ['bus_type_id'])->getData();
        }

        return compact('booked_seat_arr', 'bus_type_arr');
    }

    public function getReturnBusAvailability($bus_id, $store, $option_arr) {
        $pickup_id = $store ['return_id'];
        $return_id = $store ['pickup_id'];
        $booked_seat_arr = array();
        $bus_type_arr = array();

        $bus_arr = pjBusModel::factory()->find($bus_id)->getData();

        $departure_time = null;
        $arrival_time = null;
        if (isset($store ['booking_period'] [$bus_id])) {
            if (isset($store ['booking_period'] [$bus_id] ['departure_time'])) {
                $departure_time = $store ['booking_period'] [$bus_id] ['departure_time'];
            }
            if (isset($store ['booking_period'] [$bus_id] ['arrival_time'])) {
                $arrival_time = $store ['booking_period'] [$bus_id] ['arrival_time'];
            }
        }
        $and_where = '';
        if ($departure_time != null && $arrival_time != null) {
            $and_where .= " AND ((TB.booking_datetime BETWEEN '$departure_time' AND '$arrival_time') OR (TB.stop_datetime BETWEEN '$departure_time' AND '$arrival_time' ) OR ('$departure_time' BETWEEN TB.booking_datetime AND TB.stop_datetime ) OR ('$arrival_time' BETWEEN TB.booking_datetime AND TB.stop_datetime ))";
        }
        if (!empty($bus_arr)) {
            $location_id_arr = pjRouteCityModel::factory()->getLocationIdPair($bus_arr ['route_id'], $pickup_id, $return_id);

            $booked_seat_arr = pjBookingSeatModel::factory()->select("DISTINCT seat_id")->where("t1.booking_id IN(SELECT TB.id
										  FROM `" . pjBookingModel::factory()->getTable() . "` AS TB
											  WHERE (TB.status='confirmed' OR (TB.status='pending' AND UNIX_TIMESTAMP(TB.created) >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL " . $option_arr ['o_min_hour'] . " MINUTE))))
												  		AND TB.bus_id = $bus_id $and_where)
												  		AND start_location_id IN('" . join("', '", $location_id_arr) . "')")->findAll()->getDataPair("seat_id", "seat_id");

            $bus_type_arr = pjBusTypeModel::factory()->find($bus_arr ['bus_type_id'])->getData();
        }

        return compact('booked_seat_arr', 'bus_type_arr');
    }

    public function isBusReady() {
        $cnt_cities = pjCityModel::factory()->where('status', 'T')->findCount()->getData();
        $cnt_bus_types = pjBusTypeModel::factory()->where('status', 'T')->findCount()->getData();
        $cnt_routes = pjRouteModel::factory()->where('status', 'T')->findCount()->getData();
        $cnt_routes_cities = pjRouteCityModel::factory()->findCount()->getData();
        $cnt_route_details = pjRouteDetailModel::factory()->findCount()->getData();
        $cnt_buses = pjBusModel::factory()->findCount()->getData();

        if ($cnt_cities > 0 && $cnt_bus_types > 0 && $cnt_routes > 0 && $cnt_routes_cities > 0 && $cnt_route_details > 0 && $cnt_buses > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getBusList($pickupId, $returnId, $busIdArr, $bookingPeriod, $bookedData, $date, $isReturn,$transferId = null) {
      
        $pjBusLocationModel = pjBusLocationModel::factory();
        $pjPriceModel = pjPriceModel::factory();
        $pjBookingSeatModel = pjBookingSeatModel::factory();
        $pjBookingModel = pjBookingModel::factory();
        $pjBusTypeModel = pjBusTypeModel::factory();
        $pjRouteCityModel = pjRouteCityModel::factory();
        $pjSeatModel = pjSeatModel::factory();
        $pjCityModel = pjCityModel::factory();

        $cityPreparedQuery = "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'";

        $pickupLocation = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', $cityPreparedQuery, 'left outer')->find($pickupId)->getData();
        $returnLocation = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', $cityPreparedQuery, 'left outer')->find($returnId)->getData();
        
        $transferLocation = $transferId ? $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', $cityPreparedQuery, 'left outer')->find($transferId)->getData() : null;
        
        $ticketColumns = 0;
        $bookingDate = pjUtil::formatDate($date, $this->option_arr ['o_date_format']);
        
        $busArrFrom = $busArrTo = $busArr = null;
        
        if($transferId){
            $busIdArrFrom = &$busIdArr['from'];
            $busIdArrTo = &$busIdArr['to'];
            
            $busArrFrom = pjBusModel::factory()->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjBusType', "t3.id=t1.bus_type_id", 'left outer')->select(" t1.*, t2.content AS route, t3.seats_map")->where("(t1.id IN(" . join(',', $busIdArrFrom) . "))")->index("FORCE KEY (`bus_type_id`)")->orderBy("route asc")->findAll()->getData();
            $busArrTo = pjBusModel::factory()->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjBusType', "t3.id=t1.bus_type_id", 'left outer')->select(" t1.*, t2.content AS route, t3.seats_map")->where("(t1.id IN(" . join(',', $busIdArrTo) . "))")->index("FORCE KEY (`bus_type_id`)")->orderBy("route asc")->findAll()->getData();
        }
        else{   
            $busArr = pjBusModel::factory()->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjBusType', "t3.id=t1.bus_type_id", 'left outer')->select(" t1.*, t2.content AS route, t3.seats_map")->where("(t1.id IN(" . join(',', $busIdArr) . "))")->index("FORCE KEY (`bus_type_id`)")->orderBy("route asc")->findAll()->getData();
        }
        $fromLocation = $pickupLocation ['name'];
        $toLocation = $returnLocation ['name'];
        
        if($transferId){
            
            $transLocation = $transferLocation['name'];
            $locationIdArrFrom = $locationIdArrTo = array();
             
            list($busTypeArrFrom,$bookedSeatArrFrom,$seatArrFrom,$selectedSeatArrFrom) = $this->hundleBusData(
                                                                                    $busArrFrom,
                                                                                    $bookingPeriod,
                                                                                    $locationIdArrFrom,
                                                                                    $pjRouteCityModel,
                                                                                    $pjBusTypeModel,
                                                                                    $pjBusLocationModel,
                                                                                    $pjSeatModel,
                                                                                    $pjPriceModel,
                                                                                    $pjBookingSeatModel,
                                                                                    $pjBookingModel,
                                                                                    $transferId,
                                                                                    $returnId,
                                                                                    $bookingDate,
                                                                                    $ticketColumns,
                                                                                    $bookedData, 
                                                                                    $isReturn
                                                                                );
            
           
            
            
            list($busTypeArrTo,$bookedSeatArrTo,$seatArrTo,$selectedSeatArrTo) = $this->hundleBusData(
                                                                                    $busArrTo,
                                                                                    $bookingPeriod,
                                                                                    $locationIdArrTo,
                                                                                    $pjRouteCityModel,
                                                                                    $pjBusTypeModel,
                                                                                    $pjBusLocationModel,
                                                                                    $pjSeatModel,
                                                                                    $pjPriceModel,
                                                                                    $pjBookingSeatModel,
                                                                                    $pjBookingModel,
                                                                                    $pickupId,
                                                                                    $transferId,
                                                                                    $bookingDate,
                                                                                    $ticketColumns,
                                                                                    $bookedData, 
                                                                                    $isReturn
                                                                                );
            
          return [
                'booking_period' => $bookingPeriod,
                'bus_arr_to' => $busArrTo,
                'bus_arr_from' => $busArrFrom,
                'bus_type_arr_to' => $busTypeArrTo,
                'bus_type_arr_from' => $busTypeArrFrom,
                'booked_seat_arr_to' => $bookedSeatArrTo,
                'booked_seat_arr_from' => $bookedSeatArrFrom,
                'seat_arr_to' => $seatArrTo,
                'seat_arr_from' => $seatArrFrom,
                'selected_seat_arr_to' => $selectedSeatArrTo,
                'selected_seat_arr_from' => $selectedSeatArrFrom,
                'ticket_columns' => $ticketColumns,
              
              
                'from_location' => $fromLocation,
                'to_location' => $toLocation,  
              
              
                'transfer_location' => $transLocation,
            ];
        }
        else{
        
            $locationIdArr = array();

            list($busTypeArr,$bookedSeatArr,$seatArr,$selectedSeatArr) = $this->hundleBusData(
                                                                                    $busArr,
                                                                                    $bookingPeriod,
                                                                                    $locationIdArr,
                                                                                    $pjRouteCityModel,
                                                                                    $pjBusTypeModel,
                                                                                    $pjBusLocationModel,
                                                                                    $pjSeatModel,
                                                                                    $pjPriceModel,
                                                                                    $pjBookingSeatModel,
                                                                                    $pjBookingModel,
                                                                                    $pickupId,
                                                                                    $returnId,
                                                                                    $bookingDate,
                                                                                    $ticketColumns,
                                                                                    $bookedData, 
                                                                                    $isReturn
                                                                                );
            return [
                'booking_period' => $bookingPeriod,
                'bus_arr' => $busArr,
                'bus_type_arr' => $busTypeArr,
                'booked_seat_arr' => $bookedSeatArr,
                'seat_arr' => $seatArr,
                'selected_seat_arr' => $selectedSeatArr,
                'ticket_columns' => $ticketColumns,
                'from_location' => $fromLocation,
                'to_location' => $toLocation,  
            ];
        }
    }

    public function getBackupInfo() {
        $data = $id = $created = $type = array();
        if ($handle = opendir(PJ_WEB_PATH . 'backup')) {
            $i = 0;
            while (false !== ($entry = readdir($handle))) {
                preg_match('/(database-backup|files-backup)-(\d{10})\.(sql|zip)/', $entry, $m);
                if (isset($m[2])) {
                    $id[$i] = $entry;
                    $created[$i] = date($this->option_arr['o_date_format'] . ", H:i", $m[2]);
                    $type[$i] = $m[1] == 'database-backup' ? 'database' : 'files';
                    $data[$i]['id'] = $id[$i];
                    $data[$i]['created'] = $created[$i];
                    $data[$i]['type'] = $type[$i];
                    $i++;
                }
            }
            closedir($handle);
        }
        array_multisort($created, SORT_DESC, $id, SORT_DESC, $type, SORT_ASC, $data);
        $total = count($data);
        $rowCount = 1;
        $pages = ceil($total / $rowCount);
        $page = 1;
        if ($page > $pages) {
            $page = $pages;
        }

        return compact('data', 'total', 'pages', 'page', 'rowCount');
    }

    protected function loadSetFields($force = FALSE, $locale_id = NULL, $fields = NULL) {
        if (is_null($locale_id)) {
            $locale_id = $this->getLocaleId();
        }

        if (is_null($fields)) {
            $fields = $this->defaultFields;
        }

        $registry = pjRegistry::getInstance();
        if ($force || !isset($_SESSION[$this->defaultFieldsIndex]) || $_SESSION[$this->defaultFieldsIndex] != $this->option_arr['o_fields_index'] || !isset($_SESSION[$fields]) || empty($_SESSION[$fields])) {
            pjAppController::setFields($locale_id);

            # Update session
            if ($registry->is('fields')) {
                $_SESSION[$fields] = $registry->get('fields');
            }
            $_SESSION[$this->defaultFieldsIndex] = $this->option_arr['o_fields_index'];
        }

        if (isset($_SESSION[$fields]) && !empty($_SESSION[$fields])) {
            # Load fields from session
            $registry->set('fields', $_SESSION[$fields]);
        }

        return TRUE;
    }
    
    private function hundleBusData(
        &$busArr,
        &$bookingPeriod,
        &$locationIdArr,
        &$pjRouteCityModel,
        &$pjBusTypeModel,
        &$pjBusLocationModel,
        &$pjSeatModel,
        &$pjPriceModel,
        &$pjBookingSeatModel,
        &$pjBookingModel,
        &$pickupId,
        &$returnId,
        &$bookingDate,
        &$ticketColumns,
        &$bookedData, 
        &$isReturn,
        $isTransfer = false
    ){
        
        foreach ($busArr as $k => $bus) {
            $locations = $pjRouteCityModel->reset()->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.city_id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjBusLocation', "(t3.bus_id='" . $bus ['id'] . "' AND t3.location_id=t1.city_id", 'inner')->select("t1.*, t2.content, t3.departure_time, t3.arrival_time")->where('t1.route_id', $bus ['route_id'])->orderBy("`order` ASC")->findAll()->getData();
            $bus ['locations'] = $locations;

            if (!empty($bus ['start_date']) && !empty($bus ['end_date'])) {
                $bus ['from_to'] = pjUtil::formatDate($bus ['start_date'], "Y-m-d", $this->option_arr ['o_date_format']) . ' - ' . pjUtil::formatDate($bus ['end_date'], "Y-m-d", $this->option_arr ['o_date_format']);
            } else {
                $bus ['from_to'] = '';
            }
            if (!empty($bus ['departure']) && !empty($bus ['arrive'])) {
                $bus ['depart_arrive'] = pjUtil::formatTime($bus ['departure'], "H:i:s", $this->option_arr ['o_time_format']) . ' - ' . pjUtil::formatTime($bus ['arrive'], "H:i:s", $this->option_arr ['o_time_format']);
            } else {
                $bus ['depart_arrive'] = '';
            }
            
            
            $busArr[$k] = $bus;

            $busId = $bus ['id'];

            $seatBookedArr = array();
            $seatAvailArr = array();
            $departureTime = '';
            $arrivalTime = '';
            $duration = '';

            $pickupArr = $pjBusLocationModel->reset()->where('bus_id', $busId)->where("location_id", $pickupId)->limit(1)->findAll()->getData();
            $returnArr = $pjBusLocationModel->reset()->where('bus_id', $busId)->where("location_id", $returnId)->limit(1)->findAll()->getData();

            if (!empty($pickupArr)) {
                $departureTime = pjUtil::formatTime($pickupArr [0] ['departure_time'], 'H:i:s', $this->option_arr ['o_time_format']);
                $bookingPeriod [$busId] ['departure_time'] = $bookingDate . ' ' . $pickupArr [0] ['departure_time'];
            }
            if (!empty($returnArr)) {
                $arrivalTime = pjUtil::formatTime($returnArr [0] ['arrival_time'], 'H:i:s', $this->option_arr ['o_time_format']);
            }
            
            
            
            
            
            if (!empty($pickupArr) && !empty($returnArr)) {
                $seconds = 0;
                $startCount = false;
                foreach ($locations as $key => $lo) {
                    $nextLocation = $locations [$key + 1];

                    if ($lo ['city_id'] == $pickupId) {
                        $startCount = true;
                    }
                    if (isset($nextLocation) && $startCount == true) {
                        $seconds += pjUtil::calSeconds($lo ['departure_time'], $nextLocation ['arrival_time']);
                        if ($key + 1 < count($locations) && $key > 0 && $lo ['city_id'] != $pickupId) {
                            $seconds += pjUtil::calSeconds($lo ['arrival_time'], $lo ['departure_time']);
                        }
                    }
                    if ($nextLocation ['city_id'] == $returnId) {
                        break;
                    }
                }

                $minutes = ($seconds / 60) % 60;
                $hours = floor($seconds / (60 * 60));

                $hourStr = $hours . ' ' . ($hours != 1 ? mb_strtolower(__('front_hours', true, false)) : mb_strtolower(__('front_hour', true, false)));
                $minuteStr = $minutes > 0 ? '<br/>' . ($minutes . ' ' . ($minutes != 1 ? mb_strtolower(__('front_minutes', true, false)) : mb_strtolower(__('front_minute', true, false)))) : '';
                $duration = $hourStr . $minuteStr;

                if (isset($bookingPeriod [$busId] ['departure_time'])) {
                    $bookingPeriod [$busId] ['arrival_time'] = date('Y-m-d H:i:s', strtotime($bookingPeriod [$busId] ['departure_time']) + $seconds);
                }
            }

            $tempLocationIdArr = $pjRouteCityModel->getLocationIdPair($bus ['route_id'], $pickupId, $returnId);

            if (!empty($bookedData)) {
                if ($isReturn == 'F') {
                    if ($bookedData ['bus_id'] == $busId && empty($locationIdArr)) {
                        $locationIdArr = $tempLocationIdArr;
                    }
                } else {
                    if ($bookedData ['return_bus_id'] == $busId && empty($locationIdArr)) {
                        $locationIdArr = $tempLocationIdArr;
                    }
                }
            }

            if (!empty($tempLocationIdArr)) {
                $ticketPriceArr = $pjPriceModel->getTicketPrice($busId, $pickupId, $returnId, $bookedData, $this->option_arr, $this->getLocaleId(), $isReturn);
                $ticketArr = $ticketPriceArr ['ticket_arr'];

                if ($bus ['set_seats_count'] == 'F') {
                    $departureTime = null;
                    $arrivalTime = null;
                    if (isset($bookingPeriod [$busId])) {
                        if (isset($bookingPeriod [$busId] ['departure_time'])) {
                            $departureTime = $bookingPeriod [$busId] ['departure_time'];
                        }
                        if (isset($bookingPeriod [$busId] ['arrival_time'])) {
                            $arrivalTime = $bookingPeriod [$busId] ['arrival_time'];
                        }
                    }
                    $and_where = '';
                    if ($departureTime != null && $arrivalTime != null) {
                        $and_where .= " AND ((TB.booking_datetime BETWEEN '$departureTime' AND '$arrivalTime') OR (TB.stop_datetime BETWEEN '$departureTime' AND '$arrivalTime' ) OR ('$departureTime' BETWEEN TB.booking_datetime AND TB.stop_datetime ) OR ('$arrivalTime' BETWEEN TB.booking_datetime AND TB.stop_datetime ))";
                    }
                    $busTypeArr = $pjBusTypeModel->reset()->find($bus ['bus_type_id'])->getData();
                    $seatsAvailable = $busTypeArr ['seats_count'];
                    $seatBookedArr = $pjBookingSeatModel->reset()->select("DISTINCT t1.seat_id")->where("t1.start_location_id IN(" . join(",", $tempLocationIdArr) . ")
								AND t1.booking_id IN(SELECT TB.id
													FROM `" . $pjBookingModel->getTable() . "` AS TB
													WHERE (TB.status='confirmed'
															OR (TB.status='pending' AND UNIX_TIMESTAMP(TB.created) >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL " . $this->option_arr ['o_min_hour'] . " MINUTE))))
						AND TB.bus_id = $busId $and_where)")->findAll()->getDataPair("seat_id", "seat_id");

                    $cnt_booked = count($seatBookedArr);
                    $seatsAvailable -= $cnt_booked;
                    $busArr[$k]['seats_available'] = $seatsAvailable;
                }
                if (count($ticketArr) > $ticketColumns) {
                    $ticketColumns = count($ticketArr);
                }
                $busArr[$k]['ticket_arr'] = $ticketArr;
            }
            
            
            $seats = $pjSeatModel->reset()->where('t1.bus_type_id', $bus ['bus_type_id'])->findAll()->getData();
            foreach ($seats as $v) {
                if (!in_array($v ['id'], $seatBookedArr)) {
                    $seatAvailArr [] = $v ['id'] . '#' . $v ['name'];
                }
            }

            $busArr[$k]['seat_avail_arr'] = $seatAvailArr;
            $busArr[$k]['departure_time'] = $departureTime;
            $busArr[$k]['arrival_time'] = $arrivalTime;
            $busArr[$k]['duration'] = $duration;
        }

        $busTypeArr = $bookedSeatArr = $seatArr = $selectedSeatArr = array();

        if (!empty($bookedData) && !empty($locationIdArr)) {
            $busId = ($isReturn == 'F' ? $bookedData ['bus_id'] : $bookedData ['return_bus_id']);

            $arr = pjBusModel::factory()->find($busId)->getData();
            $busTypeArr = $pjBusTypeModel->reset()->find($arr ['bus_type_id'])->getData();

            $bookedSeatArr = $pjBookingSeatModel->reset()->select("DISTINCT seat_id")->where("t1.booking_id IN(SELECT TB.id
										FROM `" . pjBookingModel::factory()->getTable() . "` AS TB
										WHERE (TB.status='confirmed' OR (TB.status='pending' AND UNIX_TIMESTAMP(TB.created) >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL " . $this->option_arr ['o_min_hour'] . " MINUTE))))
				AND TB.bus_id = $busId
				AND TB.booking_date = '$bookingDate')
				AND start_location_id IN(" . join(",", $locationIdArr) . ")")->index("FORCE KEY (`booking_id`)")->findAll()->getDataPair("seat_id", "seat_id");

            $selectedSeatsStr = ($isReturn == 'F' ? $bookedData ['selected_seats'] : $bookedData ['return_selected_seats']);
            $seatArr = $pjSeatModel->reset()->where('bus_type_id', $arr ['bus_type_id'])->findAll()->getData();
            $selectedSeatArr = $pjSeatModel->reset()->whereIn('t1.id', explode("|", $selectedSeatsStr))->findAll()->getDataPair('id', 'name');
        }
        
         return [
            
            $busTypeArr,
            $bookedSeatArr,
            $seatArr,
            $selectedSeatArr
        ];   
    }
}

?>
