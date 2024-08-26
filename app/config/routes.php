<?
return [
  PATH . "/" => [
    'controller' => 'main',
    'action' => 'index'
  ],

  PATH . "/search" => [
    'controller' => 'search',
    'action' => 'index'
  ],

  PATH . "/signup" => [
    'controller' => 'signup',
    'action' => 'index'
  ],

  PATH . "/signin" => [
    'controller' => 'signin',
    'action' => 'index'
  ],

  PATH . "/cart" => [
    'controller' => 'cart',
    'action' => 'index'
  ],

  PATH . "/admin" => [
    'controller' => 'admin',
    'action' => 'index'
  ],

  PATH . "/admin/users" => [
    'controller' => 'adminUsers',
    'action' => 'index'
  ],

  PATH . "/admin/products" => [
    'controller' => 'adminProducts',
    'action' => 'index'
  ],

  // Fetch routes
  // обработчики
  PATH . "categoryProductsHandler" => [
    'controller' => 'main',
    'action' => 'categoryProductsHandler'
  ],

  PATH . "addToFavourites" => [
    'controller' => 'main',
    'action' => 'addToFavouritesHandler'
  ],

  PATH . "deleteToFavourites" => [
    'controller' => 'main',
    'action' => 'deleteToFavouritesHandler'
  ],

  PATH . "addToCart" => [
    'controller' => 'main',
    'action' => 'addToCartHandler'
  ],
];