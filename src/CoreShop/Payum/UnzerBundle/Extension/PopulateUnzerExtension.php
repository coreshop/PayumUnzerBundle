<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2020 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
*/

namespace CoreShop\Payum\UnzerBundle\Extension;

use CoreShop\Component\Address\Model\AddressInterface;
use CoreShop\Component\Core\Model\CustomerInterface;
use CoreShop\Component\Order\Model\OrderInterface;
use CoreShop\Component\Core\Model\PaymentInterface;
use CoreShop\Payum\UnzerBundle\UnzerException;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Extension\Context;
use Payum\Core\Extension\ExtensionInterface;
use Payum\Core\Request\Convert;

final class PopulateUnzerExtension implements ExtensionInterface
{
    public function onPostExecute(Context $context): void
    {
        return;

        $action = $context->getAction();

        $previousActionClassName = get_class($action);
        if (false === stripos($previousActionClassName, 'ConvertPaymentAction')) {
            return;
        }

        /** @var Convert $request */
        $request = $context->getRequest();
        if (false === $request instanceof Convert) {
            return;
        }

        /** @var PaymentInterface $payment */
        $payment = $request->getSource();
        if (false === $payment instanceof PaymentInterface) {
            return;
        }

        /** @var OrderInterface $order */
        $order = $payment->getOrder();
        $gatewayLanguage = 'en';
        $customerData = [];

        if (!empty($order->getLocaleCode())) {
            $gatewayLanguage = $order->getLocaleCode();

            if (strpos($gatewayLanguage, '_') !== false) {
                $splitGatewayLLanguage = explode('_', $gatewayLanguage);
                $gatewayLanguage = array_shift($splitGatewayLLanguage);
            }

            /**
             * @var $customer CustomerInterface
             * @var $invoiceAddress AddressInterface
             */
            $customer = $order->getCustomer();
            $invoiceAddress = $order->getInvoiceAddress();

            if ($customer === null || $invoiceAddress === null) {
                throw new UnzerException('Missing Customer Data.');
            }

            $customerData = [
                'name' => $customer->getFirstname(),
                'lastname' => $customer->getLastname(),
                'company' => $invoiceAddress->getCompany(),
                'customer_id' => $customer->getId(),
                'street' => $invoiceAddress->getStreet(),
                'state' => $invoiceAddress->getState() ? $invoiceAddress->getState()->getName($gatewayLanguage) : '',
                'post_code' => $invoiceAddress->getPostcode(),
                'city' => $invoiceAddress->getCity(),
                'country_code' => $invoiceAddress->getCountry()->getIsoCode(),
                'email' => $customer->getEmail()
            ];
        }

        $result = ArrayObject::ensureArrayObject($request->getResult());
        $result = $result->toUnsafeArray();

        $result['language'] = $gatewayLanguage;
        $result['customer'] = $customerData;
        $result['basket']['amount'] = $this->calcAmount($result['basket']['amount'], $payment->getCurrencyCode());

        $request->setResult($result);
    }

    private function calcAmount(int $amount, string $currency): string
    {
        $money = new Money($amount, new Currency($currency));
        $currencies = new ISOCurrencies();
        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        return $moneyFormatter->format($money);
    }

    public function onPreExecute(Context $context): void
    {
    }

    public function onExecute(Context $context): void
    {
    }
}
