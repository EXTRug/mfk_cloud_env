<?php
namespace OCA\MFKDashboard\Utils;

class DesignHelper {
    public static function getStatusColor(string $status):string {
        if($status == "active"){
            return "#1dbd1d";
        }
        if($status == "archieved"){
            return "#8C9499";
        }
        if($status == "In preparation" || $status == "In revision"){
            return "#2d73e1";
        }
        return "#FFF";
    }
}