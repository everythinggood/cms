<?php

// Routes

//$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//    // Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//    // Render index view
//    return $this->renderer->render($response, 'index.phtml', $args);
//});


$app->get('/view/login', \Cms\Controller\ViewController::class . ":login");

$app->post('/admin/login', \Cms\Controller\UserController::class . ':login');

$app->group('/admin', function () {

    $this->post('/question/add', \Cms\Controller\QuestionController::class . ':add');

    $this->post('/user/add', \Cms\Controller\UserController::class . ':add');

    $this->post('/question/delete', \Cms\Controller\QuestionController::class . ':delete');

    $this->get('/adIntentions', \Cms\Controller\AdIntentionController::class . ':findAll');

    $this->get('/sellerIntentions', \Cms\Controller\SellerIntentionController::class . ":findAll");

    $this->get('/sellerFeedbacks', \Cms\Controller\SellerFeedBackController::class . ":findAll");

    $this->get('/userFeedbacks', \Cms\Controller\UserFeedBackController::class . ":findAll");

    $this->post('/question/pushTop', \Cms\Controller\QuestionController::class . ":pushTop");

    $this->post('/userFeedback/handle', \Cms\Controller\UserFeedBackController::class . ":handle");

    $this->post('/sellerFeedback/handle', \Cms\Controller\SellerFeedBackController::class . ':handle');

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
})->add($app->getContainer()['sessionMiddleware']);

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
    $this->get('/paper',\Cms\Controller\FrontViewController::class.":paper");

});
