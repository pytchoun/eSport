<?php

class User
{
  private $id;
  private $username;
  private $email;
  private $firstName;
  private $lastName;
  private $language;
  private $country;
  private $birthDate;
  private $gender;
  private $creationDate;
  private $presentation;
  private $facebook;
  private $twitter;
  private $twitch;
  private $youtube;
  private $isActive;
  private $isBanned;

  public function __construct(
    int $id, string $username, string $email, string $firstName,
    string $lastName, string $language, string $country, DateTime $birthDate,
    string $gender, DateTime $creationDate, string $presentation, string $facebook,
    string $twitter, string $twitch, string $youtube, int $isActive, int $isBanned
  )
  {
    $this->id = $id;
    $this->username = $username;
    $this->email = $email;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->language = $language;
    $this->country = $country;
    $this->birthDate = $birthDate;
    $this->gender = $gender;
    $this->creationDate = $creationDate;
    $this->presentation = $presentation;
    $this->facebook = $facebook;
    $this->twitter = $twitter;
    $this->twitch = $twitch;
    $this->youtube = $youtube;
    $this->isActive = $isActive;
    $this->isBanned = $isBanned;
  }

  public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getUsername(){
		return $this->username;
	}

	public function setUsername($username){
		$this->username = $username;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getFirstName(){
		return $this->firstName;
	}

	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}

	public function getLastName(){
		return $this->lastName;
	}

	public function setLastName($lastName){
		$this->lastName = $lastName;
	}

	public function getLanguage(){
		return $this->language;
	}

	public function setLanguage($language){
		$this->language = $language;
	}

	public function getCountry(){
		return $this->country;
	}

	public function setCountry($country){
		$this->country = $country;
	}

	public function getBirthDate(){
		return $this->birthDate;
	}

	public function setBirthDate($birthDate){
		$this->birthDate = $birthDate;
	}

	public function getGender(){
		return $this->gender;
	}

	public function setGender($gender){
		$this->gender = $gender;
	}

	public function getCreationDate(){
		return $this->creationDate;
	}

	public function setCreationDate($creationDate){
		$this->creationDate = $creationDate;
	}

	public function getPresentation(){
		return $this->presentation;
	}

	public function setPresentation($presentation){
		$this->presentation = $presentation;
	}

	public function getFacebook(){
		return $this->facebook;
	}

	public function setFacebook($facebook){
		$this->facebook = $facebook;
	}

	public function getTwitter(){
		return $this->twitter;
	}

	public function setTwitter($twitter){
		$this->twitter = $twitter;
	}

	public function getTwitch(){
		return $this->twitch;
	}

	public function setTwitch($twitch){
		$this->twitch = $twitch;
	}

	public function getYoutube(){
		return $this->youtube;
	}

	public function setYoutube($youtube){
		$this->youtube = $youtube;
	}

	public function getIsActive(){
		return $this->isActive;
	}

	public function setIsActive($isActive){
		$this->isActive = $isActive;
	}

	public function getIsBanned(){
		return $this->isBanned;
	}

	public function setIsBanned($isBanned){
		$this->isBanned = $isBanned;
	}
}
