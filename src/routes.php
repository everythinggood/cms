<?php

// Routes

//$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//    // Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//    // Render index view
//    return $this->renderer->render($response, 'index.phtml', $args);
//});

$container = $app->getContainer();

$app->get('/view/login', \Cms\Controller\ViewController::class . ":login");

$app->post('/admin/login', \Cms\Controller\UserController::class . ':login');

$app->group('/admin', function () {

    $this->post('/question/add', \Cms\Controller\QuestionController::class . ':add');

    $this->post('/user/add', \Cms\Controller\UserController::class . ':add');

    $this->post('/question/delete', \Cms\Controller\QuestionController::class . ':delete');

    $this->get('/adIntentions', \Cms\Controller\AdIntentionController::class . ':findAll');

    $this->get('/sellerIntentions', \Cms\Controller\SellerIntentionController::class . ":findAll");

    $this->post('/sellerIntention/handle',\Cms\Controller\SellerIntentionController::class.':handle');

    $this->get('/sellerIntention/exportCsv',\Cms\Controller\SellerIntentionController::class.':exportCsv');

    $this->get('/sellerFeedbacks', \Cms\Controller\SellerFeedBackController::class . ":findAll");

    $this->get('/userFeedbacks', \Cms\Controller\UserFeedBackController::class . ":findAll");

    $this->post('/question/pushTop', \Cms\Controller\QuestionController::class . ":pushTop");

    $this->post('/userFeedback/handle', \Cms\Controller\UserFeedBackController::class . ":handle");

    $this->post('/sellerFeedback/handle', \Cms\Controller\SellerFeedBackController::class . ':handle');

    $this->post('/article/add', \Cms\Controller\ArticleController::class . ':add');

    $this->get('/article/list', \Cms\Controller\ArticleController::class . ':details');

    $this->get('/article/{id:[0-9]+}', \Cms\Controller\ArticleController::class . ':detail');

    $this->post('/article/remove', \Cms\Controller\ArticleController::class . ':remove');

    $this->post('/article/edit', \Cms\Controller\ArticleController::class . ':edit');

    $this->get('/article/pushTop/{id:[0-9]+}', \Cms\Controller\ArticleController::class . ':pushTop');

    $this->get('/article/tops', \Cms\Controller\ArticleController::class . ':tops');

    $this->post('/metadata/add', \Cms\Controller\MetaDataController::class . ':add');

    $this->post('/metadata/edit/{id}', \Cms\Controller\MetaDataController::class . ':edit');

    $this->post('/metadata/remove', \Cms\Controller\MetaDataController::class . ':remove');

    $this->post('/metadata/upload',\Cms\Controller\MetaDataController::class.':upload');

    $this->get('/metadata/{id:[0-9]+}', \Cms\Controller\MetaDataController::class . ':find');

    $this->get('/metadata/arr', \Cms\Controller\MetaDataController::class . ':getMetaDataArr');

    $this->get('/metadata/list', \Cms\Controller\MetaDataController::class . ':metadataList');

    $this->post('/navigation/add', \Cms\Controller\NavigationController::class . ':add');

    $this->post('/navigation/edit', \Cms\Controller\NavigationController::class . ':edit');

    $this->get('/navigation/{id:[0-9]+}', \Cms\Controller\NavigationController::class . ':find');

    $this->post('/navigation/remove', \Cms\Controller\NavigationController::class . ':remove');

    $this->get('/navigation/arr', \Cms\Controller\NavigationController::class . ':navigationArr');

    $this->get('/navigation/list',\Cms\Controller\NavigationController::class.':navigationList');

    $this->get('/wechatUsers',\Cms\Controller\WeChatUserController::class.':users');

    $this->get('/chartsTops',\Cms\Controller\ChartsController::class.':tops');

});

$app->group('/front', function () {

    $this->post('/adIntention/add', \Cms\Controller\AdIntentionController::class . ':add');

    $this->post('/sellerIntention/add', \Cms\Controller\SellerIntentionController::class . ':add');

    $this->map(['GET', 'POST'], '/questions', \Cms\Controller\QuestionController::class . ':getAllByPage');

    $this->post('/sellerFeedback/add', \Cms\Controller\SellerFeedBackController::class . ':add');

    $this->post('/userFeedback/add', \Cms\Controller\UserFeedBackController::class . ':add');

    $this->post('/tag/add', \Cms\Controller\TagController::class . ':add');

});

$app->group('/view', function () {

    $this->get('/questions', \Cms\Controller\ViewController::class . ":questions");

    $this->get('/question/editor/{id}', \Cms\Controller\ViewController::class . ':questionEditor');

    $this->get('/question/create', \Cms\Controller\ViewController::class . ":questionCreate");

    $this->get('/adIntentions', \Cms\Controller\ViewController::class . ':adIntentions');

    $this->get('/sellerIntentions', \Cms\Controller\ViewController::class . ':sellerIntentions');

    $this->get('/userFeedbacks', \Cms\Controller\ViewController::class . ':userFeedbacks');

    $this->get('/sellerFeedbacks', \Cms\Controller\ViewController::class . ':sellerFeedbacks');

    $this->get('/articles', \Cms\Controller\ViewController::class . ':articles');

    $this->get('/article/create',\Cms\Controller\ViewController::class.':articleCreate');

    $this->get('/article/editor/{id}',\Cms\Controller\ViewController::class.':articleEditor');

    $this->get('/navigations',\Cms\Controller\ViewController::class.':navigations');

    $this->get('/navigation/create',\Cms\Controller\ViewController::class.':navigationCreate');

    $this->get('/navigation/editor/{id}',\Cms\Controller\ViewController::class.':navigationEditor');

    $this->get('/metadatas',\Cms\Controller\ViewController::class.':metadatas');

    $this->get('/metadata/create',\Cms\Controller\ViewController::class.':metadataCreate');

    $this->get('/metadata/editor/{id}',\Cms\Controller\ViewController::class.':metadataEditor');

    $this->get('/topCharts',\Cms\Controller\ViewController::class.':topCharts');

    $this->get('/wechatUsers',\Cms\Controller\ViewController::class.':weChatUsers');

})->add($container['sessionMiddleware']);

$app->group('/front/view', function () {

    $this->get('/userFeedback', \Cms\Controller\FrontViewController::class . ":userFeedback");
    $this->get('/sellerFeedback', \Cms\Controller\FrontViewController::class . ":sellerFeedback");
    $this->get('/adIntention', \Cms\Controller\FrontViewController::class . ":adIntention");
    $this->get('/sellerIntention', \Cms\Controller\FrontViewController::class . ":sellerIntention");
    $this->get('/sellerQuestions', \Cms\Controller\FrontViewController::class . ":sellerQuestions");
    $this->get('/userQuestions', \Cms\Controller\FrontViewController::class . ":userQuestions");
    $this->get('/sellerTopQuestions', \Cms\Controller\FrontViewController::class . ":sellerTopQuestions");
    $this->get('/sellerQuestionCategorys', \Cms\Controller\FrontViewController::class . ":sellerQuestionCategorys");
    $this->get('/question/{id}', \Cms\Controller\FrontViewController::class . ":question");
    $this->get('/success', \Cms\Controller\FrontViewController::class . ":success");
    $this->get('/paper', \Cms\Controller\FrontViewController::class . ":paper");
    //官网
    $this->get('/index',\Cms\Controller\FrontViewController::class.':index');
    $this->get('/successList',\Cms\Controller\FrontViewController::class.':successList');
    $this->get('/contact',\Cms\Controller\FrontViewController::class.':contact');
    $this->get('/team',\Cms\Controller\FrontViewController::class.':team');
    $this->get('/adIntentionLook',\Cms\Controller\FrontViewController::class.':adIntentionLook');
    $this->get('/deviceInfo',\Cms\Controller\FrontViewController::class.':deviceInfo');
    $this->get('/jobInfo',\Cms\Controller\FrontViewController::class.':jobInfo');

});

$app->get('/',\Cms\Controller\FrontViewController::class.':index');

$app->group('/activity',function (){

    $this->get('/upWorks',\Cms\Controller\FrontViewController::class.':upWorks');
    $this->get('/submitWorks',\Cms\Controller\FrontViewController::class.':submitWorks');
    $this->get('/myWorks',\Cms\Controller\FrontViewController::class.':myWorks');

    $this->post('/work/add',\Cms\Controller\WorkController::class.':add');
    $this->post('/vote/add',\Cms\Controller\VoteController::class.':add');
    $this->get('/charts/top100',\Cms\Controller\ChartsController::class.':top100');

})->add($container['weChatUserSessionMiddleware']);

$app->any('/oauth/callback',\Cms\Wechat\OauthCallback::class.':officialAccount');
