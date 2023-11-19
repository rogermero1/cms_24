<?php

// File generated from our OpenAPI spec

namespace Stripe;

/**
 * Subscriptions allow you to charge a customer on a recurring basis.
 *
 * Related guide: <a
 * href="https://stripe.com/docs/billing/subscriptions/creating">Creating
 * Subscriptions</a>.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property null|float $application_fee_percent A non-negative decimal between 0 and 100, with at most two decimal places. This represents the percentage of the subscription invoice subtotal that will be transferred to the application owner's Stripe account.
 * @property \Stripe\StripeObject $automatic_tax
 * @property int $billing_cycle_anchor Determines the date of the first full invoice, and, for plans with <code>month</code> or <code>year</code> intervals, the day of the month for subsequent invoices.
 * @property null|\Stripe\StripeObject $billing_thresholds Define thresholds at which an invoice will be sent, and the subscription advanced to a new billing period
 * @property null|int $cancel_at A date in the future at which the subscription will automatically get canceled
 * @property bool $cancel_at_period_end If the subscription has been canceled with the <code>at_period_end</code> flag set to <code>true</code>, <code>cancel_at_period_end</code> on the subscription will be true. You can use this attribute to determine whether a subscription that has a status of active is scheduled to be canceled at the end of the current period.
 * @property null|int $canceled_at If the subscription has been canceled, the date of that cancellation. If the subscription was canceled with <code>cancel_at_period_end</code>, <code>canceled_at</code> will reflect the time of the most recent update request, not the end of the subscription period when the subscription is automatically moved to a canceled state.
 * @property string $collection_method Either <code>charge_automatically</code>, or <code>send_invoice</code>. When charging automatically, Stripe will attempt to pay this subscription at the end of the cycle using the default source attached to the customer. When sending an invoice, Stripe will email your customer an invoice with payment instructions.
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property int $current_period_end End of the current period that the subscription has been invoiced for. At the end of this period, a new invoice will be created.
 * @property int $current_period_start Start of the current period that the subscription has been invoiced for.
 * @property string|\Stripe\Customer $customer ID of the customer who owns the subscription.
 * @property null|int $days_until_due Number of days a customer has to pay invoices generated by this subscription. This value will be <code>null</code> for subscriptions where <code>collection_method=charge_automatically</code>.
 * @property null|string|\Stripe\PaymentMethod $default_payment_method ID of the default payment method for the subscription. It must belong to the customer associated with the subscription. This takes precedence over <code>default_source</code>. If neither are set, invoices will use the customer's <a href="https://stripe.com/docs/api/customers/object#customer_object-invoice_settings-default_payment_method">invoice_settings.default_payment_method</a> or <a href="https://stripe.com/docs/api/customers/object#customer_object-default_source">default_source</a>.
 * @property null|string|\Stripe\Account|\Stripe\AlipayAccount|\Stripe\BankAccount|\Stripe\BitcoinReceiver|\Stripe\Card|\Stripe\Source $default_source ID of the default payment source for the subscription. It must belong to the customer associated with the subscription and be in a chargeable state. If <code>default_payment_method</code> is also set, <code>default_payment_method</code> will take precedence. If neither are set, invoices will use the customer's <a href="https://stripe.com/docs/api/customers/object#customer_object-invoice_settings-default_payment_method">invoice_settings.default_payment_method</a> or <a href="https://stripe.com/docs/api/customers/object#customer_object-default_source">default_source</a>.
 * @property null|\Stripe\TaxRate[] $default_tax_rates The tax rates that will apply to any subscription item that does not have <code>tax_rates</code> set. Invoices created will have their <code>default_tax_rates</code> populated from the subscription.
 * @property null|\Stripe\Discount $discount Describes the current discount applied to this subscription, if there is one. When billing, a discount applied to a subscription overrides a discount applied on a customer-wide basis.
 * @property null|int $ended_at If the subscription has ended, the date the subscription ended.
 * @property \Stripe\Collection $items List of subscription items, each with an attached price.
 * @property null|string|\Stripe\Invoice $latest_invoice The most recent invoice this subscription has generated.
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property \Stripe\StripeObject $metadata Set of <a href="https://stripe.com/docs/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property null|int $next_pending_invoice_item_invoice Specifies the approximate timestamp on which any pending invoice items will be billed according to the schedule provided at <code>pending_invoice_item_interval</code>.
 * @property null|\Stripe\StripeObject $pause_collection If specified, payment collection for this subscription will be paused.
 * @property null|\Stripe\StripeObject $payment_settings Payment settings passed on to invoices created by the subscription.
 * @property null|\Stripe\StripeObject $pending_invoice_item_interval Specifies an interval for how often to bill for any pending invoice items. It is analogous to calling <a href="https://stripe.com/docs/api#create_invoice">Create an invoice</a> for the given subscription at the specified interval.
 * @property null|string|\Stripe\SetupIntent $pending_setup_intent You can use this <a href="https://stripe.com/docs/api/setup_intents">SetupIntent</a> to collect user authentication when creating a subscription without immediate payment or updating a subscription's payment method, allowing you to optimize for off-session payments. Learn more in the <a href="https://stripe.com/docs/billing/migration/strong-customer-authentication#scenario-2">SCA Migration Guide</a>.
 * @property null|\Stripe\StripeObject $pending_update If specified, <a href="https://stripe.com/docs/billing/subscriptions/pending-updates">pending updates</a> that will be applied to the subscription once the <code>latest_invoice</code> has been paid.
 * @property null|string|\Stripe\SubscriptionSchedule $schedule The schedule attached to the subscription
 * @property int $start_date Date when the subscription was first created. The date might differ from the <code>created</code> date due to backdating.
 * @property string $status <p>Possible values are <code>incomplete</code>, <code>incomplete_expired</code>, <code>trialing</code>, <code>active</code>, <code>past_due</code>, <code>canceled</code>, or <code>unpaid</code>.</p><p>For <code>collection_method=charge_automatically</code> a subscription moves into <code>incomplete</code> if the initial payment attempt fails. A subscription in this state can only have metadata and default_source updated. Once the first invoice is paid, the subscription moves into an <code>active</code> state. If the first invoice is not paid within 23 hours, the subscription transitions to <code>incomplete_expired</code>. This is a terminal state, the open invoice will be voided and no further invoices will be generated.</p><p>A subscription that is currently in a trial period is <code>trialing</code> and moves to <code>active</code> when the trial period is over.</p><p>If subscription <code>collection_method=charge_automatically</code> it becomes <code>past_due</code> when payment to renew it fails and <code>canceled</code> or <code>unpaid</code> (depending on your subscriptions settings) when Stripe has exhausted all payment retry attempts.</p><p>If subscription <code>collection_method=send_invoice</code> it becomes <code>past_due</code> when its invoice is not paid by the due date, and <code>canceled</code> or <code>unpaid</code> if it is still not paid by an additional deadline after that. Note that when a subscription has a status of <code>unpaid</code>, no subsequent invoices will be attempted (invoices will be created, but then immediately automatically closed). After receiving updated payment information from a customer, you may choose to reopen and pay their closed invoices.</p>
 * @property null|int $trial_end If the subscription has a trial, the end of that trial.
 * @property null|int $trial_start If the subscription has a trial, the beginning of that trial.
 */
class Subscription extends ApiResource
{
    const OBJECT_NAME = 'subscription';

    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    const PAYMENT_BEHAVIOR_ALLOW_INCOMPLETE = 'allow_incomplete';
    const PAYMENT_BEHAVIOR_ERROR_IF_INCOMPLETE = 'error_if_incomplete';
    const PAYMENT_BEHAVIOR_PENDING_IF_INCOMPLETE = 'pending_if_incomplete';

    const PRORATION_BEHAVIOR_ALWAYS_INVOICE = 'always_invoice';
    const PRORATION_BEHAVIOR_CREATE_PRORATIONS = 'create_prorations';
    const PRORATION_BEHAVIOR_NONE = 'none';

    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELED = 'canceled';
    const STATUS_INCOMPLETE = 'incomplete';
    const STATUS_INCOMPLETE_EXPIRED = 'incomplete_expired';
    const STATUS_PAST_DUE = 'past_due';
    const STATUS_TRIALING = 'trialing';
    const STATUS_UNPAID = 'unpaid';

    use ApiOperations\Delete {
        delete as protected _delete;
      }

    public static function getSavedNestedResources()
    {
        static $savedNestedResources = null;
        if (null === $savedNestedResources) {
            $savedNestedResources = new Util\Set([
                'source',
            ]);
        }

        return $savedNestedResources;
    }

    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Subscription the deleted subscription
     */
    public function cancel($params = null, $opts = null)
    {
        return $this->_delete($params, $opts);
    }

    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \Stripe\Subscription the updated subscription
     */
    public function deleteDiscount($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/discount';
        list($response, $opts) = $this->_request('delete', $url, $params, $opts);
        $this->refreshFrom(['discount' => null], $opts, true);
    }
}
