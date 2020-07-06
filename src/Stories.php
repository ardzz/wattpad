<?php

/**
 * Wattpad API
 * 
 * @author Ardan <ardzz@indoxploit.or.id>
 * @package library
 * @license MIT
 */

namespace Wattpad;

class Stories extends Request {

    /**
     * Search stories by query
     * 
     * @param $query        Title of story
     * @param $limit        Limit output from result
     * @return array
     */

    function searchStories($query, $limit = 120){
        $searchStories = $this->apiv4->request("GET", "search/stories", [
            "query" => [
                "query"    => $query,
                "limit"    => $limit,
                "language" => "20",
                "fields"   => "stories(id,title,voteCount,readCount,numParts,tags,description,user,cover,promoted,isPaywalled,sponsor(name,avatar),tracking(clickUrl,impressionUrl,thirdParty(impressionUrls,clickUrls)),contest(endDate,ctaLabel)),tags,nextUrl"
            ]
        ]);
        return json_decode($searchStories->getBody()->getcontents(), 1);
    }

    /**
     * Lookup Story by id story
     * 
     * To get id story you can use @Wattpadd\Stories\link2id()
     * First share the story then copy link, and put the link into above function
     * Or you can get id story by searching story using @Wattpadd\Stories\searchStories(), output will be contained id of story
     * 
     * @param string|integer $id        Id Story
     */
    function lookupStory($id){
        $lookupStory = $this->apiv3->request("GET", "stories/" . $id, [
            "query" => [
                "drafts" => 0,
                "include_deleted" => 1,
                "fields" => "id,title,length,createDate,modifyDate,voteCount,readCount,commentCount,promoted,sponsor,language,user,description,cover,highlight_colour,completed,isPaywalled,categories,numParts,readingPosition,deleted,dateAdded,lastPublishedPart(createDate),tags,copyright,rating,story_text_url(text),,parts(id,title,voteCount,commentCount,videoId,readCount,photoUrl,modifyDate,length,voted,deleted,text_url(text),dedication)"
            ],
            "verify" => false,
        ]);

        $this->story = json_decode($lookupStory->getBody()->getcontents(), 1);
        return $this;
    }

    /**
     * Get Title
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getTitle(){
        if($this->isStoryExists()){
            return $this->story["title"];
        }else{
            return false;
        }
    }

    /**
     * Get Vote Count of Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getVoteCount(){
        if($this->isStoryExists()){
            return $this->story["voteCount"];
        }else{
            return false;
        }
    }

    /**
     * Get Read Count of Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getReadCount(){
        if($this->isStoryExists()){
            return $this->story["readCount"];
        }else{
            return false;
        }
    }

    /**
     * Get Comment Coung of Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getCommentCount(){
        if($this->isStoryExists()){
            return $this->story["commentCount"];
        }else{
            return false;
        }
    }

    /**
     * Get Usermane of Author Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getUserName(){
        if($this->isStoryExists()){
            return $this->story["user"]["name"];
        }else{
            return false;
        }
    }

    /**
     * Get User Avatar of Author Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getUserAvatar(){
        if($this->isStoryExists()){
            return $this->story["user"]["avatar"];
        }else{
            return false;
        }
    }

    /**
     * Get Full Name of Author Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getUserFullName(){
        if($this->isStoryExists()){
            return $this->story["user"]["fullname"];
        }else{
            return false;
        }
    }

    /**
     * Get Description of Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getDescription(){
        if($this->isStoryExists()){
            return $this->story["description"];
        }else{
            return false;
        }
    }

    /**
     * Get Cover of Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getCover(){
        if($this->isStoryExists()){
            return $this->story["cover"];
        }else{
            return false;
        }
    }

    /**
     * Check if Part of Story is Completed or Not
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function isCompleted(){
        if($this->isStoryExists()){
            return (boolean) $this->story["completed"];
        }else{
            return false;
        }
    }

    /**
     * Get Tags of Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getTags(){
        if($this->isStoryExists()){
            return $this->story["tags"];
        }else{
            return false;
        }
    }

    /**
     * Get Parts of Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getParts(){
        if($this->isStoryExists()){
            return $this->story["parts"];
        }else{
            return false;
        }
    }

    /**
     * Get Full Parts of Story / Get Full Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function getFullParts($no_html_tag = true){
        $parts  = $this->getParts();
        $output = [];
        if ($parts) {
            foreach ($parts as $key => $value) {
                $part = $this->getPart($value["id"]);
                $output[] = $no_html_tag ? strip_tags($part["text"]) : $part["text"];
            }
            return implode(PHP_EOL, $output);
        }else{
            return false;
        }
    }

    /**
     * Check if Story if Paywalled or Not
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function isPaywalled(){
        if($this->isStoryExists()){
            return $this->story["isPaywalled"];
        }else{
            return false;
        }
    }

    /**
     * Check if Story Exists or Not
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array|boolean
     */

    function isStoryExists(){
        return isset($this->story);
    }

    /**
     * Private method, get string between two characters
     * 
     * @return array|boolean
     */

    private function getString($str, $find_start, $find_end) {
		$start = @strpos($str, $find_start);
		if (!$start) {
			return false;
		}
		$length = strlen($find_start);
		$end    = strpos(substr($str, $start + $length), $find_end);
		return trim(substr($str, $start + $length, $end));
	}

    /**
     * Get id Story from shared link
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return string
     */

    function link2id($link){
        $id = $this->getString($link . "wattpad", "my.w.tt/", "wattpad");
        if ($id) {
            $link2id = (new \GuzzleHttp\Client(["base_uri" => "https://my.w.tt/"]))->request("GET", $id, [
                "allow_redirects" => false,
                "verify" => false,
                //"proxy" => "127.0.0.1:8080"
            ]);
            $id_stories = $this->getString($link2id->getHeader("Location")[0], "wattpad.com/story/", "?utm_source");
            return $id_stories;
        } else {
            return false;
        }
    }

    /**
     * Get Part of Story
     * 
     * This method can be executed after you call @lookupStory
     * 
     * @return array
     */

    function getPart($id){
        $part = $this->apiv2->request("GET", "storytext", [
            "query" => [
                "id" => $id,
                "include_paragraph_id" => "1",
                "output" => "json"
            ]
        ]);
        return json_decode($part->getBody()->getContents(), 1);
    }

}