<?php

/**
 * The class describes view actions for a Product.
 */

class ProductView
{
    /**
     * The method gets all products.
     * Return template parametrs.
     *
     * @return array
     */
    static public function getAll ($entityManager)
    {
        $pdb = new ProductDB($entityManager);
        $products = $pdb->getAll();

        $templateParams = [
            'template' => 'list_products.phtml',
            'params'   => [
                'title'    => 'Список товаров',
                'products' => $products
            ]
        ];
        return $templateParams;
    }
}

