<?php

namespace Demo;

class Website {

    public function attemptPassword($password, $confirmPassword) {
        if (strlen($password) < 6 || strlen($confirmPassword) < 6) {
            return false;
        } else if (empty($password) || empty($confirmPassword)) {
            return false;
        } else if ($password != $confirmPassword) {
            return false;
        } else if (strlen($password) > 200 || strlen($confirmPassword) > 200) {
            return false;
        } else {
            return true; 
        }
    }

    public function attemptUsername($username) {
        if (empty($username)) {
            return false;
        } else if (strlen($username) > 200) {
            return false;
        } else {
            return true;
        }
    }

    public function attemptLogin($username, $password) {
        if ("username" === $username && "password" === $password) {
            return true;
        } else {
            return false; 
        }
    }

    public function attemptFullName($fullName) {
        if (empty($fullName)) {
            return false;
        } else if (strlen($fullName) > 50) {
            return false;
        } else {
            return true;
        }
    }

    public function attemptAddress($address) {
        if (empty($address)) {
            return false;
        } else if (strlen($address) > 100) {
            return false;
        } else {
            return true;
        }
    }

    public function attemptCity($city) {
        if (empty($city)) {
            return false;
        } else if (strlen($city) > 100) {
            return false;
        } else {
            return true;
        }
    }

    public function attemptState($state) {
        if (empty($state)) {
            return false;
        } else {
            return true;
        }
    }

    public function attemptZipCode($zip) {
        if (empty($zip)) {
            return false;
        } else if (strlen($zip) < 5 || strlen($zip) > 9) {
            return false;
        } else {
            return true;
        }
    }

    public function attemptRequestGallons($requestGallons) {
        if (empty($requestGallons)) {
            return false;
        } else if (!is_numeric($requestGallons)) {
            return false;
        } else if ($requestGallons > 100000) {
            return false;
        } else {
            return true;
        }
    }

    public function attemptDate($date) {
        if (empty($date)) {
            return false;
        } else if ($date < "2023-04-28") {
            return false;
        } else {
            return true;
        }
    }
}