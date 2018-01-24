<?php

return array(
    'registration' => 'Registration',          // ++
    'submit_item' => 'Item was submitted',     // ++
    'accept_item' => 'Item was accepted',      // ++
    'reject_item' => 'Item was rejected',      // ++
    'edit_item' => 'Edit item',
    'offer_made' => 'Price offer was made',    // ++
    'sold_item' => 'Item is sold',             // ++
    'order_confirmation' => 'Order confirmation',
    'order_complete' => 'Order complete',      // ++
    'shipping_confirmation' => 'Shipping confirmation', // ++
    'shipping_confirmation_without_tracking' => 'Shipping confirmation without tracking',
    'seller_shipping_info' => 'Seller shipping info',
    'feedback' => 'Feedback',
    'new_complaint' => 'New complaint',        // ++
    'price_alert_notification' => 'Price alert notification', // ++
    'comment_received' => 'Comment received', // ++
    'forgot_password' => 'Forgot password',    // ++
    'product_require_confirm' => 'Require confirm', // ++
    'offer_accepted' => 'Offer was accepted',
    'offer_rejected' => 'Offer was rejected'
);

// Из технического задания _______________________
//
// 1 -------------- a. Регистрация нового пользователя - 'registration'
// 2 -------------- b. Подтверждение размещения товара - 'submit_item'
// 3 -------------- c. Размещение товара разрешено - 'accept_item'
// 4 -------------- d. В размещении товара отказано - 'reject item'
// 5 -------------- e. Размещенный товар требует редактирования - 'edit_item'
// 6 -------------- f. Новое предложение получено от потенциального покупателя - 'offer_made'
// 7 -------------- g. Товар куплен (оплата заказа завершена) с купоном в приложении - 'sold_item'
// 8 -------------- h. Заказ размещен со счетом в приложении - 'order_confirmation'
// 9 -------------- i. Товар отправлен с трекинговым номером - 'shipping_confirmation'
// 10 -------------- j. Товар отправлен c вложенным ваучером - 'seller_shipping_info'
//11 -------------- k. Заказ завершен (все товары отправлены) - 'order_complete'
//12 -------------- l. Отзыв: оцените продавца (после того, как покупатель получил заказ и если все в порядке) - 'feedback'
//13 -------------- m. Новая жалоба получена (отправляется администратору) - 'new_complaint'
//14 -------------- n. Оповещение о снижении цены на товар из «моего списка», о добавлении новых товаров,
//                   подходящих по указанным размерам - 'price_alert_notification'
//15 -------------- o. Добавлены комментарии со ссылкой для ответа. - 'comment_received'
//16 -------------- Уведомление администратора о том, что есть товар, ожидающий подтверждения - 'product_require_confirm'
//17 --------------- Уведомление покупателя о том что его оффер был принят
//18 --------------- Уведомление покупателя о том, что его оффер был отклонен

// Дополнительные _____________________________
// 15 ------------- Восстановление пароля - 'forgot_password'