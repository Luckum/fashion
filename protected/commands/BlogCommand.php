<?php

class BlogCommand extends CConsoleCommand {

    public function run($args) {
        $idsForPublishing = array();
        $rows = BlogPost::model()->findAll(
            "status = :draft_status AND
                publish_at IS NOT NULL AND
                publish_at != '0000-00-00 00:00:00'",
            array(
                ':draft_status' => BlogPost::POST_STATUS_DRAFTED
            )
        );

        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $dt = new DateTime();
                if (isset($row['timezone']) && !empty($row['timezone'])) {
                    $dt->setTimezone(new DateTimeZone($row['timezone']));
                }
                $currDate = $dt->format('Y-m-d H:i:s');
                if ($row['publish_at'] <= $currDate) {
                    $idsForPublishing[] = $row['id'];
                }
            }
        }

        $rowsUpdated = count($idsForPublishing);
        if (!empty($rowsUpdated)) {
            $rowsUpdated = BlogPost::model()->updateAll(
                array(
                    "status" => BlogPost::POST_STATUS_PUBLISHED,
                    'create_time' => (new CDbExpression('publish_at')),
                    'publish_at' => null,
                ),
                "id IN(".implode(',', $idsForPublishing).")"
            );
        }
        echo "$rowsUpdated rows have been updated";
    }
}