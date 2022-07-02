<p>This is my educational practice on the Opencart CMS. There are a couple features were created by me.</p>

1. Attributes in the bottom of the Featured section instead of Product description.
Modifications of /catalog/controller/extension/module/featured.php:
- In the line No 57 $attributes array receives product attributes by $product_info['product_id'] and processing with foreach
- In the line No 64 $attributes array with product attributes included to the data['products'] 
Modifications of /catalog/view/theme/default/template/extension/module/featured.twig:
- In the lines No 36 - 45 loop added to display attributes in the bottom of the Featured section

2. Currency exchange logic including price convertation. 
There are four types of currencies: UAH, USD, EUR, MDL. UAH is a currency by default. 
In case of choising any other currency the actual exchange according to the NBU displays in the header. 
Product prices convert according to the chosen currency. 
Created /catalog/controller/api/exchange.php:
- public function setCurrencyCache caches data received from the NBU
- public function getCurrencyCache fetchs data from cache, provides refreshing every 4 hours and set up the convertation rate 
Modifications /catalog/model/localisation/currency.php:
- In the line No 37 public function refreshValue added to set the convertation rate in the database 
Modifications of /catalog/controller/common/header.php:
- In the line No 78 $data['exchange'] receives data from /catalog/controller/api/exchange.php 
Modifications /catalog/view/theme/default/template/common/header.twig:
- In the line No 46 currency exchange displays in the header

3. Category grid added on the Home page below of the Featured via simple module. 
Admin side:
- /admin/controller/extension/module/category_grid.php
- /admin/view/template/extension/module/category_grid.twig
- /admin/language/en-gb/extension/module/category_grid.php
Catalog side:
- /catalog/controller/extension/module/category_grid.php
- /catalog/view/theme/default/template/extension/module/category_grid.twig
- /catalog/language/en-gb/extension/module/category_grid.php
