<?php
namespace Stackk\Aws;
require 'vendor/autoload.php';
use Aws\Batch\BatchClient;
use Aws\Batch\Exception\BatchException;

class AwsBatchApi {
	
	private $jobJson = array();
	private $aws_key = 'Your AWS Key';
	private $aws_secret = 'Your Secret key';
	private $client = '';
	
	#Initiate Constructor
	public function __construct()
	{	
		$this->client = BatchClient::factory(array(
		'region' => 'us-east-2',
		'version' => 'latest',
		'credentials' => [
					'key' => $this->aws_key, 
					'secret' => $this->aws_secret, 
			  ]
		));

	}
	
	#Build Job Data
	private function buildJob()
	{
		$this->jobJson['jobDefinition'] = 'cmp-trigger:1';
		$this->jobJson['jobName'] = 'Portiqo_campaign_trigger_2';
		$this->jobJson['jobQueue'] = 'first-run-job-queue';
		$this->jobJson['timeout']['attemptDurationSeconds'] = 300;
		$this->jobJson['retryStrategy']['attempts'] = 1;	
		
		$this->jobJson['containerOverrides']['vcpus'] = 1;
		$this->jobJson['containerOverrides']['memory'] = 512;
		
	}
	
	#Submit Job Data
	public function submitJob()
	{
		$response['status'] = 'fail';
		try {		
		$this->buildJob();
		$result = $this->client->submitJob($this->jobJson);
		$response['status'] = 'success';
		$result = $result->toArray();
		$response['data'] = $result;
		
		} catch (S3Exception $e) { 
			$response['message'] = $e->getMessage();
		}
		return json_encode($response);
		
		
	}
	
	#Garbage data object
	public function __destruct()
	{
		unset($this->jobJson);
		unset($this->client);
	}
}
$AwsBatchApi = new AwsBatchApi();
$response = $AwsBatchApi->submitJob();
echo "<pre>",print_r(json_decode($response,true));

