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

namespace CoreShop\Payum\UnzerBundle\Form\Payment;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class UnzerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('paymentType', ChoiceType::class, [
                'choices' => [
                    'paypal', 'sofort', 'card'
                ]
            ])
            ->add('privateKey', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'coreshop',
                    ]),
                ],
            ])
            ->add('publicKey', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'groups' => 'coreshop',
                    ]),
                ],
            ])
        ;
    }
}
