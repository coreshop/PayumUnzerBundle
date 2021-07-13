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

use CoreShop\Component\Core\Model\OrderInterface;
use CoreShop\Component\Core\Model\PaymentInterface;
use Payum\Core\Extension\Context;
use Payum\Core\Extension\ExtensionInterface;
use Payum\Core\Request\Capture;
use Payum\Core\Request\RenderTemplate;
use Pimcore\Model\Document\Service;

final class ObtainTokenExtension implements ExtensionInterface
{
    public function onPostExecute(Context $context): void
    {

    }

    public function onPreExecute(Context $context): void
    {
        $request = $context->getRequest();

        if (!$request instanceof RenderTemplate) {
            return;
        }

        $request->addParameter('layout', '@CoreShopFrontend/layout.html.twig');

        if (count($context->getPrevious()) === 0) {
            return;
        }

        $previousContext = $context->getPrevious();
        $previous = reset($previousContext);

        if (!$previous->getRequest() instanceof Capture) {
            return;
        }

        /** @var PaymentInterface $payment */
        $payment = $previous->getRequest()->getFirstModel();


        if (false === $payment instanceof PaymentInterface) {
            return;
        }

        /** @var OrderInterface $order */
        $order = $payment->getOrder();

        if (!$order instanceof OrderInterface) {
            return;
        }


        $service = new Service();
        $request->addParameter('order', $order);
        $request->addParameter('document', $service->getNearestDocumentByPath('/' . $order->getLocaleCode()));
    }

    public function onExecute(Context $context): void
    {
    }
}
