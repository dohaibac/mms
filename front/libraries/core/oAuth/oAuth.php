<?php
jimport('core.oAuth.OAuth2'); class JOAuth extends JOAuth2{ protected function checkClientCredentials($client_id, $client_secret = NULL) { } protected function getRedirectUri($client_id) { } protected function getAccessToken($oauth_token) { } protected function setAccessToken($oauth_token, $client_id, $expires, $scope = NULL) { } protected function getSupportedGrantTypes() { } protected function getAuthCode($code) { } protected function setAuthCode($code, $client_id, $redirect_uri, $expires, $scope = NULL) { } }