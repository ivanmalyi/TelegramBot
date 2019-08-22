<?php


use Phinx\Seed\AbstractSeed;

class StagesMessages extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'stage' => 2,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Рад знакомству {fio}, используя мой замечательный функционал ты можешь проводить платежи.".
                    "Но сначало нужно, показать мне свой номер телефона"
            ],
            [
                'stage' => 2,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Радий знайомству {fio}, використовуючи мій чудовий функціонал ти можеш проводити платежі." .
                    "Але спочатку потрібно, показати мені свій номер телефону"
            ],
            [
                'stage' => 2,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "I\'m glad to meet you {fio}, using my wonderful functionality you can make payments".
                    "But first need to show me your phone number"
            ],
            [
                'stage' => 2,
                'sub_stage' => 1,
                'localization' => 'RU',
                'message' => "Нажми на кнопку  Меню "
            ],
            [
                'stage' => 2,
                'sub_stage' => 1,
                'localization' => 'UA',
                'message' => "Натисни на кнопку  Меню "
            ],
            [
                'stage' => 2,
                'sub_stage' => 1,
                'localization' => 'EN', 
                'message' => "Сlick on the Menu button to make a new payment"
            ],
            [
                'stage' => 3,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "{fio} приветствую, нажми на кнопку Меню "
            ],
            [
                'stage' => 3,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "{fio} вітаю, натисни на кнопку Меню "
            ],
            [
                'stage' => 3,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Welcome back {fio}, click on the Menu button to make a new payment"
            ],
            [
                'stage' => 4,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Выберите раздел"
            ],
            [
                'stage' => 4,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Виберіть розділ"
            ],
            [
                'stage' => 4,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Select a section"
            ],
            [
                'stage' => 5,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Выбирите оператора"
            ],
            [
                'stage' => 5,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Виберіть оператора"
            ],
            [
                'stage' => 5,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Select an operator"
            ],
            [
                'stage' => 6,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Выбирите сервис"
            ],
            [
                'stage' => 6,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Виберіть розділ"
            ],
            [
                'stage' => 6,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Select a service"
            ],
            [
                'stage' => 7,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Выбирите айтем"
            ],
            [
                'stage' => 7,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Виберіть айтем"
            ],
            [
                'stage' => 7,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Select a item"
            ],
            [
                'stage' => 8,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Аккаунт введен не корректно"
            ],
            [
                'stage' => 8,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Аккаунт введено не корректно"
            ],
            [
                'stage' => 8,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Account entered incorrectly"
            ],
            [
                'stage' => 9,
                'sub_stage' => -40,
                'localization' => 'RU',
                'message' => "Ошибка провайдера"
            ],
            [
                'stage' => 9,
                'sub_stage' => -40,
                'localization' => 'UA',
                'message' => "Помилка провайдера"
            ],
            [
                'stage' => 9,
                'sub_stage' => -40,
                'localization' => 'EN',
                'message' => "Provider error"
            ],
            [
                'stage' => 9,
                'sub_stage' => -35,
                'localization' => 'RU',
                'message' => "Аккаунт не найден"
            ],
            [
                'stage' => 9,
                'sub_stage' => -35,
                'localization' => 'UA',
                'message' => "Аккаунт не знайдено"
            ],
            [
                'stage' => 9,
                'sub_stage' => -35,
                'localization' => 'EN',
                'message' => "Account not found"
            ],
            [
                'stage' => 9,
                'sub_stage' => -34,
                'localization' => 'RU',
                'message' => "Аккаунт забанен"
            ],
            [
                'stage' => 9,
                'sub_stage' => -34,
                'localization' => 'UA',
                'message' => "Аккаунт забанено"
            ],
            [
                'stage' => 9,
                'sub_stage' => -34,
                'localization' => 'EN',
                'message' => "Account banned"
            ],
            [
                'stage' => 9,
                'sub_stage' => -41,
                'localization' => 'RU',
                'message' => "Техническая ошибка, попробуйте позже"
            ],
            [
                'stage' => 9,
                'sub_stage' => -41,
                'localization' => 'UA',
                'message' => "Технічна помилка, спробуйте пізніше"
            ],
            [
                'stage' => 9,
                'sub_stage' => -41,
                'localization' => 'EN',
                'message' => "Technical error, try again later"
            ],
            [
                'stage' => 9,
                'sub_stage' => -45,
                'localization' => 'RU',
                'message' => "Техническая ошибка, попробуйте позже"
            ],
            [
                'stage' => 9,
                'sub_stage' => -45,
                'localization' => 'UA',
                'message' => "Технічна помилка, спробуйте пізніше"
            ],
            [
                'stage' => 9,
                'sub_stage' => -45,
                'localization' => 'EN',
                'message' => "Technical error, try again later"
            ],
            [
                'stage' => 9,
                'sub_stage' => -50,
                'localization' => 'RU',
                'message' => "Сумма к оплате {amount}"
            ],
            [
                'stage' => 9,
                'sub_stage' => -50,
                'localization' => 'UA',
                'message' => "Сума до сплати {amount}"
            ],
            [
                'stage' => 9,
                'sub_stage' => -50,
                'localization' => 'EN',
                'message' => "Payment amount {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Комиссия:"
            ],
            [
                'stage' => 10,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Комісія:"
            ],
            [
                'stage' => 10,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Commission:"
            ],
            [
                'stage' => 10,
                'sub_stage' => 1,
                'localization' => 'RU',
                'message' => "до {to_amount} грн = {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 1,
                'localization' => 'UA',
                'message' => "до {to_amount} грн = {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 1,
                'localization' => 'EN',
                'message' => "to {to_amount} uah = {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 2,
                'localization' => 'RU',
                'message' => "от {from_amount} грн = {amount}",

            ],
            [
                'stage' => 10,
                'sub_stage' => 2,
                'localization' => 'UA',
                'message' => "від {from_amount} грн = {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 2,
                'localization' => 'EN',
                'message' => "from {from_amount} uah = {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 3,
                'localization' => 'RU',
                'message' => "от {from_amount} грн до {to_amount} грн = {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 3,
                'localization' => 'UA',
                'message' => "від {from_amount} грн до {to_amount} грн = {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 3,
                'localization' => 'EN',
                'message' => "from {from_amount} uah to {to_amount} uah = {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 4,
                'localization' => 'RU',
                'message' => ", Минимум {min_amount} грн"
            ],
            [
                'stage' => 10,
                'sub_stage' => 4,
                'localization' => 'UA',
                'message' => ", Мінімум {min_amount} грн"
            ],
            [
                'stage' => 10,
                'sub_stage' => 4,
                'localization' => 'EN',
                'message' => ", Minimum {min_amount} uah"
            ],
            [
                'stage' => 10,
                'sub_stage' => 5,
                'localization' => 'RU',
                'message' => ", Максимум {max_amount} грн"
            ],
            [
                'stage' => 10,
                'sub_stage' => 5,
                'localization' => 'UA',
                'message' => ", Максимум {max_amount} грн"
            ],
            [
                'stage' => 10,
                'sub_stage' => 5,
                'localization' => 'EN',
                'message' => ", Maximum {max_amount} uah"
            ],
            [
                'stage' => 10,
                'sub_stage' => 6,
                'localization' => 'RU',
                'message' => "на любую сумму = {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 6,
                'localization' => 'UA',
                'message' => "на будь-яку суму = {amount}"
            ],
            [
                'stage' => 10,
                'sub_stage' => 6,
                'localization' => 'EN',
                'message' => "for any amount = {amount}"
            ],
            [
                'stage' => 11,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Введите сумму платежа"
            ],
            [
                'stage' => 11,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Введіть суму платежу"
            ],
            [
                'stage' => 11,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Enter payment amount"
            ],
            [
                'stage' => 11,
                'sub_stage' => 3,
                'localization' => 'RU',
                'message' => "Минимальная сумма оплаты {amount}"
            ],
            [
                'stage' => 11,
                'sub_stage' => 3,
                'localization' => 'UA',
                'message' => "Мінімальна сума оплати {amount}"
            ],
            [
                'stage' => 11,
                'sub_stage' => 3,
                'localization' => 'EN',
                'message' => "Minimum payment amount is {amount}"
            ],
            [
                'stage' => 11,
                'sub_stage' => 4,
                'localization' => 'RU',
                'message' => "Максимальная сумма оплаты {amount}"
            ],
            [
                'stage' => 11,
                'sub_stage' => 4,
                'localization' => 'UA',
                'message' => "Максимальна сума оплати {amount}"
            ],
            [
                'stage' => 11,
                'sub_stage' => 4,
                'localization' => 'EN',
                'message' => "Maximum payment amount is {amount}"
            ],
            [
                'stage' => 11,
                'sub_stage' => 5,
                'localization' => 'RU',
                'message' => "Сумма введена не корректно"
            ],
            [
                'stage' => 11,
                'sub_stage' => 5,
                'localization' => 'UA',
                'message' => "Сума введена некоректно"
            ],
            [
                'stage' => 11,
                'sub_stage' => 5,
                'localization' => 'EN',
                'message' => "Amount was entered incorrectly"
            ],
            [
                'stage' => 12,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Комиссия {commission} грн"
            ],
            [
                'stage' => 12,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Комиссия {commission} грн"
            ],
            [
                'stage' => 12,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Commission {commission} uah"
            ],
            [
                'stage' => 13,
                'sub_stage' => -10,
                'localization' => 'RU',
                'message' => "Данные карты были введены некорректно"
            ],
            [
                'stage' => 13,
                'sub_stage' => -10,
                'localization' => 'UA',
                'message' => "Дані карти були введені некоректно"
            ],
            [
                'stage' => 13,
                'sub_stage' => -10,
                'localization' => 'EN',
                'message' => "Card data has been inputted wrong"
            ],
            [
                'stage' => 13,
                'sub_stage' => 1,
                'localization' => 'RU',
                'message' => "Аккаунт: {account}\nСумма пополнения: {amount}\nСумма списания: {total_amount}"
            ],
            [
                'stage' => 13,
                'sub_stage' => 1,
                'localization' => 'UA',
                'message' => "Аккаунт: {account}\nСума поповнення: {amount}\nСума списання: {total_amount}"
            ],
            [
                'stage' => 13,
                'sub_stage' => 1,
                'localization' => 'EN',
                'message' => "Account: {account}\nPay amount: {amount}\nAmount of debit: {total_amount}"
            ],
            [
                'stage' => 13,
                'sub_stage' => 2,
                'localization' => 'RU',
                'message' => "Списываю средства по чеку {billingChequeId} на сумму {amount} грн"
            ],
            [
                'stage' => 13,
                'sub_stage' => 2,
                'localization' => 'UA',
                'message' => "Списую кошти по чеку {billingChequeId} на суму {amount} грн"
            ],
            [
                'stage' => 13,
                'sub_stage' => 2,
                'localization' => 'EN',
                'message' => "Freeze the funds by cheque {billingChequeId} for the amount {amount} uah"
            ],
            [
                'stage' => 14,
                'sub_stage' => 1,
                'localization' => 'RU',
                'message' => "Средства по чеку {billingChequeId} успешно заморожены, провожу оплату"
            ],
            [
                'stage' => 14,
                'sub_stage' => 1,
                'localization' => 'UA',
                'message' => "Кошти по чеку {billingChequeId} успішно заморожені, проводжу оплату"
            ],
            [
                'stage' => 14,
                'sub_stage' => 1,
                'localization' => 'EN',
                'message' => "Funds successfully frozen by the cheque {billingChequeId}, start of payment"
            ],
            [
                'stage' => 14,
                'sub_stage' => 2,
                'localization' => 'RU',
                'message' => "Пополнение по чеку {billingChequeId} успешно, подтверждаю списание замороженных средств"
            ],
            [
                'stage' => 14,
                'sub_stage' => 2,
                'localization' => 'UA',
                'message' => "Поповнення по чеку {billingChequeId} успішно, підтверджую списання заморожених коштів"
            ],
            [
                'stage' => 14,
                'sub_stage' => 2,
                'localization' => 'EN',
                'message' => "Payment is successful by the cheque {billingChequeId}, start confirming frozen funds"
            ],
            [
                'stage' => 14,
                'sub_stage' => 3,
                'localization' => 'RU',
                'message' => "Необходимо подтвердить списание средств по чеку {billingChequeId}"
            ],
            [
                'stage' => 14,
                'sub_stage' => 3,
                'localization' => 'UA',
                'message' => "Необхідно підтвердити списання коштів по чеку {billingChequeId}"
            ],
            [
                'stage' => 14,
                'sub_stage' => 3,
                'localization' => 'EN',
                'message' => "You need to confirm the debit by the cheque {billingChequeId}"
            ],
            [
                'stage' => 14,
                'sub_stage' => 4,
                'localization' => 'RU',
                'message' => "Ошибка списания средств по чеку {billingChequeId}"
            ],
            [
                'stage' => 14,
                'sub_stage' => 4,
                'localization' => 'UA',
                'message' => "Помилка списання коштів по чеку {billingChequeId}"
            ],
            [
                'stage' => 14,
                'sub_stage' => 4,
                'localization' => 'EN',
                'message' => "Money debit error by the cheque {billingChequeId}"
            ],
            [
                'stage' => 14,
                'sub_stage' => 5,
                'localization' => 'RU',
                'message' => "Неизвестный статус списания средств по чеку {billingChequeId}. Произвожу дополнительную проверку"
            ],
            [
                'stage' => 14,
                'sub_stage' => 5,
                'localization' => 'UA',
                'message' => "Невідомий статус списання коштів по чеку {billingChequeId}. Роблю додаткову перевірку"
            ],
            [
                'stage' => 14,
                'sub_stage' => 5,
                'localization' => 'EN',
                'message' => "Unknown debit status by the cheque {billingChequeId}. Produce additional verification"
            ],
            [
                'stage' => 14,
                'sub_stage' => 6,
                'localization' => 'RU',
                'message' => "Неизвестный статус платежа по чеку {billingChequeId}. Произвожу дополнительную проверку"
            ],
            [
                'stage' => 14,
                'sub_stage' => 6,
                'localization' => 'UA',
                'message' => "Невідомий статус платежу по чеку {billingChequeId}. Роблю додаткову перевірку"
            ],
            [
                'stage' => 14,
                'sub_stage' => 6,
                'localization' => 'EN',
                'message' => "Unknown payment status by the cheque {billingChequeId}. Produce additional verification"
            ],
            [
                'stage' => 14,
                'sub_stage' => 7,
                'localization' => 'RU',
                'message' => "Ожидаю получение результата 3DS от банка по чеку {billingChequeId}"
            ],
            [
                'stage' => 14,
                'sub_stage' => 7,
                'localization' => 'UA',
                'message' => "Очікую отримання результату 3DS від банку по чеку {billingChequeId}"
            ],
            [
                'stage' => 14,
                'sub_stage' => 7,
                'localization' => 'EN',
                'message' => "I expect the result of 3DS from the bank by the cheque {billingChequeId}"
            ],
            [
                'stage' => 15,
                'sub_stage' => 1,
                'localization' => 'RU',
                'message' => "Платеж отменен, замороженные средства возвращены на карту по чеку {billingChequeId}"
            ],
            [
                'stage' => 15,
                'sub_stage' => 1,
                'localization' => 'UA',
                'message' => "Платіж скасовано, заморожені кошти повернуті на карту по чеку {billingChequeId}"
            ],
            [
                'stage' => 15,
                'sub_stage' => 1,
                'localization' => 'EN',
                'message' => "Payment had been canceled, frozen funds have been returned to the card by the cheque {billingChequeId}"
            ],
            [
                'stage' => 15,
                'sub_stage' => 2,
                'localization' => 'RU',
                'message' => "Платеж отменен по чеку {billingChequeId}, возвращаю замороженные средства на карту..."
            ],
            [
                'stage' => 15,
                'sub_stage' => 2,
                'localization' => 'UA',
                'message' => "Платіж скасовано по чеку {billingChequeId}, заморожені кошти повертаю на карту..."
            ],
            [
                'stage' => 15,
                'sub_stage' => 2,
                'localization' => 'EN',
                'message' => "Payment has been canceled by the cheque {billingChequeId}, frozen funds are being returned to the card..."
            ],
            [
                'stage' => 15,
                'sub_stage' => 3,
                'localization' => 'RU',
                'message' => "Средства успешно списано по чеку {billingChequeId}, процедура оплаты прошла успешно!"
            ],
            [
                'stage' => 15,
                'sub_stage' => 3,
                'localization' => 'UA',
                'message' => "Кошти успішно списано по чеку {billingChequeId}, процедура оплати пройшла успішно!"
            ],
            [
                'stage' => 15,
                'sub_stage' => 3,
                'localization' => 'EN',
                'message' => "Funds successfully written off by check {billingChequeId}, the payment procedure was successful!"
            ],
            [
                'stage' => 15,
                'sub_stage' => 4,
                'localization' => 'RU',
                'message' => "Ошибка подтверждения списания средств по чеку {billingChequeId}, отменяю платеж..."
            ],
            [
                'stage' => 15,
                'sub_stage' => 4,
                'localization' => 'UA',
                'message' => "Помилка підтвердження списання коштів по чеку {billingChequeId}, скасовую платіж..."
            ],
            [
                'stage' => 15,
                'sub_stage' => 4,
                'localization' => 'EN',
                'message' => "Error confirming charge by the cheque {billingChequeId}, payment is being canceled..."
            ],
            [
                'stage' => 16,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "ПТКС {PointId}\nКВИТАНЦИЯ на перевод средств № {BillingChequeId}\nДата и время осуществлении операции {CratedAt}\n".
                    "ООО 'ФК СИСТЕМА', адрес г.. Днепр, ул. Мечникова 12/10\n".
                    "Код ЕГРПОУ: {RecipientCode} тел. 3750, \n{PaymentSystem}\nуникальний код транзакции {BillingChequeId}\n".
                    "ID транзакции в ПС: {PsId}\nПЛАТЕЛЬЩИК: {Account}\n{ChequePrint}Назначение платежа: {PaymentPurpose}\n{RecipientTemplate}\n".
                    "Наименование услуги: Платежное поручение\nСумма перевода: {PayAmount} UAH\n".
                    "Сумма комиссионного вознаграждения: {Commission} UAH\nСумма: {Amount} UAH\n"
            ],
            [
                'stage' => 16,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "ПТКС {PointId}\nКВИТАНЦІЯ на переказ коштів №{BillingChequeId}\nДата та час здійснення операції: {CratedAt}\n".
                    "ТОВ 'ФК СИСТЕМА', адреса м. Дніпро, вул. Мечнікова 12/10\n".
                    "Код за ЕДРПОУ: {RecipientCode} тел. 3750,\n{PaymentSystem}\nунікальний код транзакції: {BillingChequeId}\n".
                    "ID транзакції в ПС: {PsId}\nПЛАТНИК: {Account}\n{ChequePrint}Призначення платежу: {PaymentPurpose}\n{RecipientTemplate}\n".
                    "Найменування послуги: Платіжне доручення\nСума переказу: {PayAmount} UAH\n".
                    "Сума комісійної внагороди: {Commission} UAH\nСума: {Amount} UAH\n"
            ],
            [
                'stage' => 16,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "PTX {PointId} CHECK for funds transfer № {BillingChequeId}\nDate and time of the operation {CratedAt}\n".
                    "FC SYSTEM LLC, address of the city of Dnipro, st. Mechnikova 12/10\n".
                    "EDRPOU code: {RecipientCode} tel. 3750,\n{PaymentSystem}\nUnique transaction code {BillingChequeId}\n".
                    "Transaction ID in PS: {PsId}\nPAYER: {Account}\n{ChequePrint}Payment destination: {PaymentPurpose}\n{RecipientTemplate}\n".
                    "Service name: Payment order\nThe amount of transfer: {PayAmount} UAH\n".
                    "Amount of commission award: {Commission} UAH\nAmount: {Amount} UAH\n"
            ],
            [
                'stage' => 16,
                'sub_stage' => 1,
                'localization' => 'RU',
                'message' => "Спасибо, оставайтесь с нами"
            ],
            [
                'stage' => 16,
                'sub_stage' => 1,
                'localization' => 'UA',
                'message' => "Дякуємо, залишайтеся з нами"
            ],
            [
                'stage' => 16,
                'sub_stage' => 1,
                'localization' => 'EN',
                'message' => "Thank you, stay with us"
            ],
            [
                'stage' => 17,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Введите название айтема"
            ],
            [
                'stage' => 17,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Введіть назву айтема"
            ],
            [
                'stage' => 17,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Enter the name of the item"
            ],
            [
                'stage' => 17,
                'sub_stage' => 1,
                'localization' => 'RU',
                'message' => "Выберите айтем"
            ],
            [
                'stage' => 17,
                'sub_stage' => 1,
                'localization' => 'UA',
                'message' => "Виберіть айтем"
            ],
            [
                'stage' => 17,
                'sub_stage' => 1,
                'localization' => 'EN',
                'message' => "Choose an item"
            ],
            [
                'stage' => 17,
                'sub_stage' => 2,
                'localization' => 'RU',
                'message' => "По вашему запросу ничего не найдено, попробуйте снова"
            ],
            [
                'stage' => 17,
                'sub_stage' => 2,
                'localization' => 'UA',
                'message' => "За вашим запитом нічого не знайдено, спробуйте ще раз"
            ],
            [
                'stage' => 17,
                'sub_stage' => 2,
                'localization' => 'EN',
                'message' => "No results matching your search, try again"
            ],
            [
                'stage' => 18,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Я не знаю что вам ответить"
            ],
            [
                'stage' => 18,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Я не знаю що вам відповісти"
            ],
            [
                'stage' => 18,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "I do not know what to answer"
            ],
            [
                'stage' => 19,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Личный кабинет"
            ],
            [
                'stage' => 19,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Особистий кабінет"
            ],
            [
                'stage' => 19,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Private office"
            ],
            [
                'stage' => 20,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Управление картами"
            ],
            [
                'stage' => 20,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Управління картами"
            ],
            [
                'stage' => 20,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Card management"
            ],
            [
                'stage' => 20,
                'sub_stage' => 1,
                'localization' => 'RU',
                'message' => "У вас не сохранено ни одной карты"
            ],
            [
                'stage' => 20,
                'sub_stage' => 1,
                'localization' => 'UA',
                'message' => "У вас не збережено жодної карти"
            ],
            [
                'stage' => 20,
                'sub_stage' => 1,
                'localization' => 'EN',
                'message' => "You have not saved any cards"
            ],
            [
                'stage' => 21,
                'sub_stage' => 0,
                'localization' => 'RU',
                'message' => "Выберите раздел"
            ],
            [
                'stage' => 21,
                'sub_stage' => 0,
                'localization' => 'UA',
                'message' => "Виберіть розділ"
            ],
            [
                'stage' => 21,
                'sub_stage' => 0,
                'localization' => 'EN',
                'message' => "Select section"
            ],
            /*[
                'stage' => 19,
                'sub_stage' => 2,
                'localization' => 'RU',
                'message' => "История платежей"
            ],
            [
                'stage' => 19,
                'sub_stage' => 2,
                'localization' => 'UA',
                'message' => "Історія платежів"
            ],
            [
                'stage' => 19,
                'sub_stage' => 2,
                'localization' => 'EN',
                'message' => "History of payments"
            ],*/
        ];

        $this->table('stages_messages')->insert($data)->save();
    }
}
