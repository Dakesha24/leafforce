  <?php

  use CodeIgniter\Router\RouteCollection;

  /**
   * @var RouteCollection $routes
   */
  $routes->get('/', 'Home::index');
  $routes->get('home/content', 'Home::content');
  $routes->get('product/(:any)', 'Product::detail/$1');

  // admin
  $routes->get('admin', 'AdminController::login');
  $routes->group('admin', function ($routes) {
    $routes->get('login', 'AdminController::login');
    $routes->post('auth', 'AdminController::auth');
    $routes->get('dashboard', 'AdminController::dashboard', ['filter' => 'adminAuth']);
    $routes->get('logout', 'AdminController::logout');

    $routes->get('categories', 'AdminController::categories', ['filter' => 'adminAuth']);
    $routes->post('categories/add', 'AdminController::addCategory', ['filter' => 'adminAuth']);
    $routes->get('products', 'AdminController::products', ['filter' => 'adminAuth']);
    $routes->post('products/add', 'AdminController::addProduct', ['filter' => 'adminAuth']);
    $routes->post('categories/edit/(:num)', 'AdminController::editCategory/$1');
    $routes->get('categories/check-relations/(:num)', 'AdminController::checkRelations/$1');
    $routes->post('categories/delete/(:num)', 'AdminController::deleteCategory/$1');
    $routes->post('products/edit/(:num)', 'AdminController::editProduct/$1');
    $routes->post('products/delete/(:num)', 'AdminController::deleteProduct/$1');
    $routes->get('products/get-variants/(:num)', 'AdminController::getProductVariants/$1');
    $routes->get('products/get-variants/(:num)', 'AdminController::getProductVariants/$1', ['filter' => 'adminAuth']);
  });
