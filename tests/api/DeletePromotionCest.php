<?php


class DeletePromotionCest
{
    public function _before(ApiTester $I)
    {
        $I->amHttpAuthenticated(MERCHANT_ID, API_KEY);
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    public function _after(ApiTester $I)
    {
    }

    public function deletePromotion(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->deletePromotion(MERCHANT_ID, $promotionId[0]);
        $I->seeResponseCodeIs(204);
        $I->getPromotion(MERCHANT_ID, $promotionId[0]);
        $I->seeResponseCodeIs(404);
    }
    
    public function deleteEnabledPromotion(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->togglePromotion(MERCHANT_ID, $promotionId[0]);
        $I->seeResponseCodeIs(204);
        $I->deletePromotion(MERCHANT_ID, $promotionId[0]);
        $I->seeResponseCodeIs(204);
        $I->getPromotion(MERCHANT_ID, $promotionId[0]);
        $I->seeResponseCodeIs(404);
    }
    
    public function deletePromotionWithBlankPromotionId(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->deletePromotion(MERCHANT_ID, '');
        $I->seeResponseCodeIs(404);
    }
    
    public function deletePromotionWithInvalidPromotionId(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->deletePromotion(MERCHANT_ID, 'abc');
        $I->seeResponseCodeIs(404);
    }
}
