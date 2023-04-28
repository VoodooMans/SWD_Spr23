<?php

class WebsiteTest extends \PHPUnit\Framework\TestCase {
    public function testPassword() {
        $password = new Demo\Website;
        
        $result = $password->attemptPassword("","");
        $this->assertEquals(false, $result);
    }

    public function testPassword2() {
        $password = new Demo\Website;

        $result = $password->attemptPassword("winter","winter");
        $this->assertEquals(true, $result);
    }

    public function testPassword3() {
        $password = new Demo\Website;

        $result = $password->attemptPassword("winter","summer");
        $this->assertEquals(false, $result);
    }

    public function testPassword4() {
        $password = new Demo\Website;

        $result = $password->attemptPassword("when","when");
        $this->assertEquals(false, $result);
    }

    public function testPassword5() {
        $password = new Demo\Website;

        $result = $password->attemptPassword("BobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobby","BobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobby");
        $this->assertEquals(false, $result);
    }

    public function testLogin() {
        $login = new Demo\Website;

        $result = $login->attemptLogin("username","password");
        $this->assertEquals(true, $result);
    }

    public function testLogin2() {
        $login = new Demo\Website;

        $result = $login->attemptLogin("userName","PassWord");
        $this->assertEquals(false, $result);
    }

    public function testLogin3() {
        $login = new Demo\Website;

        $result = $login->attemptLogin("user","");
        $this->assertEquals(false, $result);
    }

    public function testUsername() {
        $username = new Demo\Website;
        
        $result = $username->attemptUsername("");
        $this->assertEquals(false, $result);
    }

    public function testUsername2() {
        $username = new Demo\Website;
        
        $result = $username->attemptUsername("username");
        $this->assertEquals(true, $result);
    }    

    public function testUsername3() {
        $username = new Demo\Website;
        
        $result = $username->attemptUsername("BobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobbyBobby");
        $this->assertEquals(false, $result);
    }

    public function testFullName() {
        $name = new Demo\Website;

        $result = $name->attemptFullName("");
        $this->assertEquals(false, $result);
    }

    public function testFullName2() {
        $name = new Demo\Website;

        $result = $name->attemptFullName("kefjkwnfkjwenfkjnewkfjnewkjfnekjwbfkjwbkhgebwkhgjbkejwgb");
        $this->assertEquals(false, $result);
    }

    public function testFullName3() {
        $name = new Demo\Website;

        $result = $name->attemptFullName("Keith Richard");
        $this->assertEquals(true, $result);
    }

    public function testAddress() {
        $address = new Demo\Website;

        $result = $address->attemptAddress("");
        $this->assertEquals(false, $result);
    }

    public function testAddress2() {
        $address = new Demo\Website;

        $result = $address->attemptAddress("kefjkwnfkjwenfkjnewkfjnewkjfnekjwbfkjwbkhgebwkhgjbkejwgbgkjrwhgkwujgjkwbgjkwbrgjewjkbgkejwbgegwklgnwelkg");
        $this->assertEquals(false, $result);
    }

    public function testAddress3() {
        $address = new Demo\Website;

        $result = $address->attemptAddress("123 Maple Street");
        $this->assertEquals(true, $result);
    }

    public function testCity() {
        $city = new Demo\Website;

        $result = $city->attemptCity("");
        $this->assertEquals(false, $result);
    }

    public function testCity2() {
        $city = new Demo\Website;

        $result = $city->attemptCity("kefjkwnfkjwenfkjnewkfjnewkjfnekjwbfkjwbkhgebwkhgjbkejwgbgkjrwhgkwujgjkwbgjkwbrgjewjkbgkejwbgegwklgnwelkg");
        $this->assertEquals(false, $result);
    }

    public function testCity3() {
        $city = new Demo\Website;

        $result = $city->attemptCity("Chicago");
        $this->assertEquals(true, $result);
    }

    public function testState() {
        $state = new Demo\Website;

        $result = $state->attemptState("");
        $this->assertEquals(false, $result);
    }

    public function testState2() {
        $state = new Demo\Website;

        $result = $state->attemptState("IL");
        $this->assertEquals(true, $result);
    }

    public function testZipCode() {
        $zip = new Demo\Website;

        $result = $zip->attemptZipCode("");
        $this->assertEquals(false, $result);
    }

    public function testZipCode2() {
        $zip = new Demo\Website;

        $result = $zip->attemptZipCode("123");
        $this->assertEquals(false, $result);
    }

    public function testZipCode3() {
        $zip = new Demo\Website;

        $result = $zip->attemptZipCode("1234567890");
        $this->assertEquals(false, $result);
    }

    public function testZipCode4() {
        $zip = new Demo\Website;

        $result = $zip->attemptZipCode("12345");
        $this->assertEquals(true, $result);
    }

    public function testRequestGallons() {
        $gallons = new Demo\Website;

        $result = $gallons->attemptRequestGallons("");
        $this->assertEquals(false, $result);
    }

    public function testRequestGallons2() {
        $gallons = new Demo\Website;

        $result = $gallons->attemptRequestGallons("wind");
        $this->assertEquals(false, $result);
    }

    public function testRequestGallons3() {
        $gallons = new Demo\Website;

        $result = $gallons->attemptRequestGallons("123");
        $this->assertEquals(true, $result);
    }

    public function testRequestGallons4() {
        $gallons = new Demo\Website;

        $result = $gallons->attemptRequestGallons("110000");
        $this->assertEquals(false, $result);
    }

    public function testDate() {
        $date = new Demo\Website;

        $result = $date->attemptDate("");
        $this->assertEquals(false, $result);
    }

    public function testDate2() {
        $date = new Demo\Website;

        $result = $date->attemptDate("2023-04-28");
        $this->assertEquals(true, $result);
    }

    public function testDate3() {
        $date = new Demo\Website;

        $result = $date->attemptDate("2023-04-25");
        $this->assertEquals(false, $result);
    }
}
