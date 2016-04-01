<?php


namespace DuplicatesSearch\Client\Processing;

class Processing
{
    /*
    * @param   int     $done   how many items are completed
    * @param   int     $total  how many items are to be done total
    * @param   int     $size   optional size of the status bar
    * @return  void
    *
    */

    function calculateStatusBar($done, $total, $size = 30)
    {
        static $start_time;

        // if we go over our bound, just ignore it
        if ($done > $total) return false;

        if (empty($start_time)) $start_time = time();
        $now = time();

        $percent = (double)($done / $total);

        $bar = floor($percent * $size);

        $status_bar = "\r[";
        $status_bar .= str_repeat("=", $bar);
        if ($bar < $size) {
            $status_bar .= ">";
            $status_bar .= str_repeat(" ", $size - $bar);
        } else {
            $status_bar .= "=";
        }

        $display = number_format($percent * 100, 0);

        $status_bar .= "] $display%  $done/$total";

        $rate = ($now - $start_time) / $done;
        $left = $total - $done;
        $eta = round($rate * $left, 2);

        $elapsed = $now - $start_time;

        $status_bar .= " remaining: " . number_format($eta) . " sec.  elapsed: " . number_format($elapsed) . " sec.";

        // when done, send a newline
        /*if($done == $total) {
            $status_bar .= "\n";
        }*/

        return $status_bar;
    }
}

?>