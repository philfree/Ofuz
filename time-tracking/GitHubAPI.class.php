<?php
/*
 *
 * key and description are from GitHub settings.
 */

class GitHubAPI {
	private $api_endpoint;
	private $authorization_key;
	private $authorization_key_description;
	private $queryJSON;
	public $organization;
	public $repository;
	//private $git_api_access_token = "fda0312c2fbc063ba3159b0b681258efd3c1d895"; // old one
	//private $git_api_access_token = "cda569f9091a1c50cec13548b5eba8c44b2b9593";
	private $git_api_access_token = "f72bc253cf41c2ee5dec088ef4b53ab23ed37709";

	function __construct() {
		$this->api_endpoint = "https://api.github.com/graphql";
		//$this->authorization_key = $_SERVER['GitHub_API_ACCESS_TOKEN'];
		$this->authorization_key = $this->git_api_access_token;
		$this->authorization_key_description = "WorklogTracking";
	}

	/*
	 *
	 */
	function processQuery() {
		$authorization = 'Authorization: bearer '.$this->authorization_key;
		$header = array(
						'Content-Type: application/json',
						'User-Agent: '.$this->authorization_key_description,
						$authorization
					);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->api_endpoint);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS,$this->queryJSON);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}

	/*
	 *
	 */
	function setQuery($query) {
		$this->queryJSON = $query;
	}

	/*
	 * Makes a POST request with a JSON payload.
	 * Payload must contain a string called "query"
	 * This makes a request to fetch 100 Issues and each Issue's 100 Comments with other relevant information.
	 * One query JSON request with pagination cursor to read more than 100 Issues.
	 *
	 * @param string : $issues_cursor : default empty or pagination cursor
	 * @return JSON object
	 */
	public function getAllIssues($issues_cursor) {

		if($issues_cursor) {
			$query = '{"query": "query { repository(owner:\"'.$this->organization.'\", name:\"'.$this->repository.'\") {id, issues(first:100 after:\"'.$issues_cursor.'\") { totalCount nodes { id title url comments(first:100) { totalCount nodes { id createdAt author{ login } bodyText } } } pageInfo {endCursor hasNextPage} } } }"}'; 
		} else {
			$query = '{"query": "query { repository(owner:\"'.$this->organization.'\", name:\"'.$this->repository.'\") {id, issues(first:100) { totalCount nodes { id title url comments(first:100) { totalCount nodes { id createdAt author{ login } bodyText } } } pageInfo {endCursor hasNextPage} } } }"}'; 
		}

		$this->setQuery($query);
		$data = $this->processQuery();
		//print_r($data);exit();
		return $data;
	}

	/*
	 * Makes a POST request with a JSON payload.
	 * Payload must contain a string called "query"
	 * This makes a request to fetch 100 Pull Requests and each Pull Request's 100 Comments with other relevant information.
	 * One query JSON request with pagination cursor to read more than 100 Pull Requests.
	 *
	 * @param string : $pull_request_cursor : default empty or pagination cursor
	 * @return JSON object
	 */
	public function getAllPullRequests($pull_request_cursor) {

		if($pull_request_cursor) {
			$query = '{"query": "query { repository(owner:\"'.$this->organization.'\", name:\"'.$this->repository.'\") {id, pullRequests(first:100 after:\"'.$pull_request_cursor.'\") { totalCount nodes { id title url comments(first:100) { totalCount nodes { id createdAt author{ login } bodyText } } } pageInfo {endCursor hasNextPage} } } }"}'; 
		} else {
			$query = '{"query": "query { repository(owner:\"'.$this->organization.'\", name:\"'.$this->repository.'\") {id, pullRequests(first:100) { totalCount nodes { id title url comments(first:100) { totalCount nodes { id createdAt author{ login } bodyText } } } pageInfo {endCursor hasNextPage} } } }"}'; 
		}

		$this->setQuery($query);
		$data = $this->processQuery();
		return $data;
	}

	/*
	 *
	 */
	function jsonDecode($data) {
		$data = json_decode($data);
		return $data;
	}
 
}
?>