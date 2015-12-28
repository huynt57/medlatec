<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Util {

    public static function time_elapsed_string($ptime) {
        $etime = time() - $ptime;

        if ($etime < 1) {
            return '0 giây';
        }

        $a = array(365 * 24 * 60 * 60 => 'năm',
            30 * 24 * 60 * 60 => 'tháng',
            24 * 60 * 60 => 'ngày',
            60 * 60 => 'giờ',
            60 => 'phút',
            1 => 'giây'
        );
        $a_plural = array('năm' => 'năm',
            'tháng' => 'tháng',
            'ngày' => 'ngày',
            'giờ' => 'giờ',
            'phút' => 'phút',
            'giây' => 'giây'
        );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' trước';
            }
        }
    }

    public static function getStatus($status) {
        $name = NULL;
        switch ($status) {
            case -1:
                $name = 'Đã hủy';
                break;
            case 0:
                $name = 'Đã yêu cầu';
                break;
            case 1:
                $name = 'Đã xác nhận';
                break;
            case 2:
                $name = 'Đã đặt';
                break;
            case 3:
                $name = 'Đang đợi kết quả';
                break;
            case 4:
                $name = 'Đã hoàn thành';
                break;
            default :
                $name = 'Chưa xác định';
                break;
        }
        return $name;
    }

}
