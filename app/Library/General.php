<?php

namespace App\Library;
use Carbon\Carbon;
class General
{

    public function loadCss($type){
        $data = array();

        switch ($type) {
            case $type == 1:
                array_push($data, "https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.1.1/css/hover-min.css");
                array_push($data,"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
                array_push($data, "https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.9/css/weather-icons.min.css");
                array_push($data, "https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.0.0-6/css/ionicons.min.css");
                array_push($data, "https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.9/css/weather-icons.min.css");
                array_push($data, asset('public/lib/jquery-toggles/toggles-full.css'));
                array_push($data, "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css");
                array_push($data, asset('public/lib/morrisjs/morris.css'));
                array_push($data, asset('public/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css'));
                array_push($data, asset('public/lib/jquery.gritter/jquery.gritter.css'));
                array_push($data, asset('public/css/quirk.css'));
//                array_push($data, asset('public/lib/jqwidgets/styles/jqx.base.min.css'));
                array_push($data, 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
                array_push($data,'https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css');
                array_push($data,'https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css');
                 array_push($data, asset('public/lib/switch/css/bootstrap3/bootstrap-switch.min.css'));
                   array_push($data,asset('public/lib/select2/select2.css'));
                   
              
           
                break;
            case $type == 2:
                array_push($data, asset('public/css/case2.css'));
                array_push($data,"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
//                array_push($data, "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css");
//                array_push($data, asset('lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.css'));
//                array_push($data, asset('lib/jquery.gritter/jquery.gritter.min.css'));
//                array_push($data, asset('css/quirk.min.css'));
//                array_push($data,asset('css/jquery-confirm.min.css'));
                 array_push($data,asset('public/assets/plugins/select2/select2.css'));
                array_push($data,asset('public/lib/summernote/summernote.css'));
                array_push($data, asset('public/lib/star-rating/css/star-rating-svg.css'));
                array_push($data, asset('public/lib/switch/css/bootstrap3/bootstrap-switch.min.css'));
                break;
            case $type == 3:
                array_push($data,"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
                array_push($data, "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css");
               array_push($data, asset('public/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.css'));
                array_push($data, asset('public/lib/jquery.gritter/jquery.gritter.css'));
                array_push($data, asset('public/css/quirk.min.css'));
                array_push($data, asset('public/lib/jqwidgets/styles/jqx.base.min.css'));
                array_push($data,asset('public/css/jquery-confirm.min.css'));
              
                break;
                case $type == 4:
                array_push($data,"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
//                array_push($data, "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css");
                array_push($data, asset('public/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.css'));
                array_push($data, asset('public/lib/jquery.gritter/jquery.gritter.css'));
                array_push($data, asset('public/css/quirk.min.css'));
                array_push($data, asset('public/lib/jqwidgets/styles/jqx.base.min.css'));
                array_push($data,asset('public/css/daterangepicker.min.css'));
                     array_push($data,asset('public/css/jquery-confirm.min.css'));
                break;
        }
        
        return $data;
    }   

    public function loadJs($type){
        $data = array();

        switch ($type) {
            case $type == 1:
                array_push($data, asset('public/lib/modernizr/modernizr.js'));
                array_push($data, asset('public/lib/jquery/jquery.min.js'));
                array_push($data, asset('public/lib/jquery-ui/jquery-ui.js'));
                array_push($data, asset('public/lib/bootstrap/js/bootstrap.js'));
                array_push($data, asset('public/lib/jquery-toggles/toggles.js'));
                array_push($data, asset('public/lib/datatables/jquery.dataTables.js'));
                array_push($data, asset('public/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js'));
                array_push($data, asset('public/lib/morrisjs/morris.js'));
                array_push($data, asset('public/lib/raphael/raphael.js'));
                array_push($data, asset('public/lib/flot/jquery.flot.js'));
                array_push($data, asset('public/lib/flot/jquery.flot.resize.js'));
                array_push($data, asset('public/lib/flot-spline/jquery.flot.spline.js'));
                array_push($data, asset('public/lib/jquery-knob/jquery.knob.js'));
                array_push($data, asset('public/js/quirk.js'));
                array_push($data, asset('public/js/dashboard.js'));
                array_push($data, asset('public/js/moment.min.js'));
                array_push($data, asset('public/lib/jquery-validate/jquery.validate.js'));
                array_push($data, asset('public/lib/jquery.gritter/jquery.gritter.js'));
                array_push($data, asset('public/js/bootstrap-datepicker.min.js'));
                array_push($data, asset('public/js/combodate.min.js'));
                break;
            case $type == 2:
//                array_push($data, asset('lib/modernizr/modernizr.js'));
                array_push($data, asset('public/lib/jquery/jquery.min.js'));
//                array_push($data, asset('lib/jquery-ui/jquery-ui.min.js'));
//                array_push($data, asset('lib/jquery/jquery.js'));
                array_push($data, asset('public/lib/morrisjs/morris.js'));
                array_push($data, asset('public/lib/raphael/raphael.js'));
                array_push($data, asset('public/lib/bootstrap/js/bootstrap.min.js'));
                array_push($data, asset('public/lib/jquery-toggles/toggles.min.js'));
                array_push($data, asset('public/lib/datatables/jquery.dataTables.min.js'));
                array_push($data, asset('public/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'));
                array_push($data, asset('public/lib/jquery-validate/jquery.validate.min.js'));
                array_push($data, asset('public/lib/jquery.gritter/jquery.gritter.min.js'));
                array_push($data, asset('public/js/quirk.js'));;
                array_push($data, asset('public/js/jquery-confirm.min.js'));
                array_push($data, asset('public/js/bootstrap3-typeahead.min.js'));
                array_push($data, asset('public/js/bootstrap-datepicker.min.js'));
                array_push($data, asset('public/js/moment.min.js'));
                array_push($data, asset('public/js/daterangepicker.min.js'));
                array_push($data, asset('public/lib/summernote/summernote.js'));
                  array_push($data, asset('public/lib/switch/js/bootstrap-switch.min.js'));
                array_push($data, 'https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js');
                  array_push($data,asset('public/lib/select2/select2.js'));
                
                break;
            case $type == 3:
                array_push($data, asset('public/lib/jquery/jquery.min.js'));
                array_push($data, asset('public/lib/bootstrap/js/bootstrap.min.js'));
                array_push($data, asset('public/lib/jquery-toggles/toggles.min.js'));
                array_push($data, asset('public/lib/datatables/jquery.dataTables.min.js'));
                array_push($data, asset('public/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'));
                array_push($data, asset('public/lib/jquery-validate/jquery.validate.min.js'));
                array_push($data, asset('public/lib/jquery.gritter/jquery.gritter.min.js'));
                array_push($data, asset('public/js/jquery-confirm.min.js'));
                array_push($data, asset('public/js/quirk.js'));
                array_push($data, asset('public/js/bootstrap3-typeahead.min.js'));
                array_push($data, asset('public/js/bootstrap-datepicker.min.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxcore.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxdata.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxbuttons.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxscrollbar.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxmenu.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.js'));
//                array_push($data, asset('lib/jqwidgets/jqxgrid.filter.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.sort.js'));
//                  array_push($data, asset('lib/jqwidgets/jqxgrid.jqxpanel.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.pager.js'));
               
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.edit.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.selection.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxlistbox.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxdropdownlist.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxcheckbox.js'));
//                array_push($data, asset('lib/jqwidgets/jqxcalendar.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxnumberinput.js'));
//                array_push($data, asset('lib/jqwidgets/jqxdatetimeinput.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxinput.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.aggregates.js'));
//                array_push($data, asset('lib/jqwidgets/globalization/globalize.js'));
                   array_push($data, asset('public/lib/jqwidgets/scripts/customizelocalization.js'));
                break;
              case $type == 4:
                array_push($data, asset('public/lib/jquery/jquery.min.js'));
                array_push($data, asset('public/lib/bootstrap/js/bootstrap.min.js'));
                array_push($data, asset('public/lib/jquery-toggles/toggles.min.js'));
                array_push($data, asset('public/lib/datatables/jquery.dataTables.min.js'));
                array_push($data, asset('public/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js'));
                array_push($data, asset('public/lib/jquery-validate/jquery.validate.min.js'));
                array_push($data, asset('public/lib/jquery.gritter/jquery.gritter.min.js'));
                array_push($data, asset('public/js/jquery-confirm.min.js'));
                array_push($data, asset('public/js/quirk.js'));
                array_push($data, asset('public/js/bootstrap3-typeahead.min.js'));
                array_push($data, asset('public/js/bootstrap-datepicker.min.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxcore.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxdata.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxbuttons.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxscrollbar.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxmenu.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.js'));
//                array_push($data, asset('lib/jqwidgets/jqxgrid.filter.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.sort.js'));
//                  array_push($data, asset('lib/jqwidgets/jqxgrid.jqxpanel.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.pager.js'));
               
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.edit.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.selection.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxlistbox.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxdropdownlist.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxcheckbox.js'));
//                array_push($data, asset('lib/jqwidgets/jqxcalendar.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxnumberinput.js'));
//                array_push($data, asset('lib/jqwidgets/jqxdatetimeinput.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxinput.js'));
                array_push($data, asset('public/lib/jqwidgets/jqxgrid.aggregates.js'));
//                array_push($data, asset('lib/jqwidgets/globalization/globalize.js'));
                   array_push($data, asset('public/lib/jqwidgets/scripts/customizelocalization.js'));
                   array_push($data, asset('public/js/moment.min.js'));
                array_push($data, asset('public/js/daterangepicker.min.js'));
                break;
            
        }
        
        return $data;
    }
    public function sideMenu() {
        $data['main_menus'] = \App\Model\UserAccess::leftJoin('side_menu', 'side_menu.id', '=', 'user_access.side_menu_id')
                ->where('user_access.user_group_id', session()->get('user_group'))
                ->where('side_menu.menu_category', 0)
                ->orderBy('side_menu.menu_order', 'asc')
                ->distinct('side_menu.id')
                ->select('side_menu.id as id', 'side_menu.menu_order as menu_order', 'side_menu.menu_category as menu_category', 'side_menu.menu_name as menu_name', 'side_menu.menu_id as menu_id', 'side_menu.menu_icon as menu_icon', 'side_menu.menu_url as menu_url')
                ->get();
        $data['sub_menus'] = \App\Model\UserAccess::leftJoin('side_menu', 'side_menu.id', '=', 'user_access.side_menu_id')
                ->where('user_access.user_group_id', session()->get('user_group'))
                ->where('side_menu.menu_category', '!=', 0)
                ->orderBy('side_menu.menu_order', 'asc')
                ->distinct('side_menu.id')
                ->select('side_menu.id as id', 'side_menu.menu_order as menu_order', 'side_menu.menu_category as menu_category', 'side_menu.menu_name as menu_name', 'side_menu.menu_id as menu_id', 'side_menu.menu_icon as menu_icon', 'side_menu.menu_url as menu_url')
                ->get();
        return $data;
    }
    

     function time_elapsed_string($datetime, $full = false, $time = FALSE) {
        if ($time) {

            $now = new Carbon;
            $d = date('YYYY-MM-DD HH:MM:SS', $datetime);
            $ago = new Carbon($d);
            $diff = $now->diff($ago);
            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;
        } else {

            $now = new Carbon;
            $ago = new Carbon($datetime);
            $diff = $now->diff($ago);
            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;
        }
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full){
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' ago' : 'just now';
         
    }



    public function convert_number_to_words($number) {
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }
        
//        if (null !== $fraction && is_numeric($fraction)) {
//            $string .= $conjunction;
////            $words = array();
////            foreach (str_split((string) $fraction) as $number) {
////                $words[] = $dictionary[$number];
////            }
////            $string .= implode(' ', $words);
//            $string .= $this->convert_number_to_words($fraction);
//            $string .= 'cents';
//        }

        return $string;
    }   
    public function getOptions($data, $default,$select, $value = true) {

        $options = "";
        $options .= '<option value="">'.$select.'</option>';
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if (($key == $default) || ($val == $default)) {
                    if ($value) {
                        $options .= '<option value="' . $key . '" selected="selected">' . $val . '</option>';
                    } else {
                        $options .= '<option value="' . $val . '" selected="selected">' . $val . '</option>';
                    }
                } else {
                    if ($value) {
                        $options .= '<option value="' . $key . '">' . $val . '</option>';
                    } else {
                        $options .= '<option value="' . $val . '">' . $val . '</option>';
                    }
                }
            }
        } else if (is_object($data)) {
            foreach ($data->result() as $row) {
                $key = $row->value;
                $val = $row->description;
                if (($key == $default) || ($val == $default)) {
                    $options .= '<option value="' . $key . '" selected="selected">' . $val . '</option>';
                } else {
                    $options .= '<option value="' . $key . '">' . $val . '</option>';
                }
            }
        }
        return $options;
    }
    

public function limit_text($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }
    public function timeArray(){
        $time_array=[];
        $time_array["minutes"]="By Minutes";
        $time_array["hours"]="By Hour";
        $time_array["days"]="By Days";
        return $time_array;
    }
    public function eventTypeArray(){
        $event_type_array=[];
        $event_type_array[1]="Conference";
        $event_type_array[2]="Meeting";
        $event_type_array[3]="Government events";
        $event_type_array[4]="NGO & Other events";
        $event_type_array[5]="Exhibition";
        $event_type_array[6]="Sales & Marketing";
        $event_type_array[7]="Institutional events";
        $event_type_array[8]="Other events";
        return $event_type_array;

    }
}
