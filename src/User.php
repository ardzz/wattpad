<?php

namespace Wattpad;

class User extends Authentication {

    /**
     * Set Wattpad Token
     * 
     * @return string
     */
    function setToken($token){
        return $this->wattpad_token = $token;
    }

    /**
     * Lookup user by username
     * 
     * @return array
     */
    function lookup($username){
        try {
            $lookup = $this->apiv3->request("GET", "users/{$username}", [
                "query" => [
                    "fields" => "username,description,avatar,name,email,genderCode,language,birthdate,verified,isPrivate,ambassador,is_staff,follower,following,backgroundUrl,votesReceived,numFollowing,numFollowers,createDate,followerRequest,website,facebook,twitter,followingRequest,numStoriesPublished,numLists,location,externalId,programs,showSocialNetwork,verified_email,has_accepted_latest_tos,highlight_colour,isBlockedByCurrentUser"
                ]
            ]);
            return json_decode($lookup->getBody()->getContents(), 1);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
            return json_decode($this->resultLookup = $response->getBody()->getContents(), 1);
        }
    }

    /**
     * Check if username exists
     * 
     * This method can be executed after you call @lookup
     * 
     * @return boolean
     */
    function isFound(){
        if (isset($this->resultLookup)) {
            $resultLookup = json_decode($this->resultLookup, 1);
            return (isset($resultLookup["error_code"]) ? false : true);
        }else{
            return false;
        }
    }

}