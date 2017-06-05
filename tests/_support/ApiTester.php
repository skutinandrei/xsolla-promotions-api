<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

   /**
    * Define custom actions here
    */
    
   public function createNewPromotion($merchantId, $technicalName, $label, $name, $description, $projectId)
   {
       $I = $this;
       $I->sendPOST(
            'merchant/merchants/' . $merchantId . '/promotions', 
            array (
                'technical_name' => $technicalName,
                'label' =>
                    array (
                        'en' => $label,
                    ),
                'name' =>
                    array (
                        'en' => $name,
                    ),
                'description' =>
                    array (
                        'en' => $description,
                    ),
                'project_id' => $projectId,
            )
        );
   }
   
   public function getPromotion($merchantId, $promotionId)
   {
       $I = $this;
       $I->sendGET('merchant/merchants/' . $merchantId . '/promotions/' . $promotionId);
   }
   
   public function updatePromotion($merchantId, $promotionId, $technicalName, $label, $name, $description, $projectId)
   {
       $I = $this;
       $I->sendPUT(
               'merchant/merchants/' . $merchantId . '/promotions/' . $promotionId,
               array (
                'technical_name' => $technicalName,
                'label' =>
                    array (
                        'en' => $label,
                    ),
                'name' =>
                    array (
                        'en' => $name,
                    ),
                'description' =>
                    array (
                        'en' => $description,
                    ),
                'project_id' => $projectId,
            )
        );
   }
   
   public function deletePromotion($merchantId, $promotionId)
   {
       $I = $this;
       $I->sendDELETE('merchant/merchants/' . $merchantId . '/promotions/' . $promotionId);
   }
   
   public function togglePromotion($merchantId, $promotionId)
   {
       $I = $this;
       $I->sendPUT('merchant/merchants/' . $merchantId . '/promotions/' . $promotionId . '/toggle');
   }

}

