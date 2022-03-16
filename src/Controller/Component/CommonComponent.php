<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class CommonComponent extends Component
{
    public $components = ['Workflow'];
    private $gitClient;


    function outputCsv($filepath, $assocDataArray)
    {
        ob_clean();
        if (isset($assocDataArray)) {
            $fp = fopen($filepath, "w");
            foreach ($assocDataArray AS $values) {
                fputcsv($fp, $values);
            }
            fclose($fp);
        }
        ob_flush();
    }

    /**
     * List of all email addresses
     * @return array
     */
    function getAdminEmails()
    {
        $Users = TableRegistry::get('Users');
        $query = $Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'email'
        ])->where(['Users.role' => 'A']);
        return $query->toArray();
    }

    function base64UrlEncode(string $data)
    {
        $urlSafeData = strtr(base64_encode($data), '+/', '-_');
        return rtrim($urlSafeData, '=');
    }

    function base64UrlDecode($data)
    {
        $urlUnsafeData = strtr($data, '-_', '+/');
        $paddedData = str_pad($urlUnsafeData, strlen($data) % 4, '=', STR_PAD_RIGHT);
        return base64_decode($paddedData);
    }

    function generateJWT($algo, $header, $payload, $secret)
    {
        $headerEncoded = $this->base64UrlEncode(json_encode($header));
        $payloadEncoded = $this->base64UrlEncode(json_encode($payload));
        // Delimit with period (.)
        $dataEncoded = "$headerEncoded.$payloadEncoded";
        $rawSignature = hash_hmac($algo, $dataEncoded, $secret, true);
		
        $signatureEncoded = $this->base64UrlEncode($rawSignature);
        // Delimit with second period (.)
        $jwt = "$dataEncoded.$signatureEncoded";
        return $jwt;
    }

    function getToken()
    {
        // JWT Header
        $header = [
            "alg" => "HS256",
            "typ" => "JWT"
        ];

        // JWT Payload data
        $payload = [
            "expiresIn" => 60 * 60,
            "admin" => 'admin'
        ];
        $secret = 'superKey';
        // Create the JWT
        $jwt = $this->generateJWT('sha256', $header, $payload, $secret);
        return $jwt;
    }

    function getBalance($address)
    {
       $data =array('module'=>'account','action'=>'balance','address'=>$address,'tag'=>'latest','apikey'=>Configure::read('apiToken'));
       $apiResult = $this->curlPost(Configure::read('ApiUrl'),$data);
	   $etherBalance = json_decode($apiResult)->result;
	   //prd($etherBalance);
       return array($etherBalance,$this->formatToken(json_decode($apiResult)->result));
    }
	
	function getReservedCoins($address)
    {
       $data =array('module'=>'account','action'=>'balance','address'=>$address,'tag'=>'latest','apikey'=>Configure::read('apiToken'));
       $apiResult = $this->curlPost(Configure::read('ApiUrl'),$data);
       return $this->formatToken(json_decode($apiResult)->result);
    }

    function getTokenBalance($address) //Remaining tokens
    {
      // https://api.etherscan.io/api?module=stats&action=tokensupply&contractaddress=0xD37A4D18bd742fa03b164d9D824c3D36e23a9eB0&apikey=K2BFFF596C18EYJEJCV98EPZQGGB36IG9K
       $data =array('module'=>'stats','action'=>'tokensupply','contractaddress'=>$address,'apikey'=>Configure::read('apiToken'));
       $apiResult = $this->curlPost(Configure::read('ApiUrl'),$data);     
       return $this->formatToken(json_decode($apiResult)->result);
    }

    function curlPost($url, $data = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);

        // In real life you should use something like:
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);
        return ($response);
    }

    /**
     * Format token to 18 decimal places
     * @param $token
     * @return string
     */
    function formatToken($token){
        $token = str_replace('.', '', $token);
        if(strlen($token) <= 18){
            $diff = 18 - strlen($token);
            $num = '0.'.str_repeat("0", $diff).$token;
        }else{
            $num = (substr_replace($token, '.', -18, 0));
        }
        return $num . ' AGS';
    }

    function formatToken2($token, $addAGS = true){
        if($token == '' || $token == 0){
            return '';
        }
        $token = explode('.', $token);

        if(count($token) == 2){
            $diff = 18 - strlen($token[1]);
            $pre = $token[0] == '' ? '0' : $token[0];
            $token = $pre.'.'.$token[1].str_repeat("0", $diff);
        }elseif(count($token) == 1){
            $token = $token = $token[0].'.000000000000000000';
        }else{
            $token = '0';
        }
        if($addAGS){
            return $token . ' AGS';
        }else{
            return $token;
        }
    }

    function formatTokenSend($token){
        $token = explode('.', $token);

        if(count($token) == 2){
            $diff = 18 - strlen($token[1]);
            $pre = $token[0] == '' ? '0' : $token[0];
            $token = $pre.$token[1].str_repeat("0", $diff);
        }elseif(count($token) == 1){
            $token = $token = $token[0].'000000000000000000';
        }else{
            $token = '0';
        }
        return $token;

    }
}