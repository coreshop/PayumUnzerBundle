/*
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2020 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 *
 */

pimcore.registerNS('coreshop.provider.gateways.unzer');
coreshop.provider.gateways.unzer = Class.create(coreshop.provider.gateways.abstract, {
    getLayout: function (config) {
        var paymentTypes = new Ext.data.ArrayStore({
            fields: ['name'],
            data: [
                ['paypal'],
                ['sofort'],
                ['card']
            ]
        });

        return [
            {
                xtype: 'combobox',
                fieldLabel: t('unzer_payment_type'),
                name: 'gatewayConfig.config.paymentType',
                value: config.paymentType ? config.paymentType : '',
                store: paymentTypes,
                triggerAction: 'all',
                valueField: 'name',
                displayField: 'name',
                mode: 'local',
                forceSelection: true,
                selectOnFocus: true
            },
            {
                xtype: 'textfield',
                fieldLabel: t('unzer_private_key'),
                name: 'gatewayConfig.config.privateKey',
                length: 255,
                value: config.privateKey ? config.privateKey : ""
            },
            {
                xtype: 'textfield',
                fieldLabel: t('unzer_public_key'),
                name: 'gatewayConfig.config.publicKey',
                length: 255,
                value: config.publicKey ? config.publicKey : ""
            },
        ];
    }
});
