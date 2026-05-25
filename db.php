<?php
function trace_event($a, $b = null) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if ($b === null) {
        $message = $a;
        global $conn;
    } else {
        $conn = $a;
        $message = $b;
    }

    if (!$conn) return;

    $appname = basename($_SERVER['PHP_SELF']);
    $user = $_SESSION['username'] ?? 'guest';
    $ip = $_SERVER['REMOTE_ADDR'] ?? '-';

    $message = is_string($message) ? $message : json_encode($message);

    $logText = "USER=$user | IP=$ip | EVENT=$message";

    $stmt = $conn->prepare("INSERT INTO tracelog(appname, log) VALUES (?, ?)");
    $stmt->bind_param("ss", $appname, $logText);
    $stmt->execute();
}

function db_query($conn, $sql) {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $appname = basename($_SERVER['PHP_SELF']);
    $user = $_SESSION['username'] ?? 'guest';
    $ip = $_SERVER['REMOTE_ADDR'] ?? '-';

    $start = microtime(true);
    $result = mysqli_query($conn, $sql);
    $time = round((microtime(true) - $start) * 1000, 2);

    $status = $result ? 'SUCCESS' : 'FAILED';
    $error  = $result ? '' : mysqli_error($conn);

    if (stripos($sql, 'tracelog') === false) {
        $logText = "USER=$user | IP=$ip | STATUS=$status | TIME={$time}ms | SQL=$sql";
        if ($error) $logText .= " | ERROR=$error";

        $stmt = $conn->prepare("INSERT INTO tracelog(appname, log) VALUES (?, ?)");
        $stmt->bind_param("ss", $appname, $logText);
        $stmt->execute();
    }

    return $result;
}
