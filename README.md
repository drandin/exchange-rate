# Получение курсов валют с сайта Центробанка России.

Система для получения курсов валют с официального сайта **Центрального Банка России** https://www.cbr.ru и конвертер валют.

### Возможности пакета

- Получение по средствам API курсов валют с сайта Центробанка России по дате.
- Конвертирование одной валюты в другую.

## Требования

- Версия PHP 7.3 и выше.

## Установка

Для установки пакета следует выполнить команду:

```shell script
composer require drandin/declension-nouns
```

## Использование

Ниже приведены примеры использования пакета.

### Получение курсов валют

##### Пример 1

Запрос данных о курсах валют, которые Центробанк России установил на дату **2020-02-19**:

```php
use CentralBankRussian\ExchangeRate\CBRClient;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionIncorrectData;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionInvalidParameter;
use CentralBankRussian\ExchangeRate\ExchangeRate;

 $exchangeRate = new ExchangeRate(new CBRClient());

 try {
     $currencyRateCollection = $exchangeRate
         ->setDate(new DateTime('2020-02-19'))
         ->getCurrencyExchangeRates();

     var_dump($currencyRateCollection);
 }
 catch (ExceptionIncorrectData | ExceptionInvalidParameter $e) {
     echo $e->getMessage();
 }
```

Результат (фрагмент):

```
object(CentralBankRussian\ExchangeRate\Collections\CurrencyRateCollection)[819]
  private 'currencyRates' => 
    array (size=35)
      'AUD' => 
        object(CentralBankRussian\ExchangeRate\Models\CurrencyRate)[823]
          private 'name' => string 'Австралийский доллар                                                                                                                                                                                                                                          ' (length=273)
          private 'exchangeRate' => float 42.6046
          private 'quantity' => int 1
          private 'numericCode' => string '36' (length=2)
          private 'symbolCode' => string 'AUD' (length=3)
      'AZN' => 
        object(CentralBankRussian\ExchangeRate\Models\CurrencyRate)[822]
          private 'name' => string 'Азербайджанский манат                                                                                                                                                                                                                                         ' (length=274)
          private 'exchangeRate' => float 37.589
          private 'quantity' => int 1
          private 'numericCode' => string '944' (length=3)
          private 'symbolCode' => string 'AZN' (length=3)
      'GBP' => 
        object(CentralBankRussian\ExchangeRate\Models\CurrencyRate)[824]
          private 'name' => string 'Фунт стерлингов Соединенного королевства                                                                                                                                                                                                                      ' (length=291)
          private 'exchangeRate' => float 82.7987
          private 'quantity' => int 1
          private 'numericCode' => string '826' (length=3)
          private 'symbolCode' => string 'GBP' (length=3)
      'AMD' => 
        object(CentralBankRussian\ExchangeRate\Models\CurrencyRate)[825]
          private 'name' => string 'Армянский драм                                                                                                                                                                                                                                                ' (length=267)
          private 'exchangeRate' => float 13.327
          private 'quantity' => int 100
          private 'numericCode' => string '51' (length=2)
          private 'symbolCode' => string 'AMD' (length=3)
      'BYN' => 
        object(CentralBankRussian\ExchangeRate\Models\CurrencyRate)[826]
          private 'name' => string 'Белорусский рубль                                                                                                                                                                                                                                             ' (length=270)
          private 'exchangeRate' => float 28.931
          private 'quantity' => int 1
          private 'numericCode' => string '933' (length=3)
          private 'symbolCode' => string 'BYN' (length=3)
      ...
```

##### Пример 2

Запрос данных валюты **USD** актуальных на дату **2020-07-12**:

```php
use CentralBankRussian\ExchangeRate\CBRClient;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionIncorrectData;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionInvalidParameter;
use CentralBankRussian\ExchangeRate\ExchangeRate;

 $exchangeRate = new ExchangeRate(
         new CBRClient()
 );
 
 try {
 
     $currencyRate = $exchangeRate
          ->setDate(new DateTime('2020-07-12'))
          ->getCurrencyExchangeRates()
          ->getCurrencyRateBySymbolCode('AMD');
 
     var_dump($currencyRate);
 
 }
 catch (ExceptionIncorrectData | ExceptionInvalidParameter $e) {
      echo $e->getMessage();
 }
```

В этом примере мы запрашиваем коллекцию курсов валют **CentralBankRussian\ExchangeRate\Collections** и при помощи метода **getCurrencyRateBySymbolCode('AMD')** получаем элемент коллекции для валюты с символьным кодом **AMD** (Армянский драм).

Результат:

```
object(CentralBankRussian\ExchangeRate\Models\CurrencyRate)[825]
  private 'name' => string 'Армянский драм                                                                                                                                                                                                                                                ' (length=267)
  private 'exchangeRate' => float 14.6383
  private 'quantity' => int 100
  private 'numericCode' => string '51' (length=2)
  private 'symbolCode' => string 'AMD' (length=3)
```
Обратите внимание на свойство **quantity**, для валюты Армянский драм **quantity** равняется **100**. Это значит, что **100** армянских драм стоят **14.6383 рублей**.

##### Пример 3

Получение курса валюты **AMD** по отношению к рублю на указанную дату — **2020-09-30**: 

```php
use CentralBankRussian\ExchangeRate\CBRClient;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionIncorrectData;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionInvalidParameter;
use CentralBankRussian\ExchangeRate\ExchangeRate;

 $exchangeRate = new ExchangeRate(
         new CBRClient()
 );
 
 try {
 
     $rateInRubles = $exchangeRate
          ->setDate(new DateTime('2020-09-30'))
          ->getRateInRubles('AMD');
 
     echo $rateInRubles;
 
 }
 catch (ExceptionIncorrectData | ExceptionInvalidParameter $e) {
      echo $e->getMessage();
 }
```

Результат:

```
0.1641
```

Мы получили курс **1** армянского драма в рублях, который Центробанки установил на дату **2020-09-30**.

### Конвертация курсов валют

Пример конвертации **73 224** долларов США в Евро по курсу, который был актуален **2020-06-10**:

```php
use CentralBankRussian\ExchangeRate\Converter;
use CentralBankRussian\ExchangeRate\CBRClient;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionIncorrectData;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionInvalidParameter;
use CentralBankRussian\ExchangeRate\ExchangeRate;

try {

    $exchangeRate = new ExchangeRate(
         new CBRClient()
     );

    $converter = new Converter($exchangeRate);

    $val = $converter
        ->setDate(new DateTime('2020-06-10'))
        ->convert(73224, 'USD', 'EUR');

    echo $val;

}
catch (ExceptionIncorrectData | ExceptionInvalidParameter $e) {
    echo $e->getMessage();
}
```

Результат:

```
65012.87
```

73 224 долларов США равняется 65 012.87 Евро по курсу Центробанка РФ который был установлен на дату **2020-06-10**.

### Получение справочника по кодам валют

##### Пример 1

Получение перечня ежедневных валют:

```php
use CentralBankRussian\ExchangeRate\CBRClient;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionIncorrectData;
use CentralBankRussian\ExchangeRate\ReferenceData;

$referenceData = new ReferenceData(new CBRClient());

try {
    $currencyCollection = $referenceData->getCurrencyCodesDaily();
    var_dump($currencyCollection);
}
catch (ExceptionIncorrectData $e) {
    echo $e->getMessage();
}
```

Результат (фрагмент):

```
object(CentralBankRussian\ExchangeRate\Collections\CurrencyCollection)[819]
  private 'currencies' => 
    array (size=58)
      'AUD' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[822]
          private 'name' => string 'Австралийский доллар                                                                                                                                                                                                                                          ' (length=273)
          private 'nameEng' => string 'Australian Dollar                                                                                                                                                                                                                                             ' (length=254)
          private 'quantity' => int 1
          private 'numericCode' => string '36' (length=2)
          private 'symbolCode' => string 'AUD' (length=3)
          private 'internalCode' => string 'R01010' (length=6)
          private 'internalCommonCode' => string 'R01010' (length=6)
      'ATS' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[818]
          private 'name' => string 'Австрийский шиллинг                                                                                                                                                                                                                                           ' (length=272)
          private 'nameEng' => string 'Austrian Shilling                                                                                                                                                                                                                                             ' (length=254)
          private 'quantity' => int 1000
          private 'numericCode' => string '40' (length=2)
          private 'symbolCode' => string 'ATS' (length=3)
          private 'internalCode' => string 'R01015' (length=6)
          private 'internalCommonCode' => string 'R01015' (length=6)
      'AZN' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[823]
          private 'name' => string 'Азербайджанский манат                                                                                                                                                                                                                                         ' (length=274)
          private 'nameEng' => string 'Azerbaijan Manat                                                                                                                                                                                                                                              ' (length=254)
          private 'quantity' => int 1
          private 'numericCode' => string '944' (length=3)
          private 'symbolCode' => string 'AZN' (length=3)
          private 'internalCode' => string 'R01020A' (length=7)
          private 'internalCommonCode' => string 'R01020' (length=6)
      'GBP' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[824]
          private 'name' => string 'Фунт стерлингов Соединенного королевства                                                                                                                                                                                                                      ' (length=291)
          private 'nameEng' => string 'British Pound Sterling                                                                                                                                                                                                                                        ' (length=254)
          private 'quantity' => int 1
          private 'numericCode' => string '826' (length=3)
          private 'symbolCode' => string 'GBP' (length=3)
          private 'internalCode' => string 'R01035' (length=6)
          private 'internalCommonCode' => string 'R01035' (length=6)
      'AON' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[825]
          private 'name' => string 'Ангольская новая кванза                                                                                                                                                                                                                                       ' (length=275)
          private 'nameEng' => string 'Angolan new Kwanza                                                                                                                                                                                                                                            ' (length=254)
          private 'quantity' => int 100000
          private 'numericCode' => string '24' (length=2)
          private 'symbolCode' => string 'AON' (length=3)
          private 'internalCode' => string 'R01040F' (length=7)
          private 'internalCommonCode' => string 'R01040' (length=6)
      'AMD' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[826]
          private 'name' => string 'Армянский драм                                                                                                                                                                                                                                                ' (length=267)
          private 'nameEng' => string 'Armenia Dram                                                                                                                                                                                                                                                  ' (length=254)
          private 'quantity' => int 1000
          private 'numericCode' => string '51' (length=2)
          private 'symbolCode' => string 'AMD' (length=3)
          private 'internalCode' => string 'R01060' (length=6)
          private 'internalCommonCode' => string 'R01060' (length=6)
      'BYN' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[827]
          private 'name' => string 'Белорусский рубль                                                                                                                                                                                                                                             ' (length=270)
          private 'nameEng' => string 'Belarussian Ruble                                                                                                                                                                                                                                             ' (length=254)
          private 'quantity' => int 1
          private 'numericCode' => string '933' (length=3)
          private 'symbolCode' => string 'BYN' (length=3)
          private 'internalCode' => string 'R01090B' (length=7)
          private 'internalCommonCode' => string 'R01090' (length=6)
      'BEF' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[828]
          private 'name' => string 'Бельгийский франк                                                                                                                                                                                                                                             ' (length=270)
          private 'nameEng' => string 'Belgium Franc                                                                                                                                                                                                                                                 ' (length=254)
          private 'quantity' => int 1000
          private 'numericCode' => string '56' (length=2)
          private 'symbolCode' => string 'BEF' (length=3)
          private 'internalCode' => string 'R01095' (length=6)
          private 'internalCommonCode' => string 'R01095' (length=6)
      ...
```

##### Пример 1

Получение перечня ежемесячных валют:

```php
use CentralBankRussian\ExchangeRate\CBRClient;
use CentralBankRussian\ExchangeRate\Exceptions\ExceptionIncorrectData;
use CentralBankRussian\ExchangeRate\ReferenceData;

$referenceData = new ReferenceData(new CBRClient());

try {
    $currencyCollection = $referenceData->getCurrencyCodesMonthly();
    var_dump($currencyCollection);
}
catch (ExceptionIncorrectData $e) {
    echo $e->getMessage();
}
```

Результат (фрагмент):

```
object(CentralBankRussian\ExchangeRate\Collections\CurrencyCollection)[819]
  private 'currencies' => 
    array (size=85)
      'ALL' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[822]
          private 'name' => string 'Албанский лек                                                                                                                                                                                                                                                 ' (length=266)
          private 'nameEng' => string 'Albanian Lek                                                                                                                                                                                                                                                  ' (length=254)
          private 'quantity' => int 100
          private 'numericCode' => string '8' (length=1)
          private 'symbolCode' => string 'ALL' (length=3)
          private 'internalCode' => string 'R01025' (length=6)
          private 'internalCommonCode' => string 'R01025' (length=6)
      'DZD' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[818]
          private 'name' => string 'Алжирский динар                                                                                                                                                                                                                                               ' (length=268)
          private 'nameEng' => string 'Algerian Dinar                                                                                                                                                                                                                                                ' (length=254)
          private 'quantity' => int 100
          private 'numericCode' => string '12' (length=2)
          private 'symbolCode' => string 'DZD' (length=3)
          private 'internalCode' => string 'R01030' (length=6)
          private 'internalCommonCode' => string 'R01030' (length=6)
      'AOA' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[824]
          private 'name' => string 'Ангольская кванза                                                                                                                                                                                                                                             ' (length=270)
          private 'nameEng' => string 'Angolan Kwanza                                                                                                                                                                                                                                                ' (length=254)
          private 'quantity' => int 100
          private 'numericCode' => string '973' (length=3)
          private 'symbolCode' => string 'AOA' (length=3)
          private 'internalCode' => string 'R01040E' (length=7)
          private 'internalCommonCode' => string 'R01040' (length=6)
      'ARS' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[823]
          private 'name' => string 'Аргентинское песо                                                                                                                                                                                                                                             ' (length=270)
          private 'nameEng' => string 'Argentine Peso                                                                                                                                                                                                                                                ' (length=254)
          private 'quantity' => int 10
          private 'numericCode' => string '32' (length=2)
          private 'symbolCode' => string 'ARS' (length=3)
          private 'internalCode' => string 'R01055' (length=6)
          private 'internalCommonCode' => string 'R01055' (length=6)
      'AFN' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[825]
          private 'name' => string 'Афганский афгани                                                                                                                                                                                                                                              ' (length=269)
          private 'nameEng' => string 'Afghanistan Afgani                                                                                                                                                                                                                                            ' (length=254)
          private 'quantity' => int 100
          private 'numericCode' => string '971' (length=3)
          private 'symbolCode' => string 'AFN' (length=3)
          private 'internalCode' => string 'R01065' (length=6)
          private 'internalCommonCode' => string 'R01065' (length=6)
      'BHD' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[826]
          private 'name' => string 'Бахрейнский динар                                                                                                                                                                                                                                             ' (length=270)
          private 'nameEng' => string 'Bahraini Dinar                                                                                                                                                                                                                                                ' (length=254)
          private 'quantity' => int 1
          private 'numericCode' => string '48' (length=2)
          private 'symbolCode' => string 'BHD' (length=3)
          private 'internalCode' => string 'R01080' (length=6)
          private 'internalCommonCode' => string 'R01080' (length=6)
      'BOB' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[827]
          private 'name' => string 'Боливийский боливиано                                                                                                                                                                                                                                         ' (length=274)
          private 'nameEng' => string 'Bolivian Boliviano                                                                                                                                                                                                                                            ' (length=254)
          private 'quantity' => int 10
          private 'numericCode' => string '68' (length=2)
          private 'symbolCode' => string 'BOB' (length=3)
          private 'internalCode' => string 'R01105' (length=6)
          private 'internalCommonCode' => string 'R01105' (length=6)
      'BWP' => 
        object(CentralBankRussian\ExchangeRate\Models\Currency)[828]
          private 'name' => string 'Ботсванская пула                                                                                                                                                                                                                                              ' (length=269)
          private 'nameEng' => string 'Botswana Pula                                                                                                                                                                                                                                                 ' (length=254)
          private 'quantity' => int 10
          private 'numericCode' => string '72' (length=2)
          private 'symbolCode' => string 'BWP' (length=3)
          private 'internalCode' => string 'R01110' (length=6)
          private 'internalCommonCode' => string 'R01110' (length=6)
      ...
```