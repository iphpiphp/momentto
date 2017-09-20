<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require realpath(FCPATH) . '/vendor/autoload.php';
use Aws\Ec2\Ec2Client;
use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Credentials\CredentialProvider;

class Aws {
	protected  $key = 'AKIAIUZRQN2M4XEEEDQA';
	protected  $secret_key = '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';
	protected  $bucket = 'thedays-resources';
	protected  $region = 'ap-northeast-2';
	protected  $s3path = 'resources/uploads/product/image/';
	protected  $profile = 'default';
	protected  $path = FCPATH.'/.aws/credentials';
	protected  $realFilePath =  FCPATH.'resources/uploads/product/temp/';

	function s3_download($item)
	{


		//$bucket = 'withvideo-resouces';
		//$key = 'AKIAIUZRQN2M4XEEEDQA';
		//$skye = "90YQcY8t4VfZYzghoos+0mVnXIqs7P5H5SJABhRF";
		//$region = "ap-northeast-2";
		$fileName = "B1000000000083341_kudomiyu_HD_The-Cat.mp4";
		$filepath = '/resources/uploads/product/image/';


		$result['status'] = "";
		$result['msg'] = "";
		$result['downloadUrl'] = "";

		//$db_data = $this->aws_model->s3_file_download();

		//걸리는게 있으면
		if( $db_data->num_rows() >= 1){
			$row = $db_data->row_array();
		}else{
			$result['status'] = "false";
			$result['msg'] = "해당 아이템이 없습니다.";
			$result['downloadUrl'] = "";
			$json_data = json_encode($result);
			print_r($json_data);
			exit;
		}

		//print_r($row);
		$fileName = $row['fileName'];
		//echo $fileName;
		$provider = CredentialProvider::ini();
		$provider = CredentialProvider::memoize($provider);

		$profile = 'default';
		$path = FCPATH.'/.aws/credentials';

		$provider = CredentialProvider::ini($profile, $path);
		$provider = CredentialProvider::memoize($provider);


		// Use the s3 buket config
		$sharedConfig['region'] = $region;
		$sharedConfig['version'] = 'latest';
		$sharedConfig['signature_version'] = 'v4';
		$sharedConfig['credentials'] = $provider;

		// Create an SDK class used to share configuration across clients.
		$sdk = new Aws\Sdk($sharedConfig);

		// Create an Amazon S3 client using the shared configuration data.
		$client = $sdk->createS3();

		try {
			ini_set('memory_limit','-1');

			// Get the object
			$command = $client->getCommand('GetObject', array(
				'Bucket' => $bucket,
				'Key' => $fileName,
				'ResponseContentDisposition' => 'attachment; filename='.$fileName
			));

			// Create a signed URL from the command object that will last for
			// 10 minutes from the current time
			$request  = $client->createPresignedRequest($command,'+10 minutes');

			$presignedUrl = (string) $request->getUri();

			$result['status'] = "true";
			$result['msg'] = "조회에 성공 하였습니다.";
			$result['downloadUrl'] = $presignedUrl;
			$json_data = json_encode($result);
			print_r($json_data);

		} catch (S3Exception $e) {
			//echo $e->getMessage() . "\n";
			$result['status'] = "flase";
			$result['msg'] =$e->getMessage(). "\n";
			$result['data'] = array();
			$json_data = json_encode($result);
			exit;
		}
	}

	function s3_upload($fileName, $s3path = null, $realFilePath = null)
	{
		if(!$s3path) $s3path = $this->s3path;
		if(!$realFilePath) $realFilePath = $this->realFilePath;

		// auth config
		$provider = CredentialProvider::ini();
		$provider = CredentialProvider::memoize($provider);
		$provider = CredentialProvider::ini($this->profile, $this->path);
		$provider = CredentialProvider::memoize($provider);

		// Use the s3 buket config
		$sharedConfig['region'] = $this->region;
		$sharedConfig['version'] = 'latest';
		$sharedConfig['signature_version'] = 'v4';
		$sharedConfig['credentials'] = $provider;

		// Create an SDK class used to share configuration across clients.
		$sdk = new Aws\Sdk($sharedConfig);

		// Create an Amazon S3 client using the shared configuration data.
		$client = $sdk->createS3();

		try {
			ini_set('memory_limit','-1');
			$result = $client->putObject(array(
				'Bucket'       => $this->bucket,
				'Key'          => $s3path.$fileName,  //오해 하지 말자. s3 폴더 위치이다
				'SourceFile'   => $realFilePath.$fileName,
				'ContentType'  => 'text/plain',
				'ACL'          => 'public-read',
				'StorageClass' => 'REDUCED_REDUNDANCY',
				'Metadata'     => array(
					'param1' => 'value 1',
					'param2' => 'value 2'
			)
			));
			//print_r($result);
			//$result['ObjectURL'];
			$result['status'] = "true";
		} catch (S3Exception $e) {
			$result['status'] = "flase";
			$result['msg'] =$e->getMessage(). "\n";
		}

		return $result;
	}

}//end
