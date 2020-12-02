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
        var gatewayTypes = new Ext.data.ArrayStore({
            fields: ['name'],
            data: [
                ['PayPal'],
                ['Sofort'],
                ['CreditCard'],
                ['DebitCard']
            ]
        });

        return [
            {
                xtype: 'checkbox',
                fieldLabel: t('unzer_sandboxMode'),
                name: 'gatewayConfig.config.sandboxMode',
                value: config.sandboxMode
            },
            {
                xtype: 'combobox',
                fieldLabel: t('unzer_gatewayType'),
                name: 'gatewayConfig.config.gatewayType',
                value: config.gatewayType ? config.gatewayType : '',
                store: gatewayTypes,
                triggerAction: 'all',
                valueField: 'name',
                displayField: 'name',
                mode: 'local',
                forceSelection: true,
                selectOnFocus: true
            },
            {
                xtype: 'textfield',
                fieldLabel: t('unzer_securitySender'),
                name: 'gatewayConfig.config.securitySender',
                length: 255,
                value: config.securitySender ? config.securitySender : ""
            },
            {
                xtype: 'textfield',
                fieldLabel: t('unzer_userLogin'),
                name: 'gatewayConfig.config.userLogin',
                length: 255,
                value: config.userLogin ? config.userLogin : ""
            },
            {
                xtype: 'textfield',
                fieldLabel: t('unzer_userPassword'),
                name: 'gatewayConfig.config.userPassword',
                length: 255,
                value: config.userPassword ? config.userPassword : ""
            },
            {
                xtype: 'textfield',
                fieldLabel: t('unzer_transactionChannel'),
                name: 'gatewayConfig.config.transactionChannel',
                length: 255,
                value: config.transactionChannel ? config.transactionChannel : ""
            },
        ];
    }
});
