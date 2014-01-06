<?php
// Version: 2.0; ManagePaid

global $boardurl;

// Important! Before editing these language files please read the text at the top of index.english.php.
// Symbols.
$txt['usd_symbol'] = '$%1.2f';
$txt['eur_symbol'] = '&euro;%1.2f';
$txt['gbp_symbol'] = '&pound;%1.2f';

$txt['usd'] = 'USD ($)';
$txt['eur'] = 'EURO (&euro;)';
$txt['gbp'] = 'GBP (&pound;)';
$txt['other'] = 'Otra';

$txt['paid_username'] = 'Nombre de Usuario';

$txt['paid_subscriptions_desc'] = 'From this section you can add, remove and edit paid subscription methods to your forum.';
$txt['paid_subs_settings'] = 'Configuración';
$txt['paid_subs_settings_desc'] = 'From here you can edit the payment methods available to your users.';
$txt['paid_subs_view'] = 'Ver Suscripciones ';
$txt['paid_subs_view_desc'] = 'From this section you can view all the subscriptions you have available.';

// Setting type strings.
$txt['paid_enabled'] = 'Enable Paid Subscriptions';
$txt['paid_enabled_desc'] = 'This must be checked the paid subscriptions to be used on the forum.';
$txt['paid_email'] = 'Send Notification Emails';
$txt['paid_email_desc'] = 'Inform the admin when a subscription automatically changes.';
$txt['paid_email_to'] = 'Email for Correspondence';
$txt['paid_email_to_desc'] = 'Comma seperated list of addresses to email notifications to in addition to forum admins.';
$txt['paidsubs_test'] = 'Habilitar modo de prueba';
$txt['paidsubs_test_desc'] = 'This puts the paid subscriptions mod into &quot;test&quot; mode, which will, whereever possible, use sandbox payment methods in paypal etc. Do not enable unless you know what you are doing!';
$txt['paidsubs_test_confirm'] = 'Are you sure you want to enable test mode?';
$txt['paid_email_no'] = 'Do not send any notifications';
$txt['paid_email_error'] = 'Inform when subscription fails';
$txt['paid_email_all'] = 'Inform on all automatic subscription changes';
$txt['paid_currency'] = 'Selecciona Moneda';
$txt['paid_currency_code'] = 'Currency Code';
$txt['paid_currency_code_desc'] = 'Code used by payment merchants';
$txt['paid_currency_symbol'] = 'Symbol used by payment method';
$txt['paid_currency_symbol_desc'] = 'Use \'%1.2f\' to specify where number goes, for example $%1.2f, %1.2fDM etc';
$txt['paypal_email'] = 'Paypal email address';
$txt['paypal_email_desc'] = 'Leave blank if you do not wish to use paypal.';
$txt['worldpay_id'] = 'WorldPay Install ID';
$txt['worldpay_id_desc'] = 'The Install ID generated by WorldPay. Leave blank if you are not using WorldPay';
$txt['worldpay_password'] = 'WorldPay Callback Password';
$txt['worldpay_password_desc'] = 'Ensure when setting this password in WorldPay it is unique and not the same as your worldpay/admin account password!';
$txt['authorize_id'] = 'Authorize.net Install ID';
$txt['authorize_id_desc'] = 'The Install ID generated by Authorize.net. Leave blank if you are not using Authorize.net';
$txt['authorize_transid'] = 'Authorize.Net Transaction ID';
$txt['2co_id'] = '2co.com Install ID';
$txt['2co_id_desc'] = 'The Install ID generated by 2co.com. Leave blank if you are not using 2co.com';
$txt['2co_password'] = '2co.com Secret Word';
$txt['2co_password_desc'] = 'Your 2checkout secret word.';
$txt['nochex_email'] = 'Nochex email address';
$txt['nochex_email_desc'] = 'Email of a merchant account at Nochex. Leave blank if you are not using Nochex';
$txt['paid_settings_save'] = 'Guardar';

$txt['paid_note'] = '<strong class="alert">Note:</strong><br />For subscriptions to be automatically updated for your users, you
	will need to setup a return URL for each of your payment methods. For all payment types, this return URL should be set as:<br /><br />
	&nbsp;&nbsp;&bull;&nbsp;&nbsp;<strong>' . $boardurl . '/subscriptions.php</strong><br /><br />
	You can edit the link for paypal directly, by clicking <a href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-ipn-notify" target="_blank">here</a>.<br />
	For the other gateways (If installed) you can normally find it in your customer panels, usually under the term &quot;Return URL&quot; or &quot;Callback URL&quot;.';

// View subscription strings.
$txt['paid_name'] = 'Nombre';
$txt['paid_status'] = 'Estado';
$txt['paid_cost'] = 'Coste';
$txt['paid_duration'] = 'Duración';
$txt['paid_active'] = 'Activa';
$txt['paid_pending'] = 'Pago Pendiente';
$txt['paid_finished'] = 'Finalizada';
$txt['paid_total'] = 'Total';
$txt['paid_is_active'] = 'Activada';
$txt['paid_none_yet'] = 'No has configurado ninguna suscripción.';
$txt['paid_payments_pending'] = 'Pendientes de Pago';
$txt['paid_order'] = 'Ordenar';

$txt['yes'] = 'Sí';
$txt['no'] = 'No';

// Add/Edit/Delete subscription.
$txt['paid_add_subscription'] = 'Añadir Suscripción';
$txt['paid_edit_subscription'] = 'Modificar Suscripción';
$txt['paid_delete_subscription'] = 'Eliminar Suscripción';

$txt['paid_mod_name'] = 'Nombre de la Suscripción';
$txt['paid_mod_desc'] = 'Descripción';
$txt['paid_mod_reminder'] = 'Send Reminder Email';
$txt['paid_mod_reminder_desc'] = 'Days before subscription is due to expire to send reminder. (In days, 0 to disable)';
$txt['paid_mod_email'] = 'Email to Send upon Completion';
$txt['paid_mod_email_desc'] = 'Where {NAME} is members name; {FORUM} is community name. Email subject should be on first line. Blank for no email notification.';
$txt['paid_mod_cost_usd'] = 'Coste (USD)';
$txt['paid_mod_cost_eur'] = 'Coste (EUR)';
$txt['paid_mod_cost_gbp'] = 'Coste (GBP)';
$txt['paid_mod_cost_blank'] = 'Leave this blank to not offer this currency.';
$txt['paid_mod_span'] = 'Length of Subscription';
$txt['paid_mod_span_days'] = 'Días';
$txt['paid_mod_span_weeks'] = 'Semanas';
$txt['paid_mod_span_months'] = 'Meses';
$txt['paid_mod_span_years'] = 'Años';
$txt['paid_mod_active'] = 'Activa';
$txt['paid_mod_active_desc'] = 'A subscription must be active for new members to join.';
$txt['paid_mod_prim_group'] = 'Primary Group upon Subscription';
$txt['paid_mod_prim_group_desc'] = 'Primary group to put the user into when they subscribe.';
$txt['paid_mod_add_groups'] = 'Additional Groups upon Subscription';
$txt['paid_mod_add_groups_desc'] = 'Additional groups to add the user to after subscription.';
$txt['paid_mod_no_group'] = 'Don\'t Change';
$txt['paid_mod_edit_note'] = 'Note that as this group has existing subscribers the group settings cannot be changed!';
$txt['paid_mod_delete_warning'] = '<strong>WARNING</strong><br /><br />If you delete this subscription all users currently subscribed will lose any access rights granted by the subscription. Unless you are sure you want to do this it is recommended that you simply deactivate a subscription rather than delete it.<br />';
$txt['paid_mod_repeatable'] = 'Allow user to auto-renew this subscription';
$txt['paid_mod_allow_partial'] = 'Allow partial subscription';
$txt['paid_mod_allow_partial_desc'] = 'If this option is enabled, in the case where the user pays less than required they will be granted a subscription for the percentage of the duration they have paid for.';
$txt['paid_mod_fixed_price'] = 'Subscription for fixed price and period';
$txt['paid_mod_flexible_price'] = 'Subscription price varies on duration ordered';
$txt['paid_mod_price_breakdown'] = 'Flexible Price Breakdown';
$txt['paid_mod_price_breakdown_desc'] = 'Define here how much the subscription should cost dependant on the period they subscribe for. For example, it could cost 12USD to subscribe for a month, but only 100USD for a year. If you don\'t want to define a price for a particular period of time leave it blank.';
$txt['flexible'] = 'Flexible';

$txt['paid_per_day'] = 'Price Per Day';
$txt['paid_per_week'] = 'Price Per Week';
$txt['paid_per_month'] = 'Price Per Month';
$txt['paid_per_year'] = 'Price Per Year';
$txt['day'] = 'Día';
$txt['week'] = 'Semana';
$txt['month'] = 'Mes';
$txt['year'] = 'Año';

// View subscribed users.
$txt['viewing_users_subscribed'] = 'Viewing Users';
$txt['view_users_subscribed'] = 'Viewing users subscribed to: &quot;%1$s&quot;';
$txt['no_subscribers'] = 'There are currently no subscribers to this subscription!';
$txt['add_subscriber'] = 'Add New Subscriber';
$txt['edit_subscriber'] = 'Edit Subscriber';
$txt['delete_selected'] = 'Delete Selected';
$txt['complete_selected'] = 'Complete Selected';

// !!! These strings are used in conjunction with JavaScript.  Use numeric entities.
$txt['delete_are_sure'] = 'Are you sure you want to delete all record of the selected subscriptions?';
$txt['complete_are_sure'] = 'Are you sure you want to complete the selected subscriptions?';

$txt['start_date'] = 'Fecha de Inicio';
$txt['end_date'] = 'Fecha de Finalización';
$txt['start_date_and_time'] = 'Start Date and Time';
$txt['end_date_and_time'] = 'End Date and Time';
$txt['edit'] = 'EDIT';
$txt['one_username'] = 'Please enter one username only.';
$txt['hour'] = 'Hour';
$txt['minute'] = 'Minute';
$txt['error_member_not_found'] = 'The member entered could not be found';
$txt['member_already_subscribed'] = 'This member is already subscribed to this subscription. Please edit their existing subscription.';
$txt['search_sub'] = 'Find User';

// Make payment.
$txt['paid_confirm_payment'] = 'Confirmar Pago';
$txt['paid_confirm_desc'] = 'Para continuar el proceso de pago por favor comprueba los detalles abajo y pulsa &quot;Ordenar&quot;';
$txt['paypal'] = 'PayPal';
$txt['paid_confirm_paypal'] = 'Para pagar mediante <a href="http://www.paypal.com">PayPal</a> por favor haz clic en el botón de abajo. Serás dirigido al sitio de PayPal para el pago. ';
$txt['paid_paypal_order'] = 'Ordenar con PayPal';
$txt['worldpay'] = 'WorldPay';
$txt['paid_confirm_worldpay'] = 'To pay using <a href="http://www.worldpay.com">WorldPay</a> please click the button below. You will be directed to the WorldPay site for payment.';
$txt['paid_worldpay_order'] = 'Order with WorldPay';
$txt['nochex'] = 'Nochex';
$txt['paid_confirm_nochex'] = 'To pay using <a href="http://www.nochex.com">Nochex</a> please click the button below. You will be directed to the Nochex site for payment.';
$txt['paid_nochex_order'] = 'Order with Nochex';
$txt['authorize'] = 'Authorize.Net';
$txt['paid_confirm_authorize'] = 'To pay using <a href="http://www.authorize.net">Authorize.Net</a> please click the button below. You will be directed to the Authorize.Net site for payment.';
$txt['paid_authorize_order'] = 'Order with Authorize.Net';
$txt['2co'] = '2checkout';
$txt['paid_confirm_2co'] = 'To pay using <a href="http://www.2co.com">2co.com</a> please click the button below. You will be directed to the 2co.com site for payment.';
$txt['paid_2co_order'] = 'Order with 2co.com';
$txt['paid_done'] = 'Pago Completado';
$txt['paid_done_desc'] = 'Gracias por tu pago. En cuanto la transacción se haya verificado se activará la suscripción.';
$txt['paid_sub_return'] = 'Volver a Suscripciones';
$txt['paid_current_desc'] = 'Debajo hay una lista de todas tus suscripciones actuales y previas. Para extender una suscripción existente simplemente selecciónala de la lista de arriba.';
$txt['paid_admin_add'] = 'Añadir esta Suscripción';

$txt['paid_not_set_currency'] = 'You have not setup your currency yet. Please do so from the settings menu before continuing';
$txt['paid_no_cost_value'] = 'You must enter a cost and subscription length.';
$txt['paid_all_freq_blank'] = 'You must enter a cost for at least one of the four durations.';

// Some error strings.
$txt['paid_no_data'] = 'No valid data was sent to the script.';

$txt['paypal_could_not_connect'] = 'Could not connect to PayPal server';
$txt['paid_sub_not_active'] = 'That subscription is not taking any new users!';
$txt['paid_disabled'] = 'Paid subscriptions are currently disabled!';
$txt['paid_unknown_transaction_type'] = 'Unknown Paid Subscriptions transaction type.';
$txt['paid_empty_member'] = 'Paid subscription handler could not recover member ID';
$txt['paid_could_not_find_member'] = 'Paid subscription handler could not find member with ID: %1$d';
$txt['paid_count_not_find_subscription'] = 'Paid subscription handler could not find subscription for member ID: %1$s, subscription ID: %2$s';
$txt['paid_count_not_find_subscription_log'] = 'Paid subscription handler could not find subscription log entry for member ID: %1$s, subscription ID: %2$s';
$txt['paid_count_not_find_outstanding_payment'] = 'Coud not find outstanding payment entry for member ID: %1$s, subscription ID: %2$s so ignoring';
$txt['paid_admin_not_setup_gateway'] = 'Sorry, the admin has not yet finished setting up paid subscriptions. Please check back later.';
$txt['paid_make_recurring'] = 'Hacer un pago periódico';

$txt['subscriptions'] = 'Suscripciones';
$txt['subscription'] = 'Suscripción';
$txt['paid_subs_desc'] = 'Debajo hay una lista de todas las suscripciones disponibles en este foro.';
$txt['paid_subs_none'] = '¡No hay suscripciones de pago disponibles actualmente!';

$txt['paid_current'] = 'Suscripciones Existentes';
$txt['pending_payments'] = 'Pagos Pendientes';
$txt['pending_payments_desc'] = 'This member has attempted to make the following payments for this subscription but the confirmation has not been received by the forum. If you are sure the payment has been received click &quot;accept&quot; to action to subscription. Alternatively you can click &quot;Remove&quot; to remove all reference to the payment.';
$txt['pending_payments_value'] = 'Value';
$txt['pending_payments_accept'] = 'Accept';
$txt['pending_payments_remove'] = 'Remove';

?>