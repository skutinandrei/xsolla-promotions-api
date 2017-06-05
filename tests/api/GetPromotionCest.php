<?php


class GetPromotionCest
{
    public function _before(ApiTester $I)
    {
        $I->amHttpAuthenticated(MERCHANT_ID, API_KEY);
        $I->haveHttpHeader('Content-Type', 'application/json');
    }

    public function _after(ApiTester $I)
    {
    }

    public function getValidPromotion(ApiTester $I)
    {
        $I->createNewPromotion(MERCHANT_ID, 'testTechnicalName', 'testLabel', 'testName', 'testDescription', PROJECT_ID);
        $promotionId = $I->grabDataFromResponseByJsonPath('$id');
        $I->getPromotion(MERCHANT_ID, $promotionId[0]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'id' => $promotionId[0],
            'project_id' => PROJECT_ID,
            'technical_name' => 'testTechnicalName',
            'label' => [
                'en' => 'testLabel'
            ],
            'name' => [
                'en' => 'testName'
            ],
            'description' => [
                'en' => 'testDescription'
            ],
            'read_only' => false,
            'enabled' => false           
        ]);
    }
    
    public function getPromotionWithBlankPromotionId(ApiTester $I)
    {
        $I->getPromotion(MERCHANT_ID, '');
        $I->seeResponseCodeIs(404);
    }
    
    public function getPromotionWithInvalidPromotionId(ApiTester $I)
    {
        $I->getPromotion(MERCHANT_ID, 'abc');
        $I->seeResponseCodeIs(404);
    }
}

