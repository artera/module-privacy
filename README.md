A Magento 2 module that adds the Privacy acceptance checkbox in:
* customer registration page
* contact page
* newsletter subscription form

## Installation guide
```bash
$ composer require artera/module-privacy
$ php bin/magento cache:disable
$ php bin/magento module:enable Artera_Privacy
$ php bin/magento setup:upgrade
$ php bin/magento cache:enable
```
If you are using production or default mode
```bash
$ php bin/magento setup:di:compile
```
- - -
Modulo per Magento 2 che aggiunge la checkbox per l'accetazione della privacy:
* nella pagina di registrazione
* nella pagina contatti
* nel form per l'iscrizione alla newsletter

## Installazione
```bash
$ composer require artera/module-privacy
$ bin/magento cache:disable
$ bin/magento module:enable Artera_Privacy
$ bin/magento setup:upgrade
$ bin/magento cache:enable
```
Se stai utilizzando le modalità production o default
```bash
$ php bin/magento setup:di:compile
```
