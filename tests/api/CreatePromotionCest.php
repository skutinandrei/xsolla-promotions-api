<?php


class CreatePromotionCest
{
    public function _before(ApiTester $I)
    {
        $I->amHttpAuthenticated(MERCHANT_ID, API_KEY);
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    public function _after(ApiTester $I)
    {
    }

    public function createValidPromotion(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $I->seeResponseCodeIs(201);
        $I->seeResponseMatchesJsonType([
            'id' => 'integer'
        ]);
    }
    
    public function createPromotionWithBlankTechnicalName(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, null, 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "technicalName" => [
                    "This value should not be blank."
                ]          
        ]);
    }
    
    public function createPromotionWithInvalidTypeOfTechnicalName(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 123, 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "technical_name" => [
                    "This value should be of type string."
                ]          
        ]);
    }
    
    public function createPromotionWithBlankProjectId(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', null);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "projectId" => [
                    "This value should not be blank."
                ]          
        ]);
    }
    
    public function createPromotionWithInvalidTypeOfProjectId(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', 'text');
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "project_id" => [
                    "This value should be of type integer."
                ]          
        ]);
    }
    
    public function createPromotionWithNegativeProjectId(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', -1);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "projectId" => [
                    "The value must be integer and more than zero."
                ]          
        ]);
    }
    
    public function createPromotionWithZeroProjectId(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', 0);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
                "projectId" => [
                    "The value must be integer and more than zero."
                ]          
        ]);
    }
}
