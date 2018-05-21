<?php

class VcDebug {

    private $markers = array();
    /**
     * Auto-start and stop timer.
     *
     * @var    boolean
     */
    private $auto = FALSE;

    /**
     * Max marker name length for non-html output.
     *
     * @var    integer
     */
    private $maxStringLength = 0;

    public function __construct($auto = false) {
        $this->auto = $auto;
        if ($this->auto) {
            $this->start();
        }
    }

    public function __destruct() {
    }

    /**
     * Set "Start" marker.
     *
     * @see    setMarker(), stop()
     */
    public function start() {
        $this->setMarker('Start');
    }

    /**
     * Set "Stop" marker.
     *
     * @see    setMarker(), start()
     */
    public function stop() {
        $this->setMarker('Stop');
    }

    /**
     * Set marker.
     *
     * @param  string  $name Name of the marker to be set.
     * @see    start(), stop()
     */
    public function setMarker($name) {
        $this->markers[$name] = $this->_getMicrotime();
    }

    /**
     * Returns the time elapsed betweens two markers.
     *
     * @param  string  $start        start marker, defaults to "Start"
     * @param  string  $end          end marker, defaults to "Stop"
     * @return double  $time_elapsed time elapsed between $start and $end
     * @access public
     */
    public function timeElapsed($start = 'Start', $end = 'Stop') {
        if ($end == 'Stop' && !isset($this->markers['Stop'])) {
            $this->markers['Stop'] = $this->_getMicrotime();
        }
        $end = isset($this->markers[$end]) ? $this->markers[$end] : 0;
        $start = isset($this->markers[$start]) ? $this->markers[$start] : 0;
        if (extension_loaded('bcmath')) {
            return bcsub($end, $start, 6);
        } else {
            return $end - $start;
        }
    }

    /**
     * Returns profiling information.
     *
     * $profiling[x]['name']  = name of marker x
     * $profiling[x]['time']  = time index of marker x
     * $profiling[x]['diff']  = execution time from marker x-1 to this marker x
     * $profiling[x]['total'] = total execution time up to marker x
     *
     * @return array
     * @access public
     */
    public function getProfiling() {
        $i = $total = 0;
        $result = array();
        $temp = reset($this->markers);
        $this->maxStringLength = 0;
        foreach ($this->markers as $marker => $time) {
            if (extension_loaded('bcmath')) {
                $diff = bcsub($time, $temp, 6);
                $total = bcadd($total, $diff, 6);
            } else {
                $diff = $time - $temp;
                $total = $total + $diff;
            }
            $result[$i]['name'] = $marker;
            $result[$i]['time'] = $time;
            $result[$i]['diff'] = $diff;
            $result[$i]['total'] = $total;
            $this->maxStringLength = (strlen($marker) > $this->maxStringLength ? strlen($marker) + 1 : $this->maxStringLength);
            $temp = $time;
            $i++;
        }
        $result[0]['diff'] = '-';
        $result[0]['total'] = '-';
        $this->maxStringLength = (strlen('total') > $this->maxStringLength ? strlen('total') : $this->maxStringLength);
        $this->maxStringLength += 2;
        return $result;
    }

    /**
     * Return formatted profiling information.
     *
     * @param  boolean  $showTotal   Optionnaly includes total in output, default no
     * @param  string  $format   output format (auto, plain or html), default auto
     * @return string
     * @see    getProfiling()
     * @access public
     */
    public function getOutput($showTotal = FALSE, $format = 'auto') {
        if ($format == 'auto') {
            if (function_exists('version_compare') && version_compare(phpversion(), '4.1', 'ge')) {
                $format = isset($_SERVER['SERVER_PROTOCOL']) ? 'html' : 'plain';
            } else {
                global $HTTP_SERVER_VARS;
                $format = isset($HTTP_SERVER_VARS['SERVER_PROTOCOL']) ? 'html' : 'plain';
            }
        }
        $total = $this->TimeElapsed();
        $result = $this->getProfiling();
        $dashes = '';
        if ($format == 'html') {
            $out = '<table border="1">' . "\n";
            $out .= '<tr><td>&nbsp;</td><td align="center"><b>time index</b></td><td align="center"><b>ex time</b></td><td align="center"><b>%</b></td>' . ($showTotal ? '<td align="center"><b>elapsed</b></td><td align="center"><b>%</b></td>' : '') . "</tr>\n";
        } else {
            $dashes = $out = str_pad("\n", $this->maxStringLength + ($showTotal ? 70 : 45), '-', STR_PAD_LEFT);
            $out .= str_pad('marker', $this->maxStringLength) . str_pad("time index", 22) . str_pad("ex time", 16) . str_pad("perct ", 8) . ($showTotal ? ' ' . str_pad("elapsed", 16) . "perct" : '') . "\n" . $dashes;
        }
        foreach ($result as $k => $v) {
            $perc = (($v['diff'] * 100) / $total);
            $tperc = (($v['total'] * 100) / $total);
            if ($format == 'html') {
                $out .= "<tr><td><b>" . $v['name'] . "</b></td><td>" . $v['time'] . "</td><td>" . $v['diff'] . "</td><td align=\"right\">" . number_format($perc, 2, '.', '') . "%</td>" . ($showTotal ? "<td>" . $v['total'] . "</td><td align=\"right\">" . number_format($tperc, 2, '.', '') . "%</td>" : '') . "</tr>\n";
            } else {
                $out .= str_pad($v['name'], $this->maxStringLength, ' ') . str_pad($v['time'], 22) . str_pad($v['diff'], 14) . str_pad(number_format($perc, 2, '.', '') . "%", 8, ' ', STR_PAD_LEFT) . ($showTotal ? '   ' . str_pad($v['total'], 14) . str_pad(number_format($tperc, 2, '.', '') . "%", 8, ' ', STR_PAD_LEFT) : '') . "\n";
            }
            $out .= $dashes;
        }
        if ($format == 'html') {
            $out .= "<tr style='background: silver;'><td><b>total</b></td><td>-</td><td>${total}</td><td>100.00%</td>" . ($showTotal ? "<td>-</td><td>-</td>" : "") . "</tr>\n";
            $out .= "</table>\n";
        } else {
            $out .= str_pad('total', $this->maxStringLength);
            $out .= str_pad('-', 22);
            $out .= str_pad($total, 15);
            $out .= "100.00%\n";
            $out .= $dashes;
        }
        echo "\n";
        echo '###### Debug Info ######';
        echo "\n";
        echo 'PHP Version: ' . phpversion();
        echo "\n";
        echo 'Memory Usage: ' . round(memory_get_usage() / 1024 / 1024, 3) . 'm';
        echo "\n";
        echo 'Memory Peak Usage: ' . round(memory_get_peak_usage() / 1024 / 1024, 3) . 'm';
        echo "\n";
        return $out;
    }

    /**
     * Prints the information returned by getOutput().
     *
     * @param  boolean  $showTotal   Optionnaly includes total in output, default no
     * @param  string  $format   output format (auto, plain or html), default auto
     * @see    getOutput()
     * @access public
     */
    public function display($showTotal = FALSE, $format = 'auto') {
        print $this->getOutput($showTotal, $format);
    }

    /**
     * Wrapper for microtime().
     *
     * @return float
     */
    private function _getMicrotime() {
        $microtime = explode(' ', microtime());
        return $microtime[1] . substr($microtime[0], 1);
    }

    /**
     * @var string
     */
    protected static $_sapi = null;

    /**
     * Get the current value of the debug output environment.
     * This defaults to the value of PHP_SAPI.
     *
     * @return string;
     */
    public static function getSapi() {
        if (self::$_sapi === null) {
            self::$_sapi = PHP_SAPI;
        }
        return self::$_sapi;
    }

    /**
     * Set the debug ouput environment.
     * Setting a value of null causes Zend_Debug to use PHP_SAPI.
     *
     * @param string $sapi
     * @return void;
     */
    public static function setSapi($sapi) {
        self::$_sapi = $sapi;
    }

    /**
     * Debug helper function.  This is a wrapper for var_dump() that adds
     * the <pre /> tags, cleans up newlines and indents, and runs
     * htmlentities() before output.
     *
     * @param  mixed  $var   The variable to dump.
     * @param  string $label OPTIONAL Label to prepend to output.
     * @param  bool   $echo  OPTIONAL Echo output if true.
     * @return string
     */
    public static function dump($var, $label = null, $echo = true) {
        // format the label
        $label = ($label === null) ? '' : rtrim($label) . ' ';

        // var_dump the variable into a buffer and keep the output
        ob_start();
        var_dump($var);
        $output = ob_get_clean();

        // neaten the newlines and indents
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        if (self::getSapi() == 'cli') {
            $output = PHP_EOL . $label . PHP_EOL . $output . PHP_EOL;
        } else {
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }

        if ($echo) {
            echo ($output);
        }
        return $output;
    }
}
?>