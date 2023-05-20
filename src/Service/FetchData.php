<?php

namespace App\Service;

/**
 * FetchData
 */
class FetchData {

  /**
   * userData - It will store the user's personal data.
   *
   * @var array
   */
  private $userData = Array();

  /**
   * This function is communicates with database and also display user's
   * credentials.
   * It will be verify that the is $userEmail is exiting or not
   * if exists then fetch all the user's credentials and
   * then render back to edit profile page with all the credentails.
   *
   *   @param  mixed $userRepo
   *     It store the object of UserRepository class and also fetch data from
   *     database.
   *   @param  mixed $request
   *     This Request object is to handles the session.
   *   @param  string $userEmail
   *     It store the user email.
   *   @return array
   *     If user exits then it will reurn an array $userData which consists user's
   *     data otherwise null.
   */
  public function fetchUserProfile($userRepo, $request, $userEmail) {
    $session = $request->getSession();
    $fetchCredentials = $userRepo->findOneBy([ 'userEmail' => $userEmail ]);

    // If $fetchCredentials will not return null that means user exits,
    // then fetch all the data after that render to the edit profile page with
    // values.
    // If due to any reason $fetchCredentails return null then redirect to the
    // home page.
    if($fetchCredentials) {
      $fetchImage = $fetchCredentials->getUserImage();
      $session->set('loggedImage', $fetchImage);

      $this->userData['user_name'] = $fetchCredentials->getUserName();
      $this->userData['first_name'] = $fetchCredentials->getUserFirstName();
      $this->userData['middle_name'] = $fetchCredentials->getUserMiddleName();
      $this->userData['last_name'] = $fetchCredentials->getUserLastName();
      $this->userData['user_mobile'] = $fetchCredentials->getUserMobile();
      $this->userData['user_email'] = $fetchCredentials->getUserEmail();
      $this->userData['user_age'] = $fetchCredentials->getUserAge();
      $this->userData['user_city'] = $fetchCredentials->getUserCity();
      $this->userData['user_country'] = $fetchCredentials->getUserCountry();
      $this->userData['user_gender'] = $fetchCredentials->getUserGender();
      $this->userData['user_interest'] = $fetchCredentials->getUserInterests();
      $this->userData['user_image'] = $fetchImage;

      return $this->userData;
    }
    return null;
  }

}

?>
