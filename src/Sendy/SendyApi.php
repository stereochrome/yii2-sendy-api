<?php

namespace Stereochrome\Sendy;

use \Stereochrome\Sendy\Model;

class SendyApi extends \yii\base\Component {

	public $api_url; 

	public $api_key;

	public $brand_id;

	public $from_name;

	public $from_email;

	public $reply_to;

	public $query_string;

	protected $lastAnswer;

	const ERROR = false;
	const CAMPAIGN_PREVIEW_CREATED = 1;
	const CAMPAIGN_CREATED_AND_SENT = 2;



	protected $replies = [
		'Campaign created' => true,
		'Campaign created and now sending' => true,
		'No data passed' => false,
		'API key not passed' => false,
		'Invalid API key' => false,
		'From name not passed' => false,
		'From email not passed' => false,
		'Reply to email not passed' => false,
		'Subject not passed' => false,
		'HTML not passed' => false,
		'List ID(s) not passed' => false,
		'One or more list IDs are invalid' => false,
		'List IDs does not belong to a single brand' => false,
		'Brand ID not passed' => false,
		'Unable to create campaign' => false,
		'Unable to create and send campaign]' => false,
	];



	public function init() {

		if(!isset($this->api_url)) {
			throw new \Exception("Sendy api_url not configured");
		}

		if(!isset($this->api_key)) {
			throw new \Exception("Sendy api_key not configured");
		}

		if(!isset($this->brand_id)) {
			throw new \Exception("Sendy brand_id not configured");
		}

	}

	public function campaignCreate(Campaign $campaign) {

		if($campaign->ready($this)) {

			$params = [
				'api_key' => $this->api_key,
				'from_name' => $campaign->from_name,
				'from_email' => $campaign->from_email,
				'reply_to' => $campaign->reply_to,
				'title' => $campaign->title,
				'subject' => $campaign->subject,
				'list_ids' => $campaign->list_ids,
				'send_campaign' => $campaign->send_campaign,
				'brand_id' => $campaign->brand_id,
				'query_string' => $campaign->query_string,
				'html_text' => $campaign->html_text,
				'plain_text' => $campaign->plain_text,
			];

			if($campaign->send_campaign === 0) {
				unset($params['list_ids']);
			} else {
				unset($params['brand_id']);
			}

			$client = new Client(['baseUrl' => $this->api_url]);
			unset($this->lastAnswer);

			$response = $client->post(
					'/api/campaigns/create.php', 
					$params)
				->setFormat(Client::FORMAT_URLENCODED)
				->send();

			$this->lastAnswer = $api->getData();

			if(isset($this->replies[$this->lastAnswer])) {
				$result = $this->replies[$this->lastAnswer];

				if($result) {

					switch($this->lastAnswer) {
						case 'Campaign created':
							return self::CAMPAIGN_PREVIEW_CREATED;
						break;

						case 'Campaign created and now sending':
							return self::CAMPAIGN_CREATED_AND_SENT;
						break;
					}
				}
			}

			return self::ERROR;

		} 
	}

	public function getLastAnswer() {
		return $this->lastAnswer;
	}

}