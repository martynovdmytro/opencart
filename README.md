<h4>This is my educational practice on the Opencart CMS. There are a couple features were created by me.</h4><br />

<h4>1. Attributes in the bottom of the Featured section instead of Product description.</h4>
<p>
Modifications of /catalog/controller/extension/module/featured.php:<br />
<ul>
  <li>In the line No 57 $attributes array receives product attributes by $product_info['product_id'] and processing with foreach</li>
  <li>In the line No 64 $attributes array with product attributes included to the data['products']</li>
</ul>  
Modifications of /catalog/view/theme/default/template/extension/module/featured.twig:<br />
<ul>
  <li>In the lines No 36 - 45 loop added to display attributes in the bottom of the Featured section</li>
</ul>  
</p>


<h4>2. Currency exchange logic including price convertation.</h4>

<p>
There are four types of currencies: UAH, USD, EUR, MDL. UAH is a currency by default.<br />
In case of choising any other currency the actual exchange according to the NBU displays in the header.<br />
Product prices convert according to the chosen currency.<br />
</p>
 
Created /catalog/controller/api/exchange.php:<br />

<ul>
  <li>public function setCurrencyCache caches data received from the NBU</li>
  <li>public function getCurrencyCache fetchs data from cache, provides refreshing every 4 hours and set up the convertation rate</li>
</ul>  
Modifications /catalog/model/localisation/currency.php:<br />
<ul>
  <li>In the line No 37 public function refreshValue added to set the convertation rate in the database</li>
</ul>
Modifications of /catalog/controller/common/header.php:<br />
<ul>
  <li>In the line No 78 $data['exchange'] receives data from /catalog/controller/api/exchange.php</li>
</ul>  
Modifications /catalog/view/theme/default/template/common/header.twig:<br />
<ul>
  <li>In the line No 46 currency exchange displays in the header</li>
</ul>
</p>

<p>
3. Category grid added on the Home page below of the Featured via simple module.<br />
Admin side:<br />
- /admin/controller/extension/module/category_grid.php<br />
- /admin/view/template/extension/module/category_grid.twig<br />
- /admin/language/en-gb/extension/module/category_grid.php<br />
Catalog side:<br />
- /catalog/controller/extension/module/category_grid.php<br />
- /catalog/view/theme/default/template/extension/module/category_grid.twig<br />
- /catalog/language/en-gb/extension/module/category_grid.php<br />
</p>
