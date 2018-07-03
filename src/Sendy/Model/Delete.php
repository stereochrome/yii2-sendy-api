<?php 

namespace Stereochrome\Sendy\Model;

use Stereochrome\Sendy\SendyApi;
use yii\httpclient\Client;

class Delete extends \yii\base\model {
	
	public $email;

	public $list_id;

	
	public function rules() {

		return [

			'emailRequired' => [['email'], 'required'],

			'emailFormat' => [['email'], 'email'],

			'listRequired' => [['list_id'], 'required'],

		];

	}

	public function ready(SendyApi $api) {
		return $this->validate();
	}

}