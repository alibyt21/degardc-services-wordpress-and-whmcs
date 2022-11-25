<?php 



function gregorian_to_jalali($gy,$gm,$gd,$mod=''){
    $g_d_m=array(0,31,59,90,120,151,181,212,243,273,304,334);
    if($gy>1600){
     $jy=979;
     $gy-=1600;
    }else{
     $jy=0;
     $gy-=621;
    }
    $gy2=($gm>2)?($gy+1):$gy;
    $days=(365*$gy) +((int)(($gy2+3)/4)) -((int)(($gy2+99)/100)) +((int)(($gy2+399)/400)) -80 +$gd +$g_d_m[$gm-1];
    $jy+=33*((int)($days/12053)); 
    $days%=12053;
    $jy+=4*((int)($days/1461));
    $days%=1461;
    if($days > 365){
     $jy+=(int)(($days-1)/365);
     $days=($days-1)%365;
    }
    $jm=($days < 186)?1+(int)($days/31):7+(int)(($days-186)/30);
    $jd=1+(($days < 186)?($days%31):(($days-186)%30));
    $jd = str_pad($jd, 2, "0", STR_PAD_LEFT);
    $jm = str_pad($jm, 2, "0", STR_PAD_LEFT);
    return($mod=='')?array($jy,$jm,$jd):$jy.$mod.$jm.$mod.$jd;
}











function jdate($format, $timestamp = '', $none = '', $time_zone = 'Asia/Tehran', $tr_num = 'fa') {

  $T_sec = 0;/* <= رفع خطاي زمان سرور ، با اعداد '+' و '-' بر حسب ثانيه */

  if ($time_zone != 'local') date_default_timezone_set(($time_zone === '') ? 'Asia/Tehran' : $time_zone);
  $ts = $T_sec + (($timestamp === '') ? time() : tr_num($timestamp));
  $date = explode('_', date('H_i_j_n_O_P_s_w_Y', $ts));
  list($j_y, $j_m, $j_d) = gregorian_to_jalali($date[8], $date[3], $date[2]);
  $doy = ($j_m < 7) ? (($j_m - 1) * 31) + $j_d - 1 : (($j_m - 7) * 30) + $j_d + 185;
  $kab = (((($j_y + 12) % 33) % 4) == 1) ? 1 : 0;
  $sl = strlen($format);
  $out = '';
  for ($i = 0; $i < $sl; $i++) {
    $sub = substr($format, $i, 1);
    if ($sub == '\\') {
      $out .= substr($format, ++$i, 1);
      continue;
    }
    switch ($sub) {

      case 'E':
      case 'R':
      case 'x':
      case 'X':
        break;

      case 'B':
      case 'e':
      case 'g':
      case 'G':
      case 'h':
      case 'I':
      case 'T':
      case 'u':
      case 'Z':
        $out .= date($sub, $ts);
        break;

      case 'a':
        $out .= ($date[0] < 12) ? 'ق.ظ' : 'ب.ظ';
        break;
        
      case 'A':
        $ali_date = date('H', $timestamp);
        if(0 <= $ali_date && $ali_date < 6){
            $out .= 'نیمه شب';
            break;
        }elseif(6 <= $ali_date && $ali_date < 12){
            $out .= 'صبح';
            break;
        }elseif(12 <= $ali_date && $ali_date < 14){
            $out .= 'ظهر';
            break;
        }elseif(14 <= $ali_date && $ali_date < 20){
            $out .= 'بعد از ظهر';
            break;
        }elseif(20 <= $ali_date && $ali_date < 24){
            $out .= 'شب';
            break;
        }

      case 'b':
        $out .= (int) ($j_m / 3.1) + 1;
        break;

      case 'c':
        $out .= $j_y . '/' . $j_m . '/' . $j_d . ' ،' . $date[0] . ':' . $date[1] . ':' . $date[6] . ' ' . $date[5];
        break;

      case 'C':
        $out .= (int) (($j_y + 99) / 100);
        break;

      case 'd':
        $out .= ($j_d < 10) ? '0' . $j_d : $j_d;
        break;

      case 'D':
        $out .= jdate_words(array('kh' => $date[7]), ' ');
        break;

      case 'f':
        $out .= jdate_words(array('ff' => $j_m), ' ');
        break;

      case 'F':
        $out .= jdate_words(array('mm' => $j_m), ' ');
        break;

      case 'H':
        $out .= $date[0];
        break;

      case 'i':
        $out .= $date[1];
        break;

      case 'j':
        $out .= $j_d;
        break;

      case 'J':
        $out .= jdate_words(array('rr' => $j_d), ' ');
        break;

      case 'k';
        $out .= tr_num(100 - (int) ($doy / ($kab + 365.24) * 1000) / 10, $tr_num);
        break;

      case 'K':
        $out .= tr_num((int) ($doy / ($kab + 365.24) * 1000) / 10, $tr_num);
        break;

      case 'l':
        $out .= jdate_words(array('rh' => $date[7]), ' ');
        break;

      case 'L':
        $out .= $kab;
        break;

      case 'm':
        $out .= ($j_m > 9) ? $j_m : '0' . $j_m;
        break;

      case 'M':
        $out .= jdate_words(array('km' => $j_m), ' ');
        break;

      case 'n':
        $out .= $j_m;
        break;

      case 'N':
        $out .= $date[7] + 1;
        break;

      case 'o':
        $jdw = ($date[7] == 6) ? 0 : $date[7] + 1;
        $dny = 364 + $kab - $doy;
        $out .= ($jdw > ($doy + 3) and $doy < 3) ? $j_y - 1 : (((3 - $dny) > $jdw and $dny < 3) ? $j_y + 1 : $j_y);
        break;

      case 'O':
        $out .= $date[4];
        break;

      case 'p':
        $out .= jdate_words(array('mb' => $j_m), ' ');
        break;

      case 'P':
        $out .= $date[5];
        break;

      case 'q':
        $out .= jdate_words(array('sh' => $j_y), ' ');
        break;

      case 'Q':
        $out .= $kab + 364 - $doy;
        break;

      case 'r':
        $key = jdate_words(array('rh' => $date[7], 'mm' => $j_m));
        $out .= $date[0] . ':' . $date[1] . ':' . $date[6] . ' ' . $date[4] . ' ' . $key['rh'] . '، ' . $j_d . ' ' . $key['mm'] . ' ' . $j_y;
        break;

      case 's':
        $out .= $date[6];
        break;

      case 'S':
        $out .= 'ام';
        break;

      case 't':
        $out .= ($j_m != 12) ? (31 - (int) ($j_m / 6.5)) : ($kab + 29);
        break;

      case 'U':
        $out .= $ts;
        break;

      case 'v':
        $out .= jdate_words(array('ss' => ($j_y % 100)), ' ');
        break;

      case 'V':
        $out .= jdate_words(array('ss' => $j_y), ' ');
        break;

      case 'w':
        $out .= ($date[7] == 6) ? 0 : $date[7] + 1;
        break;

      case 'W':
        $avs = (($date[7] == 6) ? 0 : $date[7] + 1) - ($doy % 7);
        if ($avs < 0) $avs += 7;
        $num = (int) (($doy + $avs) / 7);
        if ($avs < 4) {
          $num++;
        } elseif ($num < 1) {
          $num = ($avs == 4 or $avs == ((((($j_y % 33) % 4) - 2) == ((int) (($j_y % 33) * 0.05))) ? 5 : 4)) ? 53 : 52;
        }
        $aks = $avs + $kab;
        if ($aks == 7) $aks = 0;
        $out .= (($kab + 363 - $doy) < $aks and $aks < 3) ? '01' : (($num < 10) ? '0' . $num : $num);
        break;

      case 'y':
        $out .= substr($j_y, 2, 2);
        break;

      case 'Y':
        $out .= $j_y;
        break;

      case 'z':
        $out .= $doy;
        break;

      default:
        $out .= $sub;
    }
  }
  return ($tr_num != 'en') ? tr_num($out, 'fa', '.') : $out;
}




function tr_num($str, $mod = 'en', $mf = '٫') {
  $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.');
  $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', $mf);
  return ($mod == 'fa') ? str_replace($num_a, $key_a, $str) : str_replace($key_a, $num_a, $str);
}




function jdate_words($array, $mod = '') {
  foreach ($array as $type => $num) {
    $num = (int) tr_num($num);
    switch ($type) {

      case 'ss':
        $sl = strlen($num);
        $xy3 = substr($num, 2 - $sl, 1);
        $h3 = $h34 = $h4 = '';
        if ($xy3 == 1) {
          $p34 = '';
          $k34 = array('ده', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هجده', 'نوزده');
          $h34 = $k34[substr($num, 2 - $sl, 2) - 10];
        } else {
          $xy4 = substr($num, 3 - $sl, 1);
          $p34 = ($xy3 == 0 or $xy4 == 0) ? '' : ' و ';
          $k3 = array('', '', 'بیست', 'سی', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود');
          $h3 = $k3[$xy3];
          $k4 = array('', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه');
          $h4 = $k4[$xy4];
        }
        $array[$type] = (($num > 99) ? str_replace(
          array('12', '13', '14', '19', '20'),
          array('هزار و دویست', 'هزار و سیصد', 'هزار و چهارصد', 'هزار و نهصد', 'دوهزار'),
          substr($num, 0, 2)
        ) . ((substr($num, 2, 2) == '00') ? '' : ' و ') : '') . $h3 . $p34 . $h34 . $h4;
        break;

      case 'mm':
        $key = array('فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند');
        $array[$type] = $key[$num - 1];
        break;

      case 'rr':
        $key = array(
          'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه', 'ده', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هجده', 'نوزده', 'بیست', 'بیست و یک', 'بیست و دو', 'بیست و سه', 'بیست و چهار', 'بیست و پنج', 'بیست و شش', 'بیست و هفت', 'بیست و هشت', 'بیست و نه', 'سی', 'سی و یک'
        );
        $array[$type] = $key[$num - 1];
        break;

      case 'rh':
        $key = array('یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه', 'شنبه');
        $array[$type] = $key[$num];
        break;

      case 'ff':
        $key = array('بهار', 'تابستون', 'پاییز', 'زمستون');
        $array[$type] = $key[(int) ($num / 3.1)];
        break;

      


      default:
        $array[$type] = $num;
    }
  }
  return ($mod === '') ? $array : implode($mod, $array);
}

function int_time_to_jalali_date($int_time,$time=0){
    $str = date("Y-m-d H:i", $int_time);    
    $result = sscanf($str, "%d-%d-%d %d:%d" , $year , $month , $day , $hour , $minute);
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    $day = str_pad($day, 2, "0", STR_PAD_LEFT);
    $hour = str_pad($hour, 2, "0", STR_PAD_LEFT);
    $minute = str_pad($minute, 2, "0", STR_PAD_LEFT);
    $shamsi_date_str = gregorian_to_jalali($year, $month, $day,'/');
    if($time==1){
        $shamsi_date_and_time_str = "$shamsi_date_str ساعت $hour:$minute";
    }elseif($time==0){
        $shamsi_date_and_time_str = "$shamsi_date_str";
    }
    return $shamsi_date_and_time_str;
}