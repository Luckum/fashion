<!--Вывод таблицы соответствия размеров в разных странах (временно задано хардкодом, исправить в будущем)-->

<div id="szchart-page-wrapper">

    <!--Заголовок-->
    <h1><?=Yii::t('base', 'size chart')?></h1>

    <!--Таблица соответствия размеров-->
    <table>
        <caption>
            <span><?=CHtml::encode($cat_name)?></span>&nbsp;
            <span>(<?=CHtml::encode($sizes[0])?>)</span>
        </caption>
        <?php if (count($sizes[1])): ?>
            <?php
                $head = $body = '';
                foreach ($sizes[1] as $k => $v) {
                    $head .= '<th>' . CHtml::encode($k) . '</th>';
                    $body .= '<td>';
                    foreach ($v as $item) {
                        $body .= CHtml::encode($item[1]) . '<br/>';
                    }
                    $body .= '</td>';
                }
                $content = '<tr>' . CHtml::encode($head) . '</tr>'.
                           '<tr>' . CHtml::encode($body) . '</tr>';
                echo $content;
            ?>
        <?php else: ?>
            <tr>
                <td><?=Yii::t('base', 'There is no chart for this product.')?></td>
            </tr>
        <?php endif; ?>
    </table>

</div>