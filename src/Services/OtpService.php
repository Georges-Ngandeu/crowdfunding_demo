<?php

namespace App\Services;

use App\Entity\OtpLine;
use App\Entity\OtpSegment;
use App\Exception\OtpException;
use App\Manager\OtpLineManager;
use App\Manager\OtpSegmentManager;
use App\Manager\ParamsManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

/* @class service curl http service */
class OtpService
{

    private $otpLineManager;

    private $otpSegmentManager;

    private $http;

    private $params;
    /**
     * @var EntityManagerInterface
     */
    private $entityManagerInterface;


    public function __construct(OtpLineManager $otpLineManager,
                                OtpSegmentManager $otpSegmentManager,
                                HttpService $http,
                                ContainerBagInterface $params,
                                EntityManagerInterface $entityManagerInterface)
    {

        $this->otpLineManager = $otpLineManager;

        $this->otpSegmentManager = $otpSegmentManager;

        $this->http = $http;

        $this->params = $params;

        $this->entityManagerInterface = $entityManagerInterface;
    }


    public function generateOtpLine(string $segment, string $identity, ?string $mobile, ?string $email)
    {
        $criteria = array("slug" => $segment);
        $segment = $this->otpSegmentManager->findOneBy($criteria);
        if($segment == null){
            throw new OtpException(500, "unknow segment");
        }
        $line = new OtpLine();
        $line->setSegment($segment);
        $line->setIdentity($identity);
        $line->setEmail($email);
        $line->setMobile($mobile);
        $otp = $this->generateOtp($segment->getSize());
        $line->setOtp($otp);
        $line->setStatus(false);
        $line = $this->otpLineManager->save($line);

        if($segment->getSms()){
            $this->sms($segment->getName(), $line->getMobile(), "Code OTP " . $otp, "CM");
        }

        if($segment->getEmail()){
            $this->mail($segment->getName(), "Code OTP", $line->getEmail(), "Code OTP ". $otp);
        }

        return $line->getOtp();
    }

    public function confirmOtpLine(string $segment, string $identity, ?string $otp)
    {
        $criteria = array("slug" => $segment);
        $segment = $this->otpSegmentManager->findOneBy($criteria);
        if($segment == null){
            throw new OtpException(500, "unknow segment");
        }
        $criteria = array("identity" => $identity, "segment" => $segment, "status" => false);
        $order = array("id" => "DESC");
        $lines = $this->otpLineManager->findBy($criteria, $order);
        if($lines == null){
            throw new OtpException(500, "unknow line");
        }
        $line = $lines[0];
        if($line->getOtp() != $otp){
            throw new OtpException(500, "invalid otp");
        }
        $line->setStatus(true);
        $line->setOtp(null);
        $line = $this->otpLineManager->save($line);
        return true;
    }

    public function sms(string $sender, string $phone, string $message, $country = "CM")
    {
        $sms = array('sender' => $sender,
            'phone' => $phone,
            'message' => $message,
            'country' => $country
            );
        return $this->http->asyncPOST($this->params->get('messaging_sms'), $sms);

    }

    public function mail(string $sender, string $object, string $email, string $message)
    {
        $email = array('sender' => $sender,
                     'object' => $object,
                     'email' => $email,
                     'message' => $message
                );
        $response = $this->http->sendPost($this->params->get('messaging_mail'), $email);
        return $response;
    }
   
    public function generateOtp($length = 6) : string
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getAllOtpSegment(){
        $query = $this->entityManagerInterface->createQuery(
            'SELECT o
             FROM App\Entity\OtpSegment o
            '
        );

        $result = $query->getResult();
        return  $result;
    }

    public function editOtpSegment(
        $slug,
        $name,
        $sms,
        $email,
        $size,
        $otpSegment
    ){
        $otpSegment->setSlug($slug);
        $otpSegment->setName($name);
        $otpSegment->setSms($sms);
        $otpSegment->setEmail($email);
        $otpSegment->setSize($size);

        $this->otpSegmentManager->save($otpSegment);

        return $otpSegment;
    }

    public function getOtpSegment($id){
        $otpSegment = $this->otpSegmentManager->find($id);
        return $otpSegment;
    }
    
}