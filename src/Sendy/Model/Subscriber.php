<?php 

namespace Stereochrome\Sendy\Model;

use Stereochrome\Sendy\SendyApi;
use yii\httpclient\Client;

class Subscriber extends \yii\base\model {
	
	public $name;

	public $email;

	public $list;

	public $country;

	public $ipaddress;

	public $referrer;

	public $gdpr;

	public $hp;

	public $boolean;

	public function rules() {

		return [

			'emailRequired' => [['email'], 'required'],

			'emailFormat' => [['email'], 'email'],

			'listRequired' => [['list'], 'required'],

		];

	}

	public function ready(SendyApi $api) {
		return $this->validate();
	}

}