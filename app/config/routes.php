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
    'controller' => 'admin',
    'action' => 'users'
  ],

  PATH . "/admin/products" => [
    'controller' => 'admin',
    'action' => 'products'
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

  PATH . "addDelToCart" => [
    'controller' => 'cart',
    'action' => 'addDelToCartHandler'
  ],

  PATH . "currentSqyProducts" => [
    'controller' => 'cart',
    'action' => 'currentSqyProductsHandler'
  ],

  PATH . "getUserProducts" => [
    'controller' => 'admin',
    'action' => 'getUserProductsHandler'
  ],

  PATH . "deleteUser" => [
    'controller' => 'admin',
    'action' => 'deleteUserHandler'
  ],

  PATH . "getTargetProduct" => [
    'controller' => 'admin',
    'action' => 'getTargetProductHandler'
  ],

  PATH . "changeProduct" => [
    'controller' => 'admin',
    'action' => 'changeProductHandler'
  ],

  PATH . "addImageDd" => [
    'controller' => 'admin',
    'action' => 'addImageDdHandler'
  ],

  PATH . "deleteProduct" => [
    'controller' => 'admin',
    'action' => 'deleteProductHandler'
  ],

  PATH . "addNewProduct" => [
    'controller' => 'admin',
    'action' => 'addNewProductHandler'
  ],

  PATH . "addNewCategory" => [
    'controller' => 'admin',
    'action' => 'addNewCategoryHandler'
  ],

  PATH . "getAllCategory" => [
    'controller' => 'admin',
    'action' => 'getAllCategoryHandler'
  ],

  PATH . "deleteCategory" => [
    'controller' => 'admin',
    'action' => 'deleteCategoryHandler'
  ],

  PATH . "getProductsBySearch" => [
    'controller' => 'admin',
    'action' => 'getProductsBySearchHandler'
  ],

  PATH . "getUsersBySearch" => [
    'controller' => 'admin',
    'action' => 'getUsersBySearchHandler'
  ],
];
