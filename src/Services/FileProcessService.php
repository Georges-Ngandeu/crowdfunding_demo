<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 01/04/2020
 * Time: 16:37
 */

namespace App\Services;


class FileProcessService
{
    public function UploadImage($uploadedFile, $project){
        $originalImageName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeImageName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalImageName);
        $newImageName = $safeImageName.'-'.uniqid().'.'.$uploadedFile->guessExtension();

        // Create upload directory if it does not exist
        if(!is_dir($project::SERVER_PATH_TO_IMAGE_FOLDER ."/".$this->formatProjectFolderName($project->getProjectName())."/")) {
            mkdir($project::SERVER_PATH_TO_IMAGE_FOLDER ."/".$this->formatProjectFolderName($project->getProjectName())."/");
        }

        // move takes the target directory and target filename as params
        $uploadedFile->move(
            $project::SERVER_PATH_TO_IMAGE_FOLDER ."/".$this->formatProjectFolderName($project->getProjectName())."/" ,
            $newImageName
        );

        //get project name
        $projectName = $project->getProjectName();

        //check if the field exist in the database
        $images = $project->getProjectImages();

        if(isset($images[$projectName])){
            array_push($images[$projectName], $newImageName);

            // set the path property to the filename where you've saved the file
            $project->setProjectImages($images);

            // clean up the file property as you won't need it anymore
            $project->setImagefile(null);

            return $project;
        }
        else{
            //define image storage array
            $imageStorage[$projectName] = array();

            //push image in the array
            array_push($imageStorage[$projectName], $newImageName);

            // set the path property to the image where you've saved the file
            $project->setProjectImages($imageStorage);

            // clean up the file property as you won't need it anymore
            $project->setImagefile(null);

            return $project;
        }
    }

    public function UploadDocument($uploadedFile, $project){
        $originalImageName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeImageName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalImageName);
        $newImageName = $safeImageName.'-'.uniqid().'.'.$uploadedFile->guessExtension();

        // Create upload directory if it does not exist
        if(!is_dir($project::SERVER_PATH_TO_IMAGE_FOLDER ."/".$this->formatProjectFolderName($project->getProjectName())."/")) {
            mkdir($project::SERVER_PATH_TO_IMAGE_FOLDER ."/".$this->formatProjectFolderName($project->getProjectName())."/");
        }

        // move takes the target directory and target filename as params
        $uploadedFile->move(
            $project::SERVER_PATH_TO_IMAGE_FOLDER ."/".$this->formatProjectFolderName($project->getProjectName())."/" ,
            $newImageName
        );

        //get project name
        $projectName = $project->getProjectName();

        //check if the field exist in the database
        $documents = $project->getProjectDocuments();

        if(isset($documents[$projectName])){
            array_push($documents[$projectName], $newImageName);

            // set the path property to the filename where you've saved the file
            $project->setProjectDocuments($documents);

            // clean up the file property as you won't need it anymore
            $project->setDocumentfile(null);

            return $project;
        }
        else{
            //define image storage array
            $documentStorage[$projectName] = array();

            //push image in the array
            array_push($documentStorage[$projectName], $newImageName);

            // set the path property to the image where you've saved the file
            $project->setProjectDocuments($documentStorage);

            // clean up the file property as you won't need it anymore
            $project->setDocumentfile(null);

            return $project;
        }
    }

    public function UploadMainImage($uploadedFile, $project){
        $originalImageName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeImageName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalImageName);
        $newImageName = $safeImageName.'-'.uniqid().'.'.$uploadedFile->guessExtension();

        // Create upload directory if it does not exist
        if(!is_dir($project::SERVER_PATH_TO_IMAGE_FOLDER ."/".$this->formatProjectFolderName($project->getProjectName())."/")) {
            mkdir($project::SERVER_PATH_TO_IMAGE_FOLDER ."/".$this->formatProjectFolderName($project->getProjectName())."/");
        }

        // move takes the target directory and target filename as params
        $uploadedFile->move(
            $project::SERVER_PATH_TO_IMAGE_FOLDER ."/".$this->formatProjectFolderName($project->getProjectName())."/" ,
            $newImageName
        );

        $project->setProjectMainimage($newImageName);
    }

    public function  formatProjectFolderName($projectName){

        $splittedData = explode(" ",$projectName);

        $formattedName = "";
        foreach($splittedData as $key => $data){

            $formattedName = $formattedName."_".$data;
        }

        return $formattedName;
    }

    
    public function formattedProjectName($projectName)
    {
        $splittedData = explode(" ",$projectName);

        $formattedName = "";
        foreach($splittedData as $key => $data){

            $formattedName = $formattedName."_".$data;
        }

        return $formattedName;
    }

    public function UploadBankReceipt($uploadedFile, $project, $userProject){
        $originalImageName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeImageName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalImageName);
        $newImageName = $safeImageName.'-'.uniqid().'.'.$uploadedFile->guessExtension();

        // Create upload directory if it does not exist
        if(!is_dir($project::SERVER_PATH_TO_IMAGE_FOLDER ."/bank_receipts/")) {
            mkdir($project::SERVER_PATH_TO_IMAGE_FOLDER ."/bank_receipts/");
        }

        // move takes the target directory and target filename as params
        $uploadedFile->move(
            $project::SERVER_PATH_TO_IMAGE_FOLDER ."/bank_receipts/" ,
            $newImageName
        );

        $userProject->setReceiptImage($newImageName);

        $userProject->setImagefile(null);
    }

    public function UploadSubscriberImage($uploadedFile, $subscriber){
        $originalImageName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeImageName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalImageName);
        $newImageName = $safeImageName.'-'.uniqid().'.'.$uploadedFile->guessExtension();

        // Create upload directory if it does not exist
        if(!is_dir($subscriber::SERVER_PATH_TO_IMAGE_FOLDER ."/subscriber_images/")) {
            mkdir($subscriber::SERVER_PATH_TO_IMAGE_FOLDER ."/subscriber_images/");
        }

        // move takes the target directory and target filename as params
        $uploadedFile->move(
            $subscriber::SERVER_PATH_TO_IMAGE_FOLDER ."/subscriber_images/" ,
            $newImageName
        );

        $subscriber->setSubscriberImage($newImageName);

        $subscriber->setImagefile(null);
    }

}