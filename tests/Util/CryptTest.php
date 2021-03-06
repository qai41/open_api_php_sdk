<?php

namespace Tests\Util;

use Stone\SDK\Util\Crypt;
use PHPUnit\Framework\TestCase;

class CryptTest extends TestCase
{
    private $pub_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDB06AKf8BkttWLir3vh4qPoORj
GumSIJGaGQ4/P4gnZchxCncZmjhnwwOHt4VANlkmK9M31/HdNyrr6s547/qUWqZB
4nq0BOO/fpW+DTDIyF4Ki9MHPx7nj15feFHRx9dxvhGeueCFohYrvVBdMdVL3mCC
MQR9IiSw+0+kcdjooQIDAQAB
-----END PUBLIC KEY-----';

    private $private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDB06AKf8BkttWLir3vh4qPoORjGumSIJGaGQ4/P4gnZchxCncZ
mjhnwwOHt4VANlkmK9M31/HdNyrr6s547/qUWqZB4nq0BOO/fpW+DTDIyF4Ki9MH
Px7nj15feFHRx9dxvhGeueCFohYrvVBdMdVL3mCCMQR9IiSw+0+kcdjooQIDAQAB
AoGATR0/PS4ag3dieoQWkSfh7sbaVrusVeDzTNXPH0bNiq8qEh9RxzPeYRnrW6Ge
OC/nRBKHlF4r8hEy2G2w+9iuXoonyhVEs3MkrvdWolXdMXkWLUHZZ1kn9UY0H368
sf3UsfB35/XFYJYhVjsff4kcmS/i1v83eR8s/gTjl6UDCgECQQDsnFUmcK1fvq3k
egFJVLh0XmqfDAmI2HI0uChuy6EGoEUORoYnZrgJY0AxqxOB3qoQVMO9M8LtvgQv
nge/jdSRAkEA0bXCvdGBWsfGafa51ZiPbpHuqqy0rb19e2OceHLNWZtmrmaSrLJp
UXBocr/UbqvGbApNRHypGFHjTrs/kxqbEQJBAKlNm6grzALMf8USf8Um9+1cedJg
XJostlt+wn+0+P2yxHbYg7nByEH/YLmpfgXZe7q/zGefmAVhh8FCxKyOIeECQDI4
ApCOMRnaKUuKx+m8hOyHic3ZWdMZQ4ley0OUylQhAK/W5FzyxIG6F2kTQv3VqMiK
lwJFkADA61wZPxotDuECQQDTeT/QDQ0zR3kAgTo4mN0xMfSUL4Qrocawb/QMHUsJ
7Fjr5P4Utl5F+17mqWEm7ArSsAHWf7x9h03rzFK49NFE
-----END RSA PRIVATE KEY-----';

    public function testPartnerEncrypt()
    {
        $params = [
            'appId' => '123123123',
            'outTradeNo' => '456456456456234',
        ];
        $encrypted = Crypt::partnerEncrypt($params, $this->pub_key);
        //var_dump($encrypted);

        $data = Crypt::platformDecrypt($encrypted, $this->private_key);
        //var_dump($data);

        $this->assertEquals($params, $data);
    }

    public function testPartnerDecrypt()
    {
        $response = [
            'code' => 0,
            'message' => 'OK',
            'data' => [
                'id' => '1',
                'name' => 'xxxx',
            ],
        ];
        $encrypted = Crypt::platformEncrypt($response, $this->private_key);

        $data = Crypt::partnerDecrypt($encrypted, $this->pub_key);

        $this->assertEquals($response, $data);
    }
}
