<?  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once FCPATH. '/vendor/autoload.php';

//require_once 'Google/Client.php';
//require_once 'Google/Service/YouTube.php';

trait Constants{
	//$scope =  implode(' ', array( Google_Service_People::CONTACTS_READONLY));
	//define('SCOPES', implode(' ', array(  Google_Service_People::CONTACTS_READONLY)));
	
}

class Google extends CI_Controller 
{
	function __construct()	
	{
		parent::__construct();
		$this->output->enable_profiler(true);
	}
	
	public function _remap($method)
	{
		$this->segs = $this->uri->segment_array();
		
		//if (php_sapi_name() != 'cli')  throw new Exception('This application must be run on the command line.');
		
		$data = array();
		if($this->input->is_ajax_request()){
			if( method_exists($this, $method) ) {
				$this->{"{$method}"}();
			}else{
				//없는 메소드 호출
			}
		}else{ //ajax가 아니면
			//$this->load->view($location."/common/header");
			if( method_exists($this, $method) ) $this->{"{$method}"}();
			//$this->load->view($location."/common/footer");
			//$this->output->enable_profiler(true);
		}
	}
	
	function getClient()
	{
		define('SCOPES', implode(' ', array(  Google_Service_People::CONTACTS_READONLY)));

		$client = new Google_Client();
		$client->setApplicationName(APPLICATION_NAME);
		$client->setScopes(SCOPES);
		$client->setAuthConfig(CLIENT_SECRET_PATH);
		$client->setAccessType('offline');
		// Load previously authorized credentials from a file.
		$credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
		if (file_exists($credentialsPath)) {
			$accessToken = json_decode(file_get_contents($credentialsPath), true);
		} else {
			// Request authorization from the user.
			$authUrl = $client->createAuthUrl();
			printf("Open the following link in your browser:\n%s\n", $authUrl);
			print 'Enter verification code: ';
			$authCode = trim(fgets(STDIN));

			// Exchange authorization code for an access token.
			$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

			// Store the credentials to disk.
			if(!file_exists(dirname($credentialsPath))) {
				mkdir(dirname($credentialsPath), 0700, true);
			}
			file_put_contents($credentialsPath, json_encode($accessToken));
			printf("Credentials saved to %s\n", $credentialsPath);
		}
		
		$client->setAccessToken($accessToken);
		// Refresh the token if it's expired.
		if ($client->isAccessTokenExpired()) {
			$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
		}
		return $client;
		
	}
	/**
	 * Expands the home directory alias '~' to the full path.
	 * @param string $path the path to expand.
	 * @return string the expanded path.
	 */
	function expandHomeDirectory($path) 
	{
	  $homeDirectory = getenv('HOME');
	  if (empty($homeDirectory)) {
		$homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
	  }
	  return str_replace('~', realpath($homeDirectory), $path);
	}
	
	function index()
	{

		// Get the API client and construct the service object.
		$client = $this->getClient();
		$service = new Google_Service_People($client);

		// Print the names for up to 10 connections.
		$optParams = array(
		  'pageSize' => 10
		);
		$results = $service->people_connections->listPeopleConnections('people/me', $optParams);

		if (count($results->getConnections()) == 0) {
		  print "No connections found.\n";
		} else {
		  print "People:\n";
		  foreach ($results->getConnections() as $person) {
			if (count($person->getNames()) == 0) {
			  print "No names found for this connection\n";
			} else {
			  $names = $person->getNames();
			  $name = $names[0];
			  printf("%s\n", $name->getDisplayName());
			}
		  }
		}
	}
	
	function auth(){
		//define('SCOPES', implode(' ', array(  Google_Service_People::CONTACTS_READONLY)));
		
		//Create Client Request to access Google API
		$client = new Google_Client();
		$client->setApplicationName(APPLICATION_NAME); //app name
		$client->setAuthConfig(CLIENT_SECRET_PATH); //credent file
		//$client->setAccessType('online'); // default: offline
		//$client->setAccessType("offline");
		$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
		
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google/oauth2callback';
		  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

		
		if (isset($this->session->userdata['access_token']) && $this->session->userdata['access_token']) {
		  $client->setAccessToken($this->session->userdata['access_token']);
		  $drive_service = new Google_Service_Drive($client);
		  $files_list = $drive_service->files->listFiles(array())->getItems();
		  echo json_encode($files_list);
		} else {
		  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google/oauth2callback';
		  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}
	
	}
	
	function oauth2callback()
	{
		$client = new Google_Client();		
		$client->setAuthConfig(CLIENT_SECRET_PATH); //credent file
		$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/google/oauth2callback');
		$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
		//$client->setAccessType("offline");
		
		

		if(!isset($_GET['code'])) {
		  $auth_url = $client->createAuthUrl();
		  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
		} else {
			$client->authenticate($_GET['code']);
			$this->session->set_userdata('access_token', $client->getAccessToken());
			$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/google/auth_info';
			
			echo "<pre>"; print_r($client); echo "</pre>";
			//header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}
		
	}

	function yb(){
		$client = new Google_Client();
		$client->setApplicationName(APPLICATION_NAME);
		$client->setAuthConfig(CLIENT_SECRET_PATH);
		$client->setScopes('https://www.googleapis.com/auth/youtube');
		$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);
		$client->setRedirectUri($redirect);
		// Define an object that will be used to make all API requests.
		$youtube = new Google_Service_YouTube($client);
		// Check if an auth token exists for the required scopes
		$tokenSessionKey = 'token-' . $client->prepareScopes();
		
		$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],  FILTER_SANITIZE_URL);
		$client->setRedirectUri($redirect);
		$youtube = new Google_Service_YouTube($client);
		
		//echo "<pre>"; print_r($youtube);		exit;

		$htmlBody = "";
		
		$tokenSessionKey = 'token-' . $client->prepareScopes();
		if (isset($_GET['code'])) {
		  if (strval($this->session->userdata['state']) !== strval($_GET['state'])) {
			die('The session state did not match.');
		  }
		  $client->authenticate($_GET['code']);
		  //$_SESSION[$tokenSessionKey] = $client->getAccessToken();
			$this->session->set_userdata($tokenSessionKey, $client->getAccessToken());
		  header('Location: ' . $redirect);
		}
		if (isset($this->session->userdata[$tokenSessionKey])) {
		  $client->setAccessToken($this->session->userdata[$tokenSessionKey]);
		}
		// Check to ensure that the access token was successfully acquired.
		if ($client->getAccessToken()) {
		  $htmlBody = '';
		  try{
			  $listResponse = $youtube->channels->listChannels('brandingSettings', array('mine' => true));
			  $channel = $listResponse['items'][0];
			   // REPLACE this value with the path to the file you are uploading.
				$videoPath = FCPATH."/contents/file.mp4";

			  //$videoPath = "https://thedays-movie-seoul.s3.ap-northeast-2.amazonaws.com/B1000000000563201_kudomiyu_HD_Wedding-Opening-01.mp4";

				// Create a snippet with title, description, tags and category ID
				// Create an asset resource and set its snippet metadata and type.
				// This example sets the video's title, description, keyword tags, and
				// video category.
				$snippet = new Google_Service_YouTube_VideoSnippet();
				$snippet->setTitle("Test title");
				$snippet->setDescription("Test description");
				$snippet->setTags(array("tag1", "tag2"));

				// Numeric video category. See
				// https://developers.google.com/youtube/v3/docs/videoCategories/list
				$snippet->setCategoryId("22");

				// Set the video's status to "public". Valid statuses are "public",
				// "private" and "unlisted".
				$status = new Google_Service_YouTube_VideoStatus();
				$status->privacyStatus = "public";

				// Associate the snippet and status objects with a new video resource.
				$video = new Google_Service_YouTube_Video();
				$video->setSnippet($snippet);
				$video->setStatus($status);

				// Specify the size of each chunk of data, in bytes. Set a higher value for
				// reliable connection as fewer chunks lead to faster uploads. Set a lower
				// value for better recovery on less reliable connections.
				$chunkSizeBytes = 1 * 1024 * 1024;

				// Setting the defer flag to true tells the client to return a request which can be called
				// with ->execute(); instead of making the API call immediately.
				$client->setDefer(true);

				// Create a request for the API's videos.insert method to create and upload the video.
				$insertRequest = $youtube->videos->insert("status,snippet", $video);

				// Create a MediaFileUpload object for resumable uploads.
				$media = new Google_Http_MediaFileUpload(
					$client,
					$insertRequest,
					'video/*',
					null,
					true,
					$chunkSizeBytes
				);
				$media->setFileSize(filesize($videoPath));


				// Read the media file and upload it chunk by chunk.
				$status = false;
				$handle = fopen($videoPath, "rb");
				while (!$status && !feof($handle)) {
				  $chunk = fread($handle, $chunkSizeBytes);
				  $status = $media->nextChunk($chunk);
				}

				fclose($handle);

				// If you want to make other calls after the file upload, set setDefer back to false
				$client->setDefer(false);


				$htmlBody .= "<h3>Video Uploaded</h3><ul>";
				$htmlBody .= sprintf('<li>%s (%s)</li>',
					$status['snippet']['title'],
					$status['id']);

				$htmlBody .= '</ul>';

		  } catch (Google_Service_Exception $e) {
			//$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));

			 $err =json_decode($e->getMessage());
			 $domain =  $err->error->errors[0]->domain;
			 $reason =  $err->error->errors[0]->reason;
			 $message = $err->error->errors[0]->message;

			  if($domain=='youtube.header' && $reason = 'youtubeSignupRequired' &&  $message = 'Unauthorized' ){
				  echo "not channels... create youtube channel!";
				  $this->_add_channels($youtube);


				  //$listResponse = $youtube->channels->listChannels('brandingSettings', array('mine' => true));
			  }



		  } catch (Google_Exception $e) {
			$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
		  }
			$_SESSION[$tokenSessionKey] = $client->getAccessToken();
		}else {
		  // If the user hasn't authorized the app, initiate the OAuth flow
		  $state = mt_rand();
		  $client->setState($state);
		  //$_SESSION['state'] = $state;
		  $this->session->set_userdata('state', $state);
		
		  $authUrl = $client->createAuthUrl();
		  $htmlBody = '
		<h3>Authorization Required</h3>
		<p>You need to <a href="'.$authUrl.'">authorize access</a> before proceeding.<p>
		';
		}
		
		echo $htmlBody;

	}

	function _get_client($scopes = null,  $redirect = null)
	{
		$client = new Google_Client();
		$client->setApplicationName(APPLICATION_NAME);
		$client->setAuthConfig(CLIENT_SECRET_PATH);
		if(!$scopes) {
			$client->setScopes('https://www.googleapis.com/auth/youtube');
		}else{
			$client->setScopes($scopes);
		}

		if(!$redirect){
			$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);
		}
		$client->setRedirectUri($redirect);

		return $client;
	}


	function ch(){

		$client = $this->_get_client();
		$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], FILTER_SANITIZE_URL);

		// Check if an auth token exists for the required scopes
		$tokenSessionKey = 'token-' . $client->prepareScopes();
		$youtube = new Google_Service_YouTube($client);

		$htmlBody = "";

		if (isset($_GET['code'])) {
		  if (strval($this->session->userdata['state']) !== strval($_GET['state'])) {
			die('The session state did not match.');
		  }
		  $client->authenticate($_GET['code']);
		  //$_SESSION[$tokenSessionKey] = $client->getAccessToken();
			$this->session->set_userdata($tokenSessionKey, $client->getAccessToken());
		  header('Location: ' . $redirect);
		}
		if (isset($this->session->userdata[$tokenSessionKey])) {
		  $client->setAccessToken($this->session->userdata[$tokenSessionKey]);
		}
		// Check to ensure that the access token was successfully acquired.
		if ($client->getAccessToken()) {
			try{

			  $channelsResponse = $youtube->channels->listChannels('brandingSettings', array('mine' => 'true',));
			  if(!isset($channelsResponse->items[0]['modelData']['brandingSettings'])) {
				  echo "no channel....";
				  //$this->_add_channels($youtube);
				  //redirect('/google/add_channels', 'refresh');

			  }else{


				  //$channelsResponse = $youtube->channels->listChannels('contentDetails', array('mine' => 'true',));
				  $channelsResponse = $youtube->channelSections->listChannelSections('contentDetails', array('mine' => 'true',));

				  foreach ($channelsResponse['items'] as $channel) {
					  echo $channel['id']."<br/>";
					  //$youtube->channelSections->delete($channel['id']);

				  }
			  }

			 $channelsResponse = $youtube->activities->listActivities('contentDetails', array('mine' => 'true',));



			echo"response == <pre>";  print_r($channelsResponse);
			$htmlBody = '';
			foreach ($channelsResponse['items'] as $channel) {
			  // Extract the unique playlist ID that identifies the list of videos
			  // uploaded to the channel, and then call the playlistItems.list method
			  // to retrieve that list.
			  $uploadsListId = $channel['contentDetails']['relatedPlaylists']['uploads'];

			  $playlistItemsResponse = $youtube->playlistItems->listPlaylistItems('snippet', array(
				'playlistId' => $uploadsListId,
				'maxResults' => 50
			  ));

			  $htmlBody .= "<h3>Videos in list $uploadsListId</h3><ul>";
			  foreach ($playlistItemsResponse['items'] as $playlistItem) {
				$htmlBody .= sprintf('<li>%s (%s)</li>', $playlistItem['snippet']['title'],
				  $playlistItem['snippet']['resourceId']['videoId']);
			  }
			  $htmlBody .= '</ul>';
			}
		  } catch (Google_Service_Exception $e) {
			$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));

			  $err=json_decode(htmlspecialchars($e->getMessage()));
			  print_r($err);


		  } catch (Google_Exception $e) {
			$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
		  }
			//$_SESSION[$tokenSessionKey] = $client->getAccessToken();
			$this->session->set_userdata($tokenSessionKey, $client->getAccessToken());
		}else {
		  // If the user hasn't authorized the app, initiate the OAuth flow
		  $state = mt_rand();
		  $client->setState($state);
		  //$_SESSION['state'] = $state;
		  $this->session->set_userdata('state', $state);

		  $authUrl = $client->createAuthUrl();
		  $htmlBody = '
		<h3>Authorization Required</h3>
		<p>You need to <a href="'.$authUrl.'">authorize access</a> before proceeding.<p>
		';
		}
		
		echo $htmlBody;

	}
}
