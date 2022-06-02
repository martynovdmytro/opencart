<?php
class ControllerApiExchange extends Controller {
    public function index(){
        $this->load->model('localisation/currency');

        $root = $_SERVER['DOCUMENT_ROOT'] . '/storage/cache/'; // currency cache file

        if ($this->session->data['currency'] != 'UAH') {

            if (file_exists($root . '/' . $this->session->data['currency'] . '.' . 'txt')) {
                $exchange = unserialize(file_get_contents($root . '/' . $this->session->data['currency'] . '.' . 'txt'));
                if (!empty($exchange)) {
                    $overtime = $exchange['timestamp'] + 60 * 60 * 4;
                    if ($overtime < time()) {
                        $this->setCurrencyCache($root);
                    }
                    if (!empty($exchange['currency'])) {
                        $data['exchange'] = (array)$exchange['currency'];
                        if (isset($data['exchange']['rate'])) {
                            $data['exchange']['rate'] = round($data['exchange']['rate'], 2);
                            $this->model_localisation_currency->refreshValue( $data['exchange']['rate'], $this->session->data['currency']);
                        } else {
                            $data['exchange']['rate'] = null;
                        }
                    } else {
                        $this->setCurrencyCache($root);
                    }
                } else {
                    $this->setCurrencyCache($root);
                }
            } else {
                $this->setCurrencyCache($root);
            }
        }
        return $data['exchange'];
    }

    public function setCurrencyCache($root)
    {
        $url = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';
        $timestamp = time();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $api = json_decode(curl_exec($ch));
        curl_close($ch);

        if (isset($api['25']) && isset($api['32']) && isset($api['15'])) {
            $usd = array('currency' => $api['25'], 'timestamp' => $timestamp);
            $eur = array('currency' => $api['32'], 'timestamp' => $timestamp);
            $mdl = array('currency' => $api['15'], 'timestamp' => $timestamp);

            switch ($this->session->data['currency']) {
                case $this->session->data['currency'] == 'USD':
                    file_put_contents($root . '/' . $this->session->data['currency'] . '.' . 'txt', serialize($usd));
                    break;
                case $this->session->data['currency'] == 'EUR':
                    file_put_contents($root . '/' . $this->session->data['currency'] . '.' . 'txt', serialize($eur));
                    break;
                case $this->session->data['currency'] == 'MDL':
                    file_put_contents($root . '/' . $this->session->data['currency'] . '.' . 'txt', serialize($mdl));
                    break;
            }

            header("Location: $_SERVER[REQUEST_URI]");

        } else {
            file_put_contents($root . '/' . $this->session->data['currency'] . '.' . 'txt', null);
        }
    }
}
