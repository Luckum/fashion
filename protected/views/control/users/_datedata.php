<?php

if ($userType == User::SELLER) {
    echo Yii::t('base', 'Total Revenue') . ':&nbsp;' . round($total, 2);
} else {
    echo Yii::t('base', 'Total Expense') . ':&nbsp;' . round($total, 2);
}