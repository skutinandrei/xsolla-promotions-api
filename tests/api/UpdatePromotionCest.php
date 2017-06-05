<?php


class UpdatePromotionCest
{
    public function _before(ApiTester $I)
    {
        $I->amHttpAuthenticated(MERCHANT_ID, API_KEY);
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    public function _after(ApiTester $I)
    {
    }

    public function updateValidPromotion(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->updatePromotion(
                MERCHANT_ID, 
                $promotionId[0], 
                'testTechnicalNameUpdate', 
                'testLabelUpdate', 
                'testNameUpdate', 
                'testDescriptionUpdate', 
                PROJECT_ID
        );
        $I->seeResponseCodeIs(204);
        $I->getPromotion(MERCHANT_ID, $promotionId[0]);
        $I->seeResponseContainsJson([
            'id' => $promotionId[0],
            'project_id' => PROJECT_ID,
            'technical_name' => 'testTechnicalNameUpdate',
            'label' => [
                'en' => 'testLabelUpdate'
            ],
            'name' => [
                'en' => 'testNameUpdate'
            ],
            'description' => [
                'en' => 'testDescriptionUpdate'
            ],
            'read_only' => false,
            'enabled' => false           
        ]);
    }
    
    public function updatePromotionWithBlankTechnicalName(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->updatePromotion(
                MERCHANT_ID, 
                $promotionId[0], 
                null, 
                'testLabelUpdate', 
                'testNameUpdate', 
                'testDescriptionUpdate', 
                PROJECT_ID
        );
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "technical_name" => [
                    "This value should not be blank."
                ]          
        ]);
    }
    
    public function updatePromotionWithInvalidTypeOfTechnicalName(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->updatePromotion(
                MERCHANT_ID, 
                $promotionId[0], 
                123, 
                'testLabelUpdate', 
                'testNameUpdate', 
                'testDescriptionUpdate', 
                PROJECT_ID
        );
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "technical_name" => [
                    "This value should be of type string."
                ]          
        ]);
    }
    
    public function updatePromotionWithBlankProjectId(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->updatePromotion(
                MERCHANT_ID, 
                $promotionId[0], 
                'testTechnicalNameUpdate', 
                'testLabelUpdate', 
                'testNameUpdate', 
                'testDescriptionUpdate', 
                null
        );
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "project_id" => [
                    "This value should not be blank."
                ]          
        ]);
    }
    
    public function updatePromotionWithInvalidTypeOfProjectId(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->updatePromotion(
                MERCHANT_ID, 
                $promotionId[0], 
                'testTechnicalNameUpdate', 
                'testLabelUpdate', 
                'testNameUpdate', 
                'testDescriptionUpdate', 
                'abc'
        );
        $I->seeResponseCodeIs(422);
        $I->seeResponseContains('This value is not valid:');
    }
    
    public function updatePromotionWithNegativeProjectId(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->updatePromotion(
                MERCHANT_ID, 
                $promotionId[0], 
                'testTechnicalNameUpdate', 
                'testLabelUpdate', 
                'testNameUpdate', 
                'testDescriptionUpdate', 
                -1
        );
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "project_id" => [
                    "The value must be integer and more than zero."
                ]          
        ]);
    }
    
    public function updatePromotionWithZeroProjectId(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->updatePromotion(
                MERCHANT_ID, 
                $promotionId[0], 
                'testTechnicalNameUpdate', 
                'testLabelUpdate', 
                'testNameUpdate', 
                'testDescriptionUpdate', 
                0
        );
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "project_id" => [
                    "The value must be integer and more than zero."
                ]          
        ]);
    }
}
