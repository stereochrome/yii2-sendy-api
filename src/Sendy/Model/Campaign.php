<?php 

namespace Stereochrome\Sendy\Model;

use Stereochrome\Sendy\SendyApi;
use yii\httpclient\Client;

class Campaign extends \yii\base\model {
	
	public $html_text;

	public $plain_text;

	public $from_name;

	public $from_email;

	public $reply_to;

	public $title; 

	public $subject; 

	public $list_ids;

	public $query_string;

	protected $send_campaign = 0;

	public function rules() {

		return [

			'htmlTextRequired' => [['html_text'], 'required'],

			'fromNameRequired' => [['from_name'], 'required'],

			'fromEmailRequired' => [['from_email'], 'required'],

			'replyToRequired' => [['reply_to'], 'required'],

			'titleRequired' => [['title'], 'required'],

			'subjectRequired' => [['subject'], 'required'],

			'listIdsRequired' => ['list_ids', 'required', 'when' => function($model) {
			        return $model->send_campaign !== 0;
			    }]
		]

	}

	public function autoSendCampaign() {
		$this->send_campaign = 1;
	}

	public function creatyPreviewOnly() {
		$this->send_campaign = 0;
	}

	public function ready(SendyApi $api) {

		if(empty($this->from_name)) {
			$this->from_name = $api->from_name;
		}

		if(empty($this->from_email)) {
			$this->from_email = $api->from_email;
		}

		if(empty($this->reply_to)) {
			$this->reply_to = $api->reply_to;
		}

		if(empty($this->query_string)) {
			$this->query_string = $api->query_string;
		}

		return $this->validate();
	}

}