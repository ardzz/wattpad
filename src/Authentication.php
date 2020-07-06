<?php

/**
 * Wattpad API
 * 
 * @author Ardan <ardzz@indoxploit.or.id>
 * @package library
 * @license MIT
 */

namespace Wattpad;

class Authentication extends Request {

    /**
     * Login
     * 
     * @param string $username
     * @param string $password
     * @return array
     */

    function login($username, $password){
        try {
            $login = $this->apiv4->request("POST", "sessions", [
                "http_error" => true,
                "form_params" => [
                    "type"     => "wattpad",
                    "username" => $username,
                    "password" => $password,
                    "fields"   => "token,ga,user(username,description,avatar,name,email,genderCode,language,birthdate,verified,isPrivate,ambassador,is_staff,follower,following,backgroundUrl,votesReceived,numFollowing,numFollowers,createDate,followerRequest,website,facebook,twitter,followingRequest,numStoriesPublished,numLists,location,externalId,programs,showSocialNetwork,verified_email,has_accepted_latest_tos,language,inbox(unread),has_password,connectedServices)"
                ]
            ]);
            return json_decode($this->resultLogin = $login->getBody()->getContents(), 1);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
            return json_decode($this->resultLogin = $response->getBody()->getContents(), 1);
        }
    }

    /**
     * Check if login success
     * 
     * @return boolean
     */
    function isLoginSuccess(){
        if (isset($this->resultLogin)) {
            $resultLogin = json_decode($this->resultLogin, 1);
            return (isset($resultLogin["error_code"]) ? false : true);
        }else{
            return false;
        }
    }

    /**
     * Get Wattpad Token
     * 
     * @return boolean|string
     */
    function getToken(){
        if ($this->isLoginSuccess()) {
            return ($this->wattpad_token = json_decode($this->resultLogin, 1)["token"]);
        }else{
            return false;
        }
    }

    /**
     * Self lookup
     * 
     * @return array|boolean
     */
    function getUser(){
        if ($this->isLoginSuccess()) {
            return json_decode($this->resultLogin, 1)["user"];
        } else {
            return false;
        }
        
    }

}