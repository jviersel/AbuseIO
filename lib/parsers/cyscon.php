<?php
function parse_cyscon($message) {
    $source = 'CSIRT';
    $type   = 'ABUSE';

    // Read and parse report which is located in the attachment
    if(!empty($message['attachments'][1]) && $message['attachments'][1] = "SPAMVERTIZED-report.txt") {
        $report = file_get_contents($message['store'] ."/1/". $message['attachments'][1]);
        $class  = 'Compromised website';
        $type   = 'ABUSE';
    } else {
        logger(LOG_ERR, __FUNCTION__ . " Unable to detect report type in message from ${source} subject ${message['subject']}");
        return false;
    }

    preg_match_all('/([\w\-]+): (.*)[ ]*\r\n?\r?\n/',$report,$regs);
    $fields = array_combine($regs[1],$regs[2]);

    if (empty($fields['signature']) || empty($fields['ip']) || empty($fields['domain']) || empty($fields['last_seen']) || empty($fields['uri']) ) {
        logger(LOG_ERR, __FUNCTION__ . " Unable to select correct fields in message from ${source} subject ${message['subject']}");
        return false;
    } else {
        $fields['uri'] = str_replace("http://".$fields['domain'], "", $fields['uri']);
    }

    $outReport = array(
                        'source'        => $source,
                        'ip'            => $fields['ip'],
                        'domain'        => $fields['domain'],
                        'uri'           => $fields['uri'],
                        'class'         => $class,
                        'type'          => $type,
                        'timestamp'     => strtotime($fields['last_seen']),
                        'information'   => $fields
                      );

    $reportID = reportAdd($outReport);
    if (!$reportID) return false;
    if(KEEP_EVIDENCE == true && $reportID !== true) { evidenceLink($message['evidenceid'], $reportID); }

    logger(LOG_INFO, __FUNCTION__ . " Completed message from ${source} subject ${message['subject']}");
    return true;
}
?>